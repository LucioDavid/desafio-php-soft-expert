<h1>Products</h1>
<a href="<?= appUrl('products/add') ?>" class="waves-effect waves-light btn right">Add new Product</a>

<div class="row">
    <div class="col s12">
        <table>
            <thead>
                <tr>
                    <th>
                        <span>Name</span>
                    </th>
                    <th>
                        <span>SKU</span>
                    </th>
                    <th>
                        <span>Price</span>
                    </th>
                    <th>
                        <span>Quantity</span>
                    </th>
                    <th>
                        <span>Category</span>
                    </th>
                    <th>
                        <span>Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td>
                            <span><?= $product['name'] ?></span>
                        </td>
                        <td>
                            <span><?= $product['sku'] ?></span>
                        </td>
                        <td>
                            <span>R$ <?= $product['price'] ?></span>
                        </td>
                        <td>
                            <span><?= $product['quantity'] ?></span>
                        </td>
                        <td>
                            <span><?= $product['category']['name'] ?></span>
                        </td>
                        <td>
                            <div>
                                <div><a href="<?= appUrl("products/edit/{$product['id']}") ?>">Edit</a></div>
                                <div><a href="<?= appUrl("products/delete/{$product['id']}") ?>">Delete</a></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (empty($products)) { ?>
                    <tr>
                        <td colspan="3">No products found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
