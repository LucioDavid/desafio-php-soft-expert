<h1>New Category</h1>

<div class="row">
    <form action="<?= appUrl('categories/store') ?>" method="post" class="col s12">
        <div class="row">
            <div class="input-field col s12">
                <label for="category-name">Name</label>
                <input type="text" class="<?= empty($errors['name']) ? '' : 'invalid' ?>" name="name" id="category-name" value="<?= $inputs['name'] ?? '' ?>" />
                <?= $this->showErrors($errors['name'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="category-code">Code</label>
                <input type="text" class="<?= empty($errors['sku']) ? '' : 'invalid' ?>" name="sku" id="category-code" value="<?= $inputs['sku'] ?? '' ?>" />
                <?= $this->showErrors($errors['sku'] ?? null) ?>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <label for="category-tax-percentage">Tax Percentage</label>
                <input type="number" class="<?= empty($errors['tax_percentage']) ? '' : 'invalid' ?>" name="tax_percentage" id="category-tax-percentage" value="<?= $inputs['tax_percentage'] ?? '' ?>" min="0" step="0.01" />
                <?= $this->showErrors($errors['tax_percentage'] ?? null) ?>
            </div>
        </div>
        <div>
            <a href="<?= appUrl('categories') ?>" class="waves-effect waves-light btn left">Back</a>
            <button class="waves-effect waves-light btn right" type="submit">Save</button>
        </div>
    </form>
</div>
