<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Designer;
use Illuminate\Http\Request;

class DesignerController extends Controller
{
    public function topdesigner(){
        $topdesigner = Designer::select('id','designer_image','designer_title')->where('action','0')->get();
        if($topdesigner->isEmpty()){
            return response()->json([
                'status'=> false,
                'message'=>'No Top Designer Found',
                'data' =>[]
            ]);
        }

        return response()->json([
            'status'=>true,
            'message'=>'Data retrieved successfully.',
            'data' => $topdesigner
        ]);
    }
}
