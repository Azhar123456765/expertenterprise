<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\users;
use App\Models\customization;
use App\Models\buyer;
use App\Models\seller;

use App\Models\product_sub_category;
use App\Models\product_category;
use App\Models\product_company;
use App\Models\product_type;
use App\Models\products;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;

class product extends Controller
{



    function product_category(Request $request)
    {

        $users = product_category::all();
        $data = compact('users');
        return view('product_category')->with($data);
    }
    function add_product_category(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $add = new product_category();
        $add->category_name = $request['category_name'];
        $add->save();

        session()->flash('message', 'category has been added successfully');
        return redirect()->back();
    }

    function edit_product_category(Request $request, $id)
    {

        $request->validate([
            'category_name' => 'required',
        ]);

        $query = product_category::where('product_category_id', $id)->update([

            'category_name' => $request['category_name'],

        ]);

        session()->flash('message', 'category has been updated successfully');


        return redirect()->back();
    }

    function product_category_delete(Request $request, $id)
    {

        $query = product_category::where('product_category_id', $id)->delete();

        session()->flash('message', 'category has been deleted successfully');


        return redirect()->back();
    }













    // function product_sub_category(Request $request)
    // {

    //     $users = product_sub_category::leftJoin('product_category', 'main_category', '=', 'product_category.product_category_id')->get();
    //     $category = product_category::all();
    //     $data = compact('users', 'category');
    //     return view('product_sub_category')->with($data);
    // }
    // function add_product_sub_category(Request $request)
    // {


    //     $add = new product_sub_category();
    //     $add->sub_category_name = $request['category_name'];
    //     $add->main_category = $request['main_category'];

    //     $add->save();


    //     session()->flash('message', 'Sub-category has been added successfully');


    //     return redirect()->back();
    // }

    // function edit_product_sub_category(Request $request, $id)
    // {

    //     $query = product_sub_category::where('product_sub_category_id', $id)->update([

    //         'sub_category_name' => $request['category_name'],
    //         'main_category' => $request['main_category'],


    //     ]);

    //     session()->flash('message', 'Sub-category has been updated successfully');


    //     return redirect()->back();
    // }

    // function product_sub_category_delete(Request $request, $id)
    // {

    //     $query = product_sub_category::where('product_sub_category_id', $id)->delete();

    //     session()->flash('message', 'Sub-category has been deleted successfully');


    //     return redirect()->back();
    // }








    function data_product_company()
    {
        $product = product_company::all();
        return DataTables::of($product)->make(true);
    }

    function product_company(Request $request)
    {
        $users = product_company::paginate(15);
        $search = $request->input('search');
        $data = compact('users');
        if ($search) {
            $users = product_company::where('company_name', 'like', '%' . $search . '%')->get();
            $data = compact('users');
            $view = view('load.product.company', $data)->render();
            return response()->json(['view' => $view]);
        } elseif ($request->ajax()) {
            $view = view('load.product.company', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $users->nextPageUrl()]);
        }


