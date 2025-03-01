<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dissolver\DissolverModel;
use App\Models\Dissolver\Dissolver2;
use App\Models\Dissolver\Dissolver3;
use App\Models\Dissolver\Dissolver4;
use App\Models\Dissolver\Dissolver5;
use App\Models\Dissolver\Dissolver6;
use App\Models\Dissolver\Dissolver7;
use App\Models\Dissolver\Dissolver8;
class SensorDissolverController extends Controller
{
    //
    public function getData($dissolver)
    {
        $modelClass = 'App\\Models\\Dissolver\\DissolverModel';
        
        if ($dissolver !== 'dissolver1') {
            $modelClass = 'App\\Models\\Dissolver\\DissolverModel';
        }
    
        if (!class_exists($modelClass)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Dissolver requested'
            ], 400);
        }
    
        $data = (new $modelClass())->setTable($dissolver)->getLatestData();
    
        return response()->json([
            'success' => true,
            'message' => "Data $dissolver berhasil diambil",
            'data' => $data
        ]);
    }


    public function getLatestData()
{
    // Mapping dissolver ke model yang sesuai
    $dissolverModels = [
        'dissolver1' => DissolverModel::class,
        'dissolver2' => Dissolver2::class,
        'dissolver3' => Dissolver3::class,
        'dissolver4' => Dissolver4::class,
        'dissolver5' => Dissolver5::class,
        'dissolver6' => Dissolver6::class,
        'dissolver7' => Dissolver7::class,
        'dissolver8' => Dissolver8::class,
    ];

    $latestData = [];

    // Looping semua dissolver untuk mendapatkan data terbaru
    foreach ($dissolverModels as $key => $model) {
        $latestData[$key] = $model::orderBy('created_at', 'desc')->first() ?? 'No data found';
    }

    return response()->json(['data' => $latestData]);
}

    
}
