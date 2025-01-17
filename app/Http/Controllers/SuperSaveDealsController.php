<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SuperSaveDeals;
use App\Models\VendorLogin;
use Illuminate\Http\Request;

class SuperSaveDealsController extends Controller
{
    public function index(){

        $supersaverdeals = SuperSaveDeals::all()->where('action','0');
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view('supersaver.index',['supersavedeals' => $supersaverdeals ,'productdetails'=>$productdetails, 'vendordetails' => $vendordetails]);
    }
    public function store(Request $request){
        $request->validate([
            'img_path'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'super_save_deals_title'=>'required',
            'super_save_deals_price'=>'required',
            'super_save_deals_brand_name'=>'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',

        ]);

        $supersaverdeals = new SuperSaveDeals();

        $imageName = null;
        if($request->img_path){
            $imageName = time().'.'.$request->img_path->extension();
            $request->img_path->move(public_path('supersaverdealsimages') , $imageName);
        }

        $supersaverdeals->super_save_deals_image = $imageName;
        $supersaverdeals->super_save_deals_title = $request->super_save_deals_title;
        $supersaverdeals->super_save_deals_price = $request->super_save_deals_price;
        $supersaverdeals->super_save_deals_brand_name = $request->super_save_deals_brand_name;
        $supersaverdeals->navigate = $request->navigate;
        $supersaverdeals->searchfield_id = $request->searchfield_id;
        $supersaverdeals->searchfield_text = $request->searchfield_text;
        $supersaverdeals->save();
        return back();


    }
    public function edit($id){
        $supersaveredit = SuperSaveDeals::where('id',$id)->first();
        $productdetails = Product::all();
        $vendordetails = VendorLogin::all();
        return view("supersaver.edit",['supersaveredit' => $supersaveredit,'productdetails'=>$productdetails, 'vendordetails' => $vendordetails]);
    }
    public function update(Request $request,$id){


        $request->validate([
            'img_path'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'super_save_deals_title'=>'required',
            'super_save_deals_price'=>'required',
            'super_save_deals_brand_name'=>'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        $supersaverdealsupdate = SuperSaveDeals::where('id',$id)->first();

        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('supersaverdealsimages'), $imageName);
            $supersaverdealsupdate->super_save_deals_image = $imageName; // Update the image path
        }

        $supersaverdealsupdate->super_save_deals_title = $request->super_save_deals_title;
        $supersaverdealsupdate->super_save_deals_price = $request->super_save_deals_price;
        $supersaverdealsupdate->super_save_deals_brand_name = $request->super_save_deals_brand_name;
        $supersaverdealsupdate->navigate = $request->navigate;
        $supersaverdealsupdate->searchfield_id = $request->searchfield_id;
        $supersaverdealsupdate->searchfield_text = $request->searchfield_text;
        $supersaverdealsupdate->save();
        return redirect()->route('supersaverdeals.create')->with('success', 'Supersaver Deals updated successfully.');


    }
    public function delete($id){
        $supersaverdealsdestroy = SuperSaveDeals::where('id',$id)->first();
        $supersaverdealsdestroy->action='1';
        $supersaverdealsdestroy->save();
        return back();
    }
}
