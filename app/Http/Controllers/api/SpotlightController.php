<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Spotlight;
use Illuminate\Http\Request;

class SpotlightController extends Controller
{
    public function spotlistview()
    {
        // Fetch data from the Spotlight table
        $spotlist = Spotlight::select('shop_id', 'shop_name', 'background_image', 'price', 'title', 'brand_name')
            ->where('action', '0')
            ->get();

        // Check if any records are found
        if ($spotlist->isEmpty()) {
            // Return a response with status false if no records are found
            return response()->json([
                'status' => false,
                'message' => 'No spotlist found.',
                'data' => []
            ]);
        }

        // Return a response with status true if records are found
        return response()->json([
            'status' => true,
            'message' => 'Data retrieved successfully.',
            'data' => $spotlist
        ]);
    }
}
