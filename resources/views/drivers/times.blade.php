@extends('default')

@section('content')
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>driver_id</th>
            <th>pickup</th>
            <th>dropoff</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($drivers as $driver)
            <tr>
                <td>{{ $driver['id'] }}</td>
                <td>{{ $driver['driver_id'] }}</td>
                <td>{{ $driver['pickup'] }}</td>
                <td>{{ $driver['dropoff'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@stop