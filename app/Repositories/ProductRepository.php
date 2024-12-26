<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function index(){
        return Product::all();
    }
    public function getById($id){
        return Product::findOrFail($id);
    }
    public function store(array $data){
        return Product::create($data);
    }
    public function update(array $data, $id){
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }
    public function delete($id){
        Product::destroy($id);
    }
}
