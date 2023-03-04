<?php

namespace Src\Models;

use Src\Core\Database\Model;

class CartItemModel extends Model
{
    protected string $table = 'cart_items';

    public function rules(): array
    {
        return [
            'product_id' => [self::RULE_REQUIRED],
            'quantity' => [self::RULE_REQUIRED, [self::RULE_MAX_LENGTH, 'max_length' => 11]]
        ];
    }
}
