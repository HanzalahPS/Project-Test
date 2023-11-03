<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DuplicateController extends Controller
{
    public function findDuplicates(Request $request)
    {
        $data = $request->input('data');
        
        if (empty($data)) {
            return response()->json(['error' => 'No data provided'], 400);
        }
        
        $arr = json_decode($data, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json(['error' => 'Invalid JSON data'], 400);
        }
        
        $countMap = [];
        
        foreach ($arr as $element) {
            if (isset($countMap[$element])) {
                $countMap[$element]++;
            } else {
                $countMap[$element] = 1;
            }
        }
        
        $duplicates = [];
        foreach ($countMap as $element => $count) {
            if ($count > 1) {
                $duplicates[] = $element;
            }
        }
        
        return response()->json($duplicates);
    }
    
    
    
}