        if ($request->ajax()) {
            $view = view('load.product.company', $data)->render();
            return response()->json(['view' => $view, 'nextPageUrl' => $users->nextPageUrl()]);
        }
        return view('product_company')->with($data);
    }
    function add_product_company(Request $request)
    {
        $request->validate([
            'company' => 'required|unique:product_company,company_name',
        ]);

        $add = new product_company();
        $add->company_name = $request['company'];
        $add->save();


        session()->flash('message', 'Product Company has been added successfully');


        return redirect()->back();
    }

    function edit_product_company(Request $request, $id)
    {
        $request->validate([
            'company' => 'required|unique:product_company,company_name',
        ]);
        $query = product_company::where('product_company_id', $id)->update([

            'company_name' => $request['company'],


        ]);

        session()->flash('message', 'Product Company has been updated successfully');


        return redirect()->back();
    }

    function product_company_delete(Request $request, $id)
    {

        $query = product_company::where('product_company_id', $id)->delete();

        session()->flash('message', 'Product Company has been deleted successfully');


        return redirect()->back();
    }
















    function product_type(Request $request)
    {

        $users = product_type::all();
        $data = compact('users');
        return view('product_type')->with($data);
    }
    function add_product_type(Request $request)
    {
        $request->validate([
            'type' => 'required',
        ]);

        $add = new product_type();
        $add->type = $request['type'];
        $add->save();

        session()->flash('message', 'Product type has been added successfully');
        return redirect()->back();
    }

    function edit_product_type(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
        ]);

        $query = product_type::where('product_type_id', $id)->update([
            'type' => $request['type'],
        ]);

        session()->flash('message', 'Product type has been updated successfully');


        return redirect()->back();
    }

    function product_type_delete(Request $request, $id)
    {

        $query = product_type::where('product_type_id', $id)->delete();

        session()->flash('message', 'Product type has been deleted successfully');


        return redirect()->back();
    }









    function data_product()
    {
        $product = products::orderByDesc('product_id');
        return DataTables::of($product)->make(true);
    }
    function index(Request $request)
    {

        $category = product_category::all();
        // $sub_category = product_sub_category::all();
        $company = product_company::all();
        $type = product_type::all();
        // $search = $request->input('search');

        // $product_code = $request['code'] ?? null;


        $products = products::orderByDesc('id');

        // if ($search) {
        //     $users = product_company::where('company_name', 'like', '%' . $search . '%')->get();
        //     $data = compact('users');
        //     $view = view('load.product.company', $data)->render();
        //     return response()->json(['view' => $view]);
        // } elseif ($request->ajax()) {
        //     $view = view('load.product.company', $data)->render();
        //     return response()->json(['view' => $view, 'nextPageUrl' => $users->nextPageUrl()]);
        // }


        // if ($request->ajax()) {
        //     $view = view('load.product.company', $data)->render();
        //     return response()->json(['view' => $view, 'nextPageUrl' => $users->nextPageUrl()]);
        // }
        return view('products', compact('products', 'category', 'company', 'type'));
    }
   
   
    function create()
    {
        $type = product_type::all();
        return view('add_product', compact('type'));
    }

    function edit(Request $request, $id)
    {
        $type = product_type::all();
        $product = products::where('product_id', $id)->first();

        return view('edit_product', compact('product', 'type'));
    }

    function add_product(Request $request)
    {

        $request->validate([
            'product_name' => 'required|unique:products,product_name,' . $request['product_name'] . ',product_id',
        ]);
        // Retrieve the form data
        $productName = $request->input('product_name');
        $desc = $request->input('desc');
        $company = $request->input('company');
        $type = $request->input('type');
        $category = $request->input('category');
        $purchasePrice = $request->input('purchase_price');
        $salePrice = $request->input('sale_price');
        $openingPurPrice = $request->input('opening_pur_price');
        $openingQuantity = $request->input('opening_quantity');
        $avgPurPrice = $request->input('avg_pur_price');
        $overheadExp = $request->input('overhead_exp');
        $overheadPricePur = $request->input('overhead_price_pur');
        $overheadPriceAvg = $request->input('overhead_price_avg');
        $purPricePlusOh = $request->input('pur_price_plus_oh');
        $avgPricePlusOh = $request->input('avg_price_plus_oh');
        $inactiveItem = $request->input('inactive_item');
        $barcode = $request->input('barcode');
        $unit = $request->input('unit');
        $reOrderLevel = $request->input('re_order_level');


        $image = $request->file('image');

        if ($image) {
            $imagePath = $request->file('image')->store('product_img');
        } else {
            $imagePath = null; // Set a default value if no image is uploaded
        }

        // Save the data to the database or perform any other desired operations
        $rand = rand(1, 99999999);
        $qr = QrCode::size(200)->generate(url('products?code=') . '26250710');
        $qrCodePath = public_path('qrcodes' . 'qrcode.png');

        if (is_writable(dirname($qrCodePath))) {
            file_put_contents($qrCodePath, $qr);
            // Success
        } else {
            // Handle the case where the directory is not writable
        }
        $product = new products;
        $product->product_name = $productName;
        $product->desc = $desc;
        $product->company = $company;
        $product->product_type = $type;
        $product->category = $category;
        $product->purchase_price = $purchasePrice;
        $product->product_sale_price = $salePrice;
        $product->opening_pur_price = $openingPurPrice;
        $product->opening_quantity = $openingQuantity;
        $product->avg_pur_price = $avgPurPrice;
        $product->overhead_exp = $overheadExp;
        $product->overhead_price_pur = $overheadPricePur;
        $product->overhead_price_avg = $overheadPriceAvg;
        $product->pur_price_plus_oh = $purPricePlusOh;
        $product->avg_price_plus_oh = $avgPricePlusOh;
        $product->inactive_item = $inactiveItem;
        $product->barcode = $barcode;
        $product->qr_code = $rand;
        $product->unit = $unit;
        $product->re_order_level = $reOrderLevel;
        $product->image = $imagePath;
        $product->save();


        // Redirect to a success page or return a response
        session()->flash('message', 'product has been added successfully');
        return redirect()->back();
    }


    function product_delete(Request $request, $id)
    {

        $image = products::where('product_id', $id)->get();

        foreach ($image as $key => $row) {


            if ($image != null) {
                unlink($row->image);
            }
        }

        $query = products::where('product_id', $id)->delete();

        session()->flash('message', 'Product has been deleted successfully');


        return redirect()->back();
    }


    function update($id, Request $request)
    {
        $request->validate([
            'product_name' => 'required',
        ]);
        
        $productName = $request->input('product_name');
        $desc = $request->input('desc');
        $company = $request->input('company');
        $type = $request->input('type');
        $category = $request->input('category');
        $purchasePrice = $request->input('purchase_price');
        $salePrice = $request->input('sale_price');
        $openingPurPrice = $request->input('opening_pur_price');
        $openingQuantity = $request->input('opening_quantity');
        $avgPurPrice = $request->input('avg_pur_price');
        $overheadExp = $request->input('overhead_exp');
        $overheadPricePur = $request->input('overhead_price_pur');
        $overheadPriceAvg = $request->input('overhead_price_avg');
        $purPricePlusOh = $request->input('pur_price_plus_oh');
        $avgPricePlusOh = $request->input('avg_price_plus_oh');
        $inactiveItem = $request->input('inactive_item');
        $barcode = $request->input('barcode');
        $unit = $request->input('unit');
        $reOrderLevel = $request->input('re_order_level');
        $image = $request->file('image');


        $old_img = $request->input('old_image');


        if ($image != '') {
            $imagePath = $request->file('image')->store('product_img', 'public');
            if ($old_img != '' && $image != '') {
                unlink($old_img);
            }
        } else {
            $imagePath = $old_img; // Set a default value if no image is uploaded
        }

        // Update the product in the database

        products::where('product_id', $id)->update([
            'product_name' => $productName,
            'desc' => $desc,
            'company' => $company,
            'product_type' => $type,
            'category' => $category,
            'purchase_price' => $purchasePrice,
            'product_sale_price' => $salePrice,
            'opening_pur_price' => $openingPurPrice,
            'opening_quantity' => $openingQuantity,
            'avg_pur_price' => $avgPurPrice,
            'overhead_exp' => $overheadExp,
            'overhead_price_pur' => $overheadPricePur,
            'overhead_price_avg' => $overheadPriceAvg,
            'pur_price_plus_oh' => $purPricePlusOh,
            'avg_price_plus_oh' => $avgPricePlusOh,
            'inactive_item' => $inactiveItem,
            'barcode' => $barcode,
            'unit' => $unit,
            're_order_level' => $reOrderLevel,
            'image' => $imagePath // Only update if an image is provided
        ]);


        // Redirect to a success page or return a response
        session()->flash('message', 'Product has been updated successfully');
        return redirect()->back();
    }
}
