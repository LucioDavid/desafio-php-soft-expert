<?php

namespace Src\Models;

use Src\Core\Database\Model;

class CategoryModel extends Model
{
    protected string $table = 'categories';
    protected ?string $tableSingular = 'category';

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 50]],
            'sku' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 10], [
                self::RULE_UNIQUE, 'class' => self::class, 'field' => 'Category Code'
            ]],
            'tax_percentage' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 11], [self::RULE_MIN, 'min' => 0]],
        ];
    }
}
