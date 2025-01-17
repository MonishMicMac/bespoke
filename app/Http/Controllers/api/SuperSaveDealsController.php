<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\SuperSaveDeals;
use Illuminate\Http\Request;

class SuperSaveDealsController extends Controller
{
    public function supersavedealsview()
    {
        $supersavedealsview = SuperSaveDeals::select('id','super_save_deals_image','super_save_deals_title','super_save_deals_price','super_save_deals_brand_name','navigate','searchfield_id','searchfield_text')->where('action','0')->get();
        if($supersavedealsview->isEmpty()){
            return response()->json([
                'status'=>'false',
                'message'=>'No current Deals Found',
                'data'=>[]
            ]);
        }


        return response()->json([
            'status'=>'true',
            'message'=>'Data retrieved Successfully',
            'data'=>$supersavedealsview
        ]);
    }
}
