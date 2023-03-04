<!doctype html>
<html ⚡>

<head>
    <title>SoftExpert | PHP Test</title>
    <meta charset="utf-8">

    <link rel="stylesheet" type="text/css" media="all" href="<?= appUrl('assets/css/style.css') ?>" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="<?= appUrl('assets/css/materialize.min.css') ?>" media="screen,projection" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800" rel="stylesheet">
</head>
<!-- Header -->
<nav>
    <div class="nav-wrapper light-blue">
        <div class="container">
            <a href="<?= appUrl('/') ?>" class="brand-logo">Store</a>
            <a href="#" data-target="mobile-nav-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
                <li><a href="<?= appUrl('categories') ?>">Categories</a></li>
                <li><a href="<?= appUrl('products') ?>">Products</a></li>
                <li><a href="<?= appUrl('checkout/cart') ?>" class="waves-effect waves-light btn indigo"><i class="material-icons left">shopping_cart</i>Cart</a></li>
            </ul>
        </div>
    </div>
</nav>
<ul class="sidenav" id="mobile-nav-menu">
    <li><a href="<?= appUrl('categories') ?>">Categories</a></li>
    <li><a href="<?= appUrl('products') ?>">Products</a></li>
    <li><a href="<?= appUrl('checkout/cart') ?>"><i class="material-icons left">shopping_cart</i>Cart</a></li>
</ul>
<!-- Header -->
<!-- Main Content -->
<main>
    <div class="container">
        <div class="section">
            <?php foreach ($this->messages as $message) { ?>
                <div class="alert alert-<?= $message['type'] ?>" role="alert"><?= $message['content'] ?></div>
            <?php } ?>
        </div>
        {{content}}
    </div>
</main>
<!-- Main Content -->
<!-- Footer -->
<footer class="page-footer light-blue">
    <div class="container">
        <div class="row">
            <div class="col s12">
                <h5 class="white-text">Developed Without a Framework</h5>
                <p class="grey-text text-lighten-4">This simple app was made without the use of a framework.</p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2023 Lucio Meira David
        </div>
    </div>
</footer>
<!-- Footer -->
<!--JavaScript at end of body for optimized loading-->
<script type="text/javascript" src="<?= appUrl('assets/js/materialize.min.js') ?>"></script>
<script>
    M.AutoInit();
</script>
</body>

</html>
