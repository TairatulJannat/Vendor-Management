<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
    public function create()
    {
        $vendors = Vendor::orderBy('id', 'desc')->get();
        return view('Vendor.vendor_create', compact('vendors'));
    }


    public function store(Request $request)
    {

        // dd('123');
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required',
        ]);


        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->save();

        return response()->json(['status' => true, 'successMsg' => "Successfully Added", "vendor" => $vendor]);
    }

    public function update(Request $request, $id)
    {


        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'address' => 'required',
        ]);
        $vendor = Vendor::find($id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;

        $vendor->update();
        return response()->json(['vendor' => $vendor]);
    }

    public function edit($id)
    {

        $vendor = Vendor::find($id);
        return response()->json(['vendor' => $vendor]);
    }

    public function destroy($id)
    {
        //
        $vendor = Vendor::find($id);
        $vendor->delete();
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }
}
