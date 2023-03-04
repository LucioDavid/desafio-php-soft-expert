<h1>Cart</h1>

<div class="row">
    <form action="<?= appUrl('checkout') ?>" method="post" class="col s12">
        <div>

            <button class="waves-effect waves-light btn right" type="submit">Checkout</button>
        </div>
    </form>

</div>

<div class="row">
    <div class="col s12">
        <table>
            <thead>
                <tr>
                    <th><span>Name</span></th>
                    <th><span>SKU</span></th>
                    <th><span>Unit Price</span></th>
                    <th><span>Total Price</span></th>
                    <th><span>Quantity</span></th>
                    <th><span>Category</span></th>
                    <th><span>Actions</span></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) { ?>
                    <tr>
                        <td>
                            <span><?= $item['product']['name'] ?></span>
                        </td>
                        <td>
                            <span><?= $item['product']['sku'] ?></span>
                        </td>
                        <td>
                            <span>R$ <?= $item['product']['price'] ?></span>
                        </td>
                        <td>
                            <span>R$ <?= $item['total_price'] ?></span>
                        </td>
                        <td>
                            <span><?= $item['quantity'] ?></span>
                        </td>
                        <td>
                            <span><?= $item['product']['category']['name'] ?></span>
                        </td>
                        <td>
                            <div>
                                <div><a href="#">Increment</a></div>
                                <div><a href="#">Decrement</a></div>
                                <div><a href="#">Remove</a></div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                <?php if (empty($items)) { ?>
                    <tr>
                        <td colspan="3">No products found.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <a href="<?= appUrl('/') ?>" class="waves-effect waves-light btn left">Back</a>
    </div>
</div>
