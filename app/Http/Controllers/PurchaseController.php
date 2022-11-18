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
        $vendors = Vendor::all();
        return view('Purchase.purchase_create', compact('vendors'));
    }

    public function getPurchase()
    {
        $purchases = Purchase::orderBy('id', 'desc')->with('vendor')->get();

        // foreach ($purchases as $key => $purchase) {
        //     $vendors[$key] = $purchase->vendor->name;
        // }

        return response()->json(['purchases' => $purchases]);
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

    public function edit($id)
    {

        $purchase = Purchase::where('id', $id)->with('vendor')->first();
        $vendors = Vendor::all();

        return response()->json(['purchase' => $purchase, 'vendors' => $vendors]);
    }

    public function update(Request $request, $id)
    {


        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        //     'address' => 'required',
        // ]);
        $purchase = Purchase::find($id);
        $purchase->vendor_id = $request->vendor_id;
        $purchase->item_name = $request->item_name;
        $purchase->item_quantity = $request->item_quantity;
        $purchase->unit_price = $request->unit_price;
        $purchase->total_price = $request->total_price;

        $purchase->update();
        return response()->json($request);
    }

    public function destroy($id)
    {
        //
        $purchase = Purchase::find($id);
        $purchase->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
