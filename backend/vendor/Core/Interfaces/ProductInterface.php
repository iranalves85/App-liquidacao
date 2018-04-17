<?php

namespace Core\Interfaces;

interface ProductInterface{

    public function getProduct();

    public function getListProduct();

    public function getQuantityProduct();

    public function addProduct();

    public function updateProduct();

    public function deleteProduct();

}