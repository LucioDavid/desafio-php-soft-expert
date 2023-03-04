<h1>Categories</h1>
<a href="<?= appUrl('categories/add') ?>" class="waves-effect waves-light btn right">Add new Category</a>

<div class="row">
    <div class="col s12">
        <table>
            <thead>
                <tr>
                    <th>
                        <span>Name</span>
                    </th>
                    <th>
                        <span>Code</span>
                    </th>
                    <th>
                        <span>Tax Percentage</span>
                    </th>
                    <th>
                        <span>Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category) { ?>
                    <tr>
                        <td>
                            <span><?= $category['name'] ?></span>
                        </td>
                        <td>
                            <span><?= $category['sku'] ?></span>
                        </td>
                        <td>
                            <span><?= (float) $category['tax_percentage'] ?>%</span>
                        </td>
                        <td>
                            <div>
                                <div><a href="<?= appUrl("categories/edit/{$category['id']}") ?>">Edit</a></div>
                                <div><a href="<?= appUrl("categories/delete/{$category['id']}") ?>">Delete</a></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (empty($categories)) { ?>
                    <tr>
                        <td colspan="3">No categories found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
