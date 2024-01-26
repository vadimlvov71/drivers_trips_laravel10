<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriversTrips;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

/**
* @author Vadim Podolyan <vadim.podolyan@gmail.com>

 * via form a csv file is uploaded and data inserted in database
 * and counting drivers trip minutes
 */
class DriversPayableTimeController extends Controller
{
     
    /**
     * entry point - form with uploading
     */
    public function index()
    {
        return view('drivers.index');
    }


    /**
     * @param Request $request
     * 
     * @return [view]
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('image');
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file->getClientOriginalName());
        $drivers = $this->readCsv();
        $this->store($drivers);
        return view('drivers.times', compact('drivers'));
    }

    /**
     * @param array $drivers
     * insert data to database
     * @return void
     */
    public function store(array $drivers = []): void
    {
        
        foreach($drivers as $key => $driver_trip) {
            $trips = new DriversTrips;
            $trips->driver_id = $driver_trip['driver_id'];
            $trips->pickup = $driver_trip['pickup'];
            $trips->dropoff = $driver_trip['dropoff']; 
            $trips->save();  
        }
    }
    
    /**
     * read csv file
     */
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
        select DISTINCT pickup as trip_start, driver_id
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
     * @return JsonResponse
     */
    public function angularOrder($order): JsonResponse
    {
        $drivers = $this->getTotalMinutesWithPassenger($order);
        return response()->json($drivers);
    }
    /**
     * @return JsonResponse
     */
    public function angular(): JsonResponse
    {
        $drivers = $this->getTotalMinutesWithPassenger();
        return response()->json($drivers);
    }
}
