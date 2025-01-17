<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\CurrentDeals;
use Illuminate\Http\Request;

class CurrentDealsController extends Controller
{
    public function currentdealsview()
    {
        $currentdealsview = CurrentDeals::select('id','shop_name','current_deals_image','current_deals_title','current_deals_price','navigate','searchfield_id','searchfield_text')->where('action','0')->get();
        if($currentdealsview->isEmpty()){
            return response()->json([
                'status'=>'false',
                'message'=>'No current Deals Found',
                'data'=>[]
            ]);
        }


        return response()->json([
            'status'=>'true',
            'message'=>'Data retrieved Successfully',
            'data'=>$currentdealsview
        ]);
    }
}
