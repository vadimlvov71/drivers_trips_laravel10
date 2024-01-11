<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriversTrips;
use Illuminate\Support\Facades\DB;

class DriversPayableTimeController extends Controller
{
    public function index()
    {
        return view('drivers.index');
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('image');
   
        //Move Uploaded File
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file->getClientOriginalName());
        $drivers = $this->readCsv();
        $this->store($drivers);
        return view('drivers.times', compact('drivers'));
    }
    public function store($drivers = [])
    {
        
        foreach($drivers as $key => $driver_trip) {
            $trips = new DriversTrips;
            $trips->driver_id = $driver_trip['driver_id'];
            $trips->pickup = $driver_trip['pickup'];
            $trips->dropoff = $driver_trip['dropoff']; 
            $trips->save();  
        }
        //return redirect()->back()->with('status','Student Added Successfully');
    }
    public function readCsv()
    {
        //$filePath = storage_path('uploads/trip.csv');
        $filePath = public_path('uploads/trips.csv');
        $file = fopen($filePath, 'r');

        $header = fgetcsv($file);

        $users = [];
        while ($row = fgetcsv($file)) {
            $users[] = array_combine($header, $row);
        }

        fclose($file);

        return $users;
    }
    public function getTotalMinutesWithPassenger($orderBy = "DESC")
    {
       
       $drivers = DB::table('drivers_trips')
            ->select(DB::raw('driver_id, sum(TIMESTAMPDIFF(minute, pickup, dropoff)) as total_minutes'))
             //->where('status', '<>', 1)
            ->groupBy('driver_id')
            ->orderBy('total_minutes', $orderBy)
            ->get();
        $array = [];
        $rusult = [];
        foreach ($drivers as $driver) {
            $array["driver_id"] = $driver->driver_id;
            $array["total"] = $driver->total_minutes;
            
            $rusult[] = $array;
        }
        return $rusult;
    }
    /**
     * @param string $order
     * 
     * @return json
     */
    public function angularOrder($order)
    {
        $drivers = $this->getTotalMinutesWithPassenger($order);
        return response()->json($drivers);
    }
    public function angular()
    {
       $drivers = $this->getTotalMinutesWithPassenger();
        return response()->json($drivers);
    }
}
