<?php

namespace App\Http\Controllers;

use App\Models\CurrentDeals;
use App\Models\Product;
use App\Models\VendorLogin;
use Illuminate\Http\Request;

class CurrentDealsController extends Controller
{
    public function index(){
        $productdetails = Product::all();
        $vendoroption = VendorLogin::all();
        $vendordetails = VendorLogin::all();
        $currentdeals = CurrentDeals::all()->where('action',0);
        return view('currentDeals.index',['vendoroption'=>$vendoroption ,'productdetails' => $productdetails,'vendordetails' => $vendordetails, 'currentdeals'=>$currentdeals]);
    }
    public function store(Request $request){

        $request->validate([
            'shop_name'=>'required',
            'img_path'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_deals_title'=>'required',
            'current_deals_price'=>'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        $currentdeals = new CurrentDeals();

        $imageName = null;
        if($request->img_path){
            $imageName = time().'.'.$request->img_path->extension();
            $request->img_path->move(public_path('currentdealsimages') , $imageName);
        }


        $currentdeals->shop_name = $request->shop_name;
        $currentdeals->current_deals_image = $imageName;
        $currentdeals->current_deals_title = $request->current_deals_title;
        $currentdeals->current_deals_price = $request->current_deals_price;
        $currentdeals->navigate = $request->navigate;
        $currentdeals->searchfield_id = $request->searchfield_id;
        $currentdeals->searchfield_text = $request->searchfield_text;

        $currentdeals->save();
        return back();


    }
    public function edit($id){
        $productdetails = Product::all();
        $vendoroption = VendorLogin::all();
        $vendordetails = VendorLogin::all();
        $currentdealsedit = CurrentDeals::where('id',$id)->first();
        return view('currentDeals.edit',['currentdealsedit' => $currentdealsedit ,'productdetails' => $productdetails,'vendoroption' =>$vendoroption,'vendordetails' => $vendordetails]);
    }
    public function update(Request $request, $id){
        $request->validate([
            'shop_name'=>'required',
            'img_path'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'current_deals_title'=>'required',
            'current_deals_price'=>'required',
            'navigate' => 'required',
            'searchfield_id' => 'required',
            'searchfield_text' => 'required',
        ]);

        $currentdealsupdate = CurrentDeals::where('id',$id)->first();

        if ($request->hasFile('img_path')) {
            $imageName = time() . '.' . $request->img_path->extension();
            $request->img_path->move(public_path('currentdealsimages'), $imageName);
            $currentdealsupdate->current_deals_image = $imageName; // Update the image path
        }

        $currentdealsupdate->shop_name = $request->shop_name;
        $currentdealsupdate->current_deals_title = $request->current_deals_title;
        $currentdealsupdate->current_deals_price = $request->current_deals_price;
        $currentdealsupdate->navigate = $request->navigate;
        $currentdealsupdate->searchfield_id = $request->searchfield_id;
        $currentdealsupdate->searchfield_text = $request->searchfield_text;
        $currentdealsupdate->save();
        return redirect()->route('currentdeals.create');
    }
    public function delete($id){

        $currentdeals = CurrentDeals::where('id',$id)->first();
        $currentdeals->action ='1';
        $currentdeals->save();
        return back();
    }
}
