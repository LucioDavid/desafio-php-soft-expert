<h1>Edit Product</h1>

<form action="<?= appUrl("products/update/{$id}") ?>" method="post">
    <div class="input-field">
        <label for="sku" class="label">Product SKU</label>
        <input type="text" name="sku" id="sku" class="input-text" value="<?= $inputs['sku'] ?? $sku ?>" />
        <?= $this->showErrors($errors['sku'] ?? null) ?>
    </div>
    <div class="input-field">
        <label for="name" class="label">Product Name</label>
        <input type="text" name="name" id="name" class="input-text" value="<?= $inputs['name'] ?? $name ?>" />
        <?= $this->showErrors($errors['name'] ?? null) ?>
    </div>
    <div class="input-field">
        <label for="price" class="label">Price</label>
        <input type="number" step="0.01" name="price" id="price" class="input-text" value="<?= $inputs['price'] ?? $price ?>" />
        <?= $this->showErrors($errors['price'] ?? null) ?>
    </div>
    <div class="input-field">
        <label for="quantity" class="label">Quantity</label>
        <input type="text" name="quantity" id="quantity" class="input-text" value="<?= $inputs['quantity'] ?? $quantity ?>" />
        <?= $this->showErrors($errors['quantity'] ?? null) ?>
    </div>
    <div class="input-field">
        <label for="category" class="label">Categories</label>
        <select multiple name="category[]" id="category" class="input-text">
            <?php foreach ($categories as $category) { ?>
                <option value="<?= $category['id'] ?>" <?= isset($inputs['category']) ? ((in_array($category['id'], $inputs['category'])) ? 'selected' : '') : (in_array($category['id'], $product_categories) ? 'selected' : '') ?>><?= $category['name'] ?></option>
            <?php } ?>
        </select>
        <?= $this->showErrors($errors['category'] ?? null) ?>
    </div>
    <div class="input-field">
        <label for="description" class="label">Description</label>
        <textarea name="description" id="description" class="input-text"><?= $inputs['description'] ?? $description ?></textarea>
        <?= $this->showErrors($errors['description'] ?? null) ?>
    </div>
    <div class="actions-form">
        <a href="<?= appUrl('products') ?>" class="action back">Back</a>
        <button class="btn-submit btn-action" type="submit">Save</button>
    </div>

</form>
