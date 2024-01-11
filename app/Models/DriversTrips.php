<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriversTrips extends Model
{
    use HasFactory;
    
    protected $table = 'drivers_trips';
    protected $fillable = [
        'driver_id',
        'pickup',
        'dropoff',
    ];
    public $timestamps = false;
}
