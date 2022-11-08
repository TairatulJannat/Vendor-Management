<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    //

    public function create()
    {
        $purchases = Purchase::orderBy('id', 'desc')->get();
        $vendors = Vendor::all();
        return view('Purchase.purchase_create', compact('purchases', 'vendors'));
    }

    public function store(Request $request)
    {

        $purchase = new Purchase();
        $purchase->item_name = $request->item_name;
        $purchase->item_quantity = $request->item_quantity;
        $purchase->unit_price = $request->unit_price;
        $purchase->total_price = $request->total_price;
        $purchase->vendor_id = $request->vendor_id;


        $purchase->save();
        $vendor = $purchase->vendor->name;

        return response()->json(['successMsg' => "Successfully Added", "purchase" => $purchase, 'vendor' => $vendor]);
    }
}
