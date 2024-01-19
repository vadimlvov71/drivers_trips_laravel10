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
    /**
     * count distinct driver`s trips minutes
     * @param string $orderBy
     * 
     * @return array
     */
    public function getTotalMinutesWithPassenger(string $orderBy = "DESC"): array
    {
       
        $statement = "
        select sum(TIMESTAMPDIFF(minute, trip_start, trip_end)) as total_minutes, t1.driver_id
        from
        (
        select DISTINCT pickup as trip_start , driver_id
        from drivers_trips
        ) as t1
        JOIN
        (
        select DISTINCT dropoff as trip_end, driver_id, pickup
        from drivers_trips
        ) as t2
        ON t1.trip_start = t2.pickup
        AND t1.driver_id = t2.driver_id
        GROUP BY t1.driver_id
        ";
        $drivers_trips_total = DB::select($statement);
         
        return $drivers_trips_total;
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
    /**
     * @return json
     */
    public function angular()
    {
        $drivers = $this->getTotalMinutesWithPassenger();
        return response()->json($drivers);
    }
}
