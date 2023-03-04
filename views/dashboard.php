<h1 class="title">Store</h1>
<div class="divider"></div>

<h2>Products</h2>
<p>
    You have <?= $products_count ?> product<?= ($products_count) == 1 ? '' : 's' ?> added on this store: <a href="<?= appUrl('products/add') ?>" class="waves-effect waves-light btn">Add new Product</a>
</p>
<div class="row">
    <?php foreach ($products as $product) { ?>
        <div class="col l3 s6 center-align">
            <div>
                <a href="<?= appUrl("products/edit/{$product['id']}") ?>" title="<?= $product['name'] ?>">
                    <img src="<?= appUrl('assets/images/product/tenis-placeholder.png') ?>" layout="responsive" width="164" height="145" alt="<?= $product['name'] ?>" />
                </a>
            </div>
            <div>
                <div><span><?= $product['name'] ?></span></div>
                <div><span><?= $product['quantity'] ?> available</span> <span>R$<?= $product['price'] ?></span></div>
            </div>
            <div>
                <form action="<?= appUrl('checkout/add-to-cart') ?>" method="post" class="col s12">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" name="quantity" value="1">
                    <div class="row">
                        <div class="col s12">
                            <button class="waves-effect waves-light btn" type="submit">Add to Cart</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>

<h2>Sales</h2>
<div class="row">
    <div class="col s12"><span>Total: </span></div>
    <div class="col s12"><span>Taxes: </span></div>
</div>
