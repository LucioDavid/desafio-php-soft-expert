<?php

namespace Src\Models;

use Src\Core\Database\Model;
use Src\Models\CategoryModel;
use Src\Models\CategoryProductModel;

class ProductModel extends Model
{
    protected string $table = 'products';
    protected ?string $tableSingular = 'product';

    public function rules(): array
    {
        return [
            'category_id' => [self::RULE_REQUIRED],
            'name' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 100]],
            'sku' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 10], [
                self::RULE_UNIQUE, 'class' => self::class, 'field' => 'Product SKU'
            ]],
            'price' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 11], [self::RULE_MIN, 'min' => 0.01]],
            'description' => [self::RULE_REQUIRED],
            'quantity' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 11]]
        ];
    }

    public function category(int $productId)
    {
        $categoryModel = new CategoryModel();
        return $this->getOneToManyRelationship($categoryModel, $productId);
    }
}
