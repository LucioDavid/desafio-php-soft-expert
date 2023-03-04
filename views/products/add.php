<h1>New Product</h1>

<div class="row">
    <form action="<?= appUrl('products/store') ?>" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s12">
                <label for="sku">Product SKU</label>
                <input type="text" class="<?= empty($errors['sku']) ? '' : 'invalid' ?>" name="sku" id="sku" value="<?= $inputs['sku'] ?? '' ?>" />
                <?= $this->showErrors($errors['sku'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="name">Product Name</label>
                <input type="text" class="<?= empty($errors['name']) ? '' : 'invalid' ?>" name="name" id="name" value="<?= $inputs['name'] ?? '' ?>" />
                <?= $this->showErrors($errors['name'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="price">Price</label>
                <input type="number" class="<?= empty($errors['price']) ? '' : 'invalid' ?>" step="0.01" name="price" id="price" value="<?= $inputs['price'] ?? '' ?>" />
                <?= $this->showErrors($errors['price'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="quantity">Quantity</label>
                <input type="text" class="<?= empty($errors['quantity']) ? '' : 'invalid' ?>" name="quantity" id="quantity" value="<?= $inputs['quantity'] ?? '' ?>" />
                <?= $this->showErrors($errors['quantity'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <select class="<?= empty($errors['category_id']) ? '' : 'invalid' ?>" name="category_id" id="category">
                    <option value=""></option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?= $category['id'] ?>" <?= (isset($inputs['category_id']) and ($category['id'] === (int) $inputs['category_id'])) ? 'selected' : '' ?>><?= $category['name'] ?></option>
                    <?php } ?>
                </select>
                <label for="category">Category</label>
                <small class="red-text"><?= $errors['category_id'][0] ?? null ?></small>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="description">Description</label>
                <textarea class="materialize-textarea <?= empty($errors['description']) ? '' : 'invalid' ?>" name="description" id="description"><?= $inputs['description'] ?? '' ?></textarea>
                <?= $this->showErrors($errors['description'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <a href="<?= appUrl('products') ?>" class="waves-effect waves-light btn left">Back</a>
                <button class="waves-effect waves-light btn right" type="submit">Save</button>
            </div>
        </div>
    </form>
</div>
