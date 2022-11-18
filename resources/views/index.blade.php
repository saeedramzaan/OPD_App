@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Filter Appointments</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-url" content="{{ url('/') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>

    <body>

        <section class="section--projects">
            <div class="container">
                <h2 class="text-center mt-5 mb-3">Filter Appiontments</h2>
                <div class="card">

                    <div class="card-header">

                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label>Type below</label>
                            <input type="text" name="search" id="search" placeholder="Enter the key"
                                class="form-control">
                        </div>

                        <div id="alert-div">
                        </div>

                        <!-- view record modal -->
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Mobile No</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody id="bodyData">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>


        <script type="text/javascript">
            showAllProjects();

            function showAllProjects() {

                //  console.log('test');
                let url = $('meta[name=app-url]').attr("content") + "/patientInfo";
                $.ajax({
                    url: "http://localhost:8000/patientInfo",
                    type: "GET",
                    cache: false,
                    dataType: 'json',
                    success: function(dataResult) {
                        //   console.log(dataResult);
                        var resultData = dataResult.data;
                        var bodyData = '';
                        var i = 1;
                        let editBtn;
                        $.each(resultData, function(index, row) {

                            var time = row.time;

                            var array = time.split(":");

                            var time_array = (array[0] + " : " + array[1]);

                            var editUrl = url + '/' + row.id + "/edit";
                            let showBtn = '<button ' +
                                ' class="btn btn-outline-success" ' +
                                ' onclick="">Show' +
                                '</button> ';

                            let editBtn = '<button ' +
                                ' class="btn btn-outline-success" ' +
                                ' onclick="">Edit' +
                                '</button> ';
                            let deleteBtn = '<button ' +
                                ' class="btn btn-outline-danger" ' +
                                ' onclick="">Delete' +
                                '</button>';

                            bodyData += "<tr>"
                            bodyData += "<td>" + i++ + "</td><td>" + row.name +
                                "</td><td>" + row.email + "</td><td>" + row.address + "</td><td>" + row
                                .mobile_no + "</td><td>" + row.date + "</td><td>" + time_array + "</td>"
                            bodyData += "</tr>";
                            $("#bodyData").html("");
                        })
                        $("#bodyData").append(bodyData);
                    }
                });
            }


            /*
                submit the form and will be stored to the database
            */

            $(document).ready(function() {
                $('#search').on('keyup', function() {
                    var query = $(this).val();
                    let url = $('meta[name=app-url]').attr("content") + "/projects";
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "http://localhost:8000/search",
                        type: "GET",
                        cache: false,
                        data: {
                            'name': query
                        },
                        dataType: 'json',
                        success: function(dataResult) {
                            var resultData = dataResult.data;
                            var bodyData = '';
                            var i = 1;
                            let editBtn;
                            $.each(resultData, function(index, row) {

                                var time = row.time;

                                var array = time.split(":");

                                var time_array = (array[0] + " : " + array[1]);

                                var editUrl = url + '/' + row.id + "/edit";
                                let showBtn = '<button ' +
                                    ' class="btn btn-outline-success" ' +
                                    ' onclick="">Show' +
                                    '</button> ';

                                let editBtn = '<button ' +
                                    ' class="btn btn-outline-success" ' +
                                    ' onclick="">Edit' +
                                    '</button> ';
                                let deleteBtn = '<button ' +
                                    ' class="btn btn-outline-danger" ' +
                                    ' onclick="">Delete' +
                                    '</button>';
                                bodyData += "<tr>"
                                bodyData += "<td>" + i++ + "</td><td>" + row.name +
                                    "</td><td>" + row.email + "</td><td>" + row.address +
                                    "</td><td>" + row.mobile_no + "</td><td>" + row.date +
                                    "</td><td>" + time_array + "</td>"
                                bodyData += "</tr>";
                                $("#bodyData").html("");
                            })
                            $("#bodyData").append(bodyData);
                        }
                    });
                });
            });
        </script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>

    </html>
@endsection
