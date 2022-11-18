<?php

namespace App\Http\Controllers;

use App\Models\patient;
use App\Models\time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $patients = patient::all();

        return view('index', compact('patients'));

    }

    public function patientInfo()
    {

        $patients = patient::all();

        return json_encode(array('data' => $patients));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('createPatient');
    }

    public function search(Request $request)
    {

        $data = $request->name;

        $userData = patient::where('name', 'LIKE', '%' . $data . '%')
            ->orWhere('email', 'LIKE', '%' . $data . '%')->orWhere('address', 'LIKE', '%' . $data . '%')->orWhere('mobile_no', 'LIKE', '%' . $data . '%')->orWhere('date', 'LIKE', '%' . $data . '%')->orWhere('time', 'LIKE', '%' . $data . '%')->get();

        return json_encode(array('data' => $userData));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
            'email' => 'required',
            'mobile_no' => 'required|numeric|digits:10',
        ]);

        $appointment_date = $request->date;

        $d_format = Carbon::parse($appointment_date)->format('Y-m-d');

        $day = Carbon::createFromFormat('Y-m-d', $d_format)->format('l');

        $patient_record = patient::Where('email', $request->email)->Where('date', $d_format)->exists();

        //   return $patient_record;
        $app_id = DB::table('patients')->max('id') + 1;

        $appointment_id = $app_id;
        $name = $request->name;
        $email = $request->email;
        $address = $request->address;
        $mobile = $request->mobile_no;
        $date = $request->date;
        $msg = "Your appointment has been booked";

        if ($patient_record == null) {

            $last_record = patient::find(DB::table('patients')->Where('date', $appointment_date)->max('id'));

            if ($last_record == null) {

                $start_time = DB::table('times')->where('day', $day)->value('start_time');
                $shorted_start_time = date('H:i', strtotime($start_time));
                if ($start_time == null) {

                    return redirect("/create")->with('success', 'Doctor is not available on ' . $day);

                } else {

                    $message = "Appointment No: " . $appointment_id . "\r\n" . " Name :- " . $name . "\r\n" . " Email :- " . $email . "\n\n" . " Phone Number :- " . $mobile . "\n\n" . " Date :- " . $d_format . " Time :- " . $shorted_start_time . " Message :- " . $msg;

                    $patient = new patient();
                    $patient->name = $name;
                    $patient->email = $email;
                    $patient->address = $address;
                    $patient->mobile_no = $request->mobile_no;
                    $patient->date = $appointment_date;
                    $patient->time = $start_time;
                    $patient->save();

                    $details = [
                        'title' => 'Appointment Details',
                        'body' => $message,
                        'header' => 'Content-Type: text/plain; charset=ISO-8859-1\r\n',
                    ];

                    \Mail::to('saeedramzaan@gmail.com')->send(new \App\Mail\sendMail($details));

                    return redirect("/create")->with('success', 'Appointment details have been sent to your email. Please check');
                }
            } else {

                $time = $last_record->time;

                $end_time = DB::table('times')->where('day', $day)->value('end_time');

                $shorted_time = date('H:i', strtotime($time));
                $shorted_end_time = date('H:i', strtotime($end_time));

                if ($shorted_time == $shorted_end_time) {

                    return redirect("/create")->with('success', 'No appoinent is avaible today. Please try another day');

                } else {

                    $duration = DB::table('times')->where('day', $day)->value('duration');

                    $carbon_date = Carbon::parse($time);
                    $add_minutes = $carbon_date->addMinutes($duration);
                    $convert_time = date('H:i', strtotime($add_minutes));

                    $patient = new patient();
                    $patient->name = $name;
                    $patient->email = $email;
                    $patient->address = $address;
                    $patient->mobile_no = $mobile;
                    $patient->date = $appointment_date;
                    $patient->time = $convert_time;
                    $patient->save();

                    $message = " Appointment No: " . $appointment_id . "\r\n" . " Name :- " . $name . "\r\n" . " Email :- " . $email . "\n\n" . " Phone Number :- " . $mobile . "\n\n" . " Date :- " . $d_format . " Time :- " . $shorted_time . " Message :- " . $msg;

                    $details = [
                        'title' => 'Appointment Details',
                        'body' => $message,
                        'header' => 'Content-Type: text/plain; charset=ISO-8859-1\r\n',
                    ];

                    \Mail::to('saeedramzaan@gmail.com')->send(new \App\Mail\sendMail($details));

                    return redirect()->back()->with('success', 'Email has been sent');

                }
            }
        } else {

            return redirect("/create")->with('success', 'You have already booked the appiontment today');

        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
