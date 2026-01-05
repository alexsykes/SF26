<?php

namespace App\Http\Controllers;

use App\Events\DataRequestOpened;
use App\Models\DataRequest;
use Ifsnop\Mysqldump as IMysqldump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function index()
    {

    }

    public function dataRequest()
    {
        return view('data.request');
    }

    public function store(Request $request)
    {
        $userID = Auth::user()->id;
        $attributes = request()->validate([
            'description' => 'required',
            'purpose' => 'required',
            'accept' => 'required',
            'format' => 'required',
        ]);

        $attributes['created_by'] = $userID;
        $attributes['approved'] = 'Pending';
        $dataRequest = DataRequest::create($attributes);
        DataRequestOpened::dispatch($dataRequest);
        return view('data.acknowledge');
    }

    public function list()
    {
        $dataRequest = DataRequest::leftJoin('users', 'data_requests.created_by', '=', 'users.id')
            ->select('data_requests.*', 'users.name')
            ->orderBy('data_requests.approved')
            ->get();

        return view('data.list', compact('dataRequest'));
    }

    public function process(Request $request)
    {
        $dataRequest = DataRequest::leftJoin('users', 'data_requests.created_by', '=', 'users.id')
            ->select('data_requests.*', 'users.name')
            ->where('data_requests.id', $request->id)
            ->first();

        return view('data.process', compact('dataRequest'));
    }

    public function respond(Request $request)
    {
        $dataRequest = DataRequest::where('id', $request->id)->first();

        if (isset($request->completed)) {
            $dataRequest->completed = true;
        }
        $dataRequest->approved = $request->approved;
        $dataRequest->comments = $request->comments;
        $dataRequest->updated_at = now();
        $dataRequest->update();

        return redirect('/data/requests');
    }

    public function export(Request $request)
    {

        $tables = $request->tables;

        if ($tables) {
            $tablesToExport = array();
            foreach ($tables as $table) {
                switch ($table) {
                    case "Clubs":
                        $name = "clubs";
                        break;
                    case "Wind Directions for Sites" :
                        $name = "site_wind_directions";
                        break;
                    case "Sites" :
                        $name = "sites";
                        break;
                }
                array_push($tablesToExport, $name);
            }

            $dataToExport = array();
            foreach ($tablesToExport as $table) {
                $JSONdata = DB::table($table)->get()
                    ->toJson();
                array_push($dataToExport, $JSONdata);
            }

            $jsonData = json_encode($dataToExport);


// Write data to CSV
            foreach ($tablesToExport as $table) {
                $data = DB::table($table)->get();
                $csvFileName = $table . '.csv';
                $csvFile = fopen($csvFileName, 'w');
                $headers = array_keys((array)$data[0]); // Get the column headers from the first row
                fputcsv($csvFile, $headers);

                foreach ($data as $row) {
                    fputcsv($csvFile, (array)$row);
                }
                fclose($csvFile);
            }
// SQL dump
            $dbname = config('database.connections.mysql.database');
            $pass = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $dbuser = config('database.connections.mysql.username');

            try {
                $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$dbname", $dbuser, $pass, dumpSettings: ['include-tables' => ['sites', 'site_wind_directions', 'clubs',],]);
                $dump->start('dump.sql');
                info("Success");
            } catch (\Exception $e) {
                info('mysqldump-php error: ' . $e->getMessage());
            }

            return response($jsonData)->header('Content-Type', 'application/json');
        }
    }
}
