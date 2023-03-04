<?php

namespace Src\Core\Database;

use DateTime;
use PDO;
use Src\Core\Application;
use Src\Core\Http\Request;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MIN_LENGTH = 'min_length';
    public const RULE_MAX_LENGTH = 'max_length';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public ?PDO $db = null;

    protected string $table;
    protected ?string $tableSingular = null;

    private array $errors = [];

    public function __construct()
    {
        $this->db = Application::$db->getConnection();
    }

    abstract public function rules(): array;

    public function validate(Request $request)
    {
        $data = $request->getBody();
        foreach ($this->rules() as $attribute => $rules) {
            $value = $data[$attribute] ?? null;
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addError($attribute, self::RULE_REQUIRED, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_MIN && floatval($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_MIN_LENGTH && strlen($value) < $rule['min_length']) {
                    $this->addError($attribute, self::RULE_MIN_LENGTH, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_MAX_LENGTH && strlen($value) > $rule['max_length']) {
                    $this->addError($attribute, self::RULE_MAX_LENGTH, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
                    continue;
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = new $rule['class']();
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className->table;
                    $db = Application::$db->getConnection();
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    $idInRequest = isset($request->params[0])
                        ? intval($request->params[0])
                        : null;
                    if ($record and $record->id !== $idInRequest) {
                        $this->addError($attribute, self::RULE_UNIQUE, $rule);
                    }
                    continue;
                }
            }
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function insert(array $data): void
    {
        $columns = implode(', ', array_keys($data));
        $placeholderArray = array_map(fn ($column) => ':' . $column, array_keys($data));
        $placeholders = implode(', ', $placeholderArray);
        $timestamp = $this->getTimestamp();
        $values = array_values($data);
        $params = array_combine($placeholderArray, $values);

        $sql = "INSERT INTO {$this->table} ({$columns},created_at,updated_at)
            VALUES ({$placeholders},{$timestamp},{$timestamp})";

        $this->db->prepare($sql)->execute($params);
    }

    public function update(array $data, array $params): void
    {
        $columns = $this->prepareColumnsToUpdate(array_keys($data));
        $conditions = $this->prepareConditions($params);
        $updatedAt = $this->getTimestamp();
        $values = array_values($data);

        $sql = "UPDATE {$this->table} SET {$columns}, updated_at = {$updatedAt}
            WHERE {$conditions}
        ";

        $this->db->prepare($sql)->execute($values);
    }

    public function find(int $id): array|false
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = {$id}")
            ->fetch(PDO::FETCH_ASSOC);
    }

    public function get(): array
    {
        return $this->db->query("SELECT * FROM {$this->table}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWhere(array $params): array
    {
        $conditions = $this->prepareConditions($params);
        return $this->db->query("SELECT * FROM {$this->table}
            WHERE {$conditions}
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getManyToManyRelationship(Model $relatedModel, Model $relationshipModel, int $id): array
    {
        return $this->db->query("SELECT {$relatedModel->table}.* FROM {$this->table}
            INNER JOIN {$relationshipModel->table} ON {$relationshipModel->table}.{$this->tableSingular}_id = {$this->table}.id
            INNER JOIN {$relatedModel->table} ON {$relatedModel->table}.id = {$relationshipModel->table}.{$relatedModel->tableSingular}_id
            WHERE {$this->table}.id = {$id}
        ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneToManyRelationship(Model $relatedModel, int $id): array
    {
        return $this->db->query("SELECT {$relatedModel->table}.* FROM {$this->table}
            INNER JOIN {$relatedModel->table} ON {$relatedModel->table}.id = {$this->table}.{$relatedModel->tableSingular}_id
            WHERE {$this->table}.id = {$id}
        ")->fetch(PDO::FETCH_ASSOC);
    }

    public function delete(int $id)
    {
        $this->db->prepare("DELETE FROM {$this->table} WHERE id=?")->execute([$id]);
    }

    private function getTimestamp(): string
    {
        $timestamp = new DateTime();
        return $timestamp->format('\'Y-m-d H:i:s\'');
    }

    private function prepareColumnsToUpdate(array $columns): string
    {
        $columns = array_map(
            fn ($column) => $column . '=?',
            $columns
        );
        return implode(', ', $columns);
    }

    private function prepareConditions(array $params): string
    {
        $conditions = array_map(
            fn ($column, $value) => "{$column} = {$value}",
            array_keys($params),
            array_values($params)
        );
        return implode(' AND ', $conditions);
    }

    private function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $message = str_replace("{{$key}}", $value, $message);
            }
        }
        $this->errors[$attribute][] = $message;
    }

    private function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MIN => 'Min value of this field must be {min}',
            self::RULE_MIN_LENGTH => 'Min length of this field must be {min}',
            self::RULE_MAX_LENGTH => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'A record with this {field} already exists',
        ];
    }
}
