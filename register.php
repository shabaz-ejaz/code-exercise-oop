<?php

// autoload classes
set_include_path(__DIR__ . '/Classes/');
spl_autoload_register();
require_once 'vendor/autoload.php';


try {
    $productInventory = new ProductInventory();
    $products = $productInventory->getProductList();
    if(!empty($_GET['product_id'])) {
        $product = $productInventory->getProduct(trim($_GET['product_id']));
    }

} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}
