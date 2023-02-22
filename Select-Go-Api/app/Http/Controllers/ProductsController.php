<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // =================================================
    // 新增商品
    // =================================================
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'pname'     => 'required',
            'pinfo'     => 'required',
            'pprice'    => 'required|numeric',
            'pstyle'    => 'required',
            'user_id'   => 'nullable|numeric',
            'pcost'     => 'nullable',
            'pprofit'   => 'nullable',
            'pqty'      => 'nullable',
            'psold'     => 'nullable',
            'pshelf'    => 'nullable',
            'ppic_main' => 'nullable',
            'ppic_1'    => 'nullable',
            'ppic_2'    => 'nullable',
            'ppic_3'    => 'nullable',
            'ppic_4'    => 'nullable',
        ]);

        $product = Products::create($validated);
        return $product;
    }

    // =================================================
    // 刪除商品
    // =================================================
    public function deleteProduct($productId)
    {
        $result = Products::where('id', '=', $productId)->delete();
        // if deleted show msg
        if ($result) {
            return ["Success" => "Product deleted!"];
        } else {
            return ["Fail" => "Failed to delete!"];
        }
    }
    // =================================================
    // Update product
    // =================================================
    public function updateProduct(Request $request, $pid)
    {
        // $validated = $request->validate([
        //     'pname'     => 'nullable',
        //     'pinfo'     => 'nullable',
        //     'pprice'    => 'nullable',
        //     'pstyle'    => 'nullable',
        //     'user_id'   => 'nullable',
        //     'pcost'     => 'nullable',
        //     'pprofit'   => 'nullable',
        //     'pqty'      => 'nullable',
        //     'psold'     => 'nullable',
        //     'pshelf'    => 'nullable',
        //     'ppic_main' => 'nullable',
        //     'ppic_1'    => 'nullable',
        //     'ppic_2'    => 'nullable',
        //     'ppic_3'    => 'nullable',
        //     'ppic_4'    => 'nullable',
        // ]);

        $product = Products::find($pid);
        $product->update($request->all());

        // $product = Products::find($productId);
        // $product->update($validated);
        return $product;
    }

    // =================================================
    // 列出所有商品
    // =================================================
    public function list()
    {
        return Products::all();
    }

    // =================================================
    // Find product based on userID
    // =================================================
    public function findUserProduct($uid)
    {
        return Products::where('uid', '=', $uid)->get();
    }
    // =================================================
    // 找出單筆商品
    // =================================================
    public function getProduct($productId)
    {
        $product = Products::find($productId);
        return $product;
    }

    // =================================================
    // 搜尋商品
    // =================================================
    public function search($key)
    {
        return Products::where('pname', 'Like', "%$key%")->get();
        // why does %$key% only work with double quotes
    }

}