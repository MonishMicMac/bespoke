<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AppBanner;
use Illuminate\Http\Request;

class AppBannerController extends Controller
{
    public function homepageview()
    {
        // Retrieve all banners
        $banners = AppBanner::select('id', 'img_path', 'type', 'navigate', 'searchfield_id','searchfield_text')->get();

        // Check if banners data exists
        if ($banners->isEmpty()) {
            return response()->json([
                'status' => 'false',
                'message' => 'No data found',
                'data' => []
            ], 404); // Use 404 Not Found status code for empty data
        }

        // Return all data
        return response()->json([
            'status' => 'true',
            'message' => 'Data Retrived Successfully',
            'data' => $banners
        ], 200);
    }
}
