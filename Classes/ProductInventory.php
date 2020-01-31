<?php

class ProductInventory
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api('someapikey');
    }

    /**
     * @return mixed
     * Get the list of products
     */
    public function getProductList() {
        return $this->api->apiCall('/list');
    }

    /**
     * @param $id
     * @return mixed
     * Get a single product by it's ID
     */
    public function getProduct($id) {
        return $this->api->apiCall('/info', ['query' => ['id' => $id]]);
    }
}