<?php

namespace App\Http\Controllers;

use App\Models\DataRequest;
use Illuminate\Http\Request;

class DataRequestController extends Controller
{
    public function index()
    {
        return DataRequest::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'created_by' => ['required', 'integer'],
            'description' => ['required'],
            'purpose' => ['required'],
            'comments' => ['nullable'],
            'approved' => ['nullable', 'boolean'],
            'accept' => ['boolean'],
        ]);

        return DataRequest::create($data);
    }

    public function show(DataRequest $dataRequest)
    {
        return $dataRequest;
    }

    public function update(Request $request, DataRequest $dataRequest)
    {
//        dd($request->all());
        $data = $request->validate([
            'created_by' => ['required', 'integer'],
            'description' => ['required'],
            'purpose' => ['required'],
            'comments' => ['nullable'],
            'approved' => ['nullable', 'boolean'],
            'accept' => ['boolean'],
        ]);

        $dataRequest->update($data);
        return $dataRequest;
    }

    public function destroy(DataRequest $dataRequest)
    {
        $dataRequest->delete();

        return response()->json();
    }
}
