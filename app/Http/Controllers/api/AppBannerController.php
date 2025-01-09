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
        $banners = AppBanner::select('id', 'img_path', 'type', 'navigate', 'searchfield')->get();

        // Return all data
        return response()->json([
            'status' => 'success',
            'data' => $banners
        ], 200);
    }
}
