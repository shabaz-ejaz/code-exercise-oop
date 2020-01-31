<?php
require_once 'register.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Code exercise OOP</title>
</head>

<body>


<?php

include 'product-list.php';


if (!empty($product)) {
    if (!empty($product->error)) {
        ?>
        <h2>There was an error with the data source: <?php echo $product->error; ?></h2>
        <?php
    } else {

        ?>
        <h2><?php echo $product->{$_GET['product_id']}->name ?></h2>
        <p><?php echo $product->{$_GET['product_id']}->type ??  '' ?></p>
        <hr />
        <p><?php echo htmlspecialchars($product->{$_GET['product_id']}->description) ?></p>

        <h3>Suppliers</h3>
        <ul>
        <?php

        if(!empty($product->{$_GET['product_id']}->suppliers)) {
            foreach ($product->{$_GET['product_id']}->suppliers as $supplier) {
                ?>
                <li><?php echo htmlspecialchars_decode(  $supplier) ?></li>

                <?php
            }
        }
        ?>
        </ul>
            <?php
    }

}
?>

</body>

</html>

