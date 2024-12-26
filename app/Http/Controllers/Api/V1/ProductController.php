<?php

namespace App\Http\Controllers\Api\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface){
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->index();

        $headers = [
            'X-Pagination-Total' => $data->count(),
        ];

        return ApiResponseClass::sendResponse(ProductResource::collection($data), 'Products List', 200, $headers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $details = $request->validated();
            $data = $this->productRepositoryInterface->store($details);
            return ApiResponseClass::sendResponse(ProductResource::make($data), 'Product Created', 201);
        } catch (\Exception $e) {
            return ApiResponseClass::throw($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepositoryInterface->getById($id);
        return ApiResponseClass::sendResponse(ProductResource::make($product), 'Product Details', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $details = $request->validated();
        $data = $this->productRepositoryInterface->update($details, $id);
        return ApiResponseClass::sendResponse(ProductResource::make($data), 'Product Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productRepositoryInterface->delete($id);
        return ApiResponseClass::sendResponse(null, 'Product Deleted', 200);
    }
}
