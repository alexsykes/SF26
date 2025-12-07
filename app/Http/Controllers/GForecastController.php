<?php

namespace App\Http\Controllers;

use App\Models\GForecast;
use Illuminate\Http\Request;

class GForecastController extends Controller
{
    public function index()
    {
        return GForecast::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'site_id' => ['required', 'integer'],
            'data' => ['required'],
            'version' => ['required', 'integer'],
        ]);

        return GForecast::create($data);
    }

    public function show(GForecast $gForecast)
    {
        return $gForecast;
    }

    public function update(Request $request, GForecast $gForecast)
    {
        $data = $request->validate([
            'site_id' => ['required', 'integer'],
            'data' => ['required'],
            'version' => ['required', 'integer'],
        ]);

        $gForecast->update($data);

        return $gForecast;
    }

    public function destroy(GForecast $gForecast)
    {
        $gForecast->delete();

        return response()->json();
    }
}
