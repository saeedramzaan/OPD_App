@extends('layouts.app')



@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-center" style="display: flex; justify-content:center">
                <h2>Set Appointment Day and Time</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="http://localhost:8000/time/create"> Add Day </a>
            </div>

        </div>

    </div>



    @if ($message = Session::get('success'))
        <div class="alert alert-success" style="display: flex; justify-conent:center">
            <p>{{ $message }}</p>
        </div>
    @endif



    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Start time</th>
            <th>End time</th>
            <th>Duration</th>
            <th>Day</th>
        </tr>

        @foreach ($times as $time)
            <tr>


                <td>{{ $time->id }}</td>
                <td> {{ $convert_start_time = date('H:i', strtotime($time->start_time)) }} </td>
                <td> {{ $convert_end_time = date('H:i', strtotime($time->end_time)) }} </td>
                <td>{{ $time->duration }}</td>

                <th> {{ $time->day }}

                <td>

                    <form action="" method="POST">

                        <a class="btn btn-primary" href="{{ route('time.edit', $time->id) }}">Edit</a>

                        <a class="btn btn-danger" href="{{ route('del', $time->id) }}">Delete</a>

                    </form>

                </td>

            </tr>
        @endforeach

    </table>
@endsection
