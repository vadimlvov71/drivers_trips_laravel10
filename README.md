

## Laravel 10 taxi drivers trip total calculation


- php 8.2.
- Mysql.
```
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
```
### routes:

#### http://localhost/
- page with uploading form
#### http://localhost:83/uploadfile
- page: with a list of all trips:
- ![изображение](https://github.com/vadimlvov71/drivers_trips_laravel10/assets/57807117/75f6cf5e-1f8a-421c-86db-a20b091565cd)
#### http://localhost:83/angular_order/desc
- page: with a list of calculated total time of trips:
- ![изображение](https://github.com/vadimlvov71/drivers_trips_laravel10/assets/57807117/4d368930-faaf-49f9-ad73-2d43e6421449)
### Install:
- create database:  drivers_trip
- make migration for 2024_01_03_105636_create_drivers_trips_table.php
### php artisan test
- php artisan test
- 
![изображение](https://github.com/vadimlvov71/drivers_trips_laravel10/assets/57807117/76a9a4e5-d7f0-4ef5-854b-1ac652f3ee80)







