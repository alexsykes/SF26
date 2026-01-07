<?php

namespace App\Http\Controllers;

use App\Events\DataRequestClosed;
use App\Events\DataRequestOpened;
use App\Models\DataRequest;
use App\Rules\ReCaptchaV3;
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
            'data_format' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptchaV3('/dataRequest/submit')],
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
            ->where('data_requests.completed', false)
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
            DataRequestClosed::dispatch($dataRequest);
        }
        $dataRequest->approved = $request->approved;
        $dataRequest->comments = $request->comments;
        $dataRequest->updated_at = now();
        $dataRequest->update();

        return redirect('/data/requests');
    }

    public function export(Request $request)
    {
//        dd($request->all());
        $data_format = $request->data_format;
        $exportDir = "downloads/";
        $tables = $request->tables;

        switch ($data_format) {
            case 'CSV':
                info('CSV');
                $this->exportToCsv($tables, $exportDir);
                break;
            case 'JSON':
                info('JSON');
                $this->exportToJSON($tables, $exportDir);
                break;
            case 'SQL':
                $this->exportToSQL($tables, $exportDir);
                info('SQL');
                break;
            case 'Other':
                info('Other');
                break;
            default:
                break;

        }
        return redirect('/data/requests');
    }

    private function exportToCsv(mixed $tables, string $exportDir)
    {
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
            foreach ($tablesToExport as $table) {
                $data = DB::table($table)->get();
                $csvFileName = $exportDir . $table . '.csv';
                $csvFile = fopen($csvFileName, 'w');
                $headers = array_keys((array)$data[0]); // Get the column headers from the first row
                fputcsv($csvFile, $headers);

                foreach ($data as $row) {
                    fputcsv($csvFile, (array)$row);
                }
                fclose($csvFile);
            }
        }


    }

    private function exportToJSON(mixed $tables, string $exportDir)
    {
//        dd($tables);
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
            file_put_contents($exportDir . 'jsonData.json', $jsonData);
        }
    }

    private function exportToSQL(mixed $tables, string $exportDir)
    {
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

            $dbname = config('database.connections.mysql.database');
            $pass = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            $dbuser = config('database.connections.mysql.username');

//            dd($tablesToExport);
            try {
                $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$dbname", $dbuser, $pass, dumpSettings: ['include-tables' => $tablesToExport,]);
                $dump->start($exportDir . 'slopefinder_data.sql');
                info("Success");
            } catch (\Exception $e) {
                info('mysqldump-php error: ' . $e->getMessage());
            }
        }
    }
}
