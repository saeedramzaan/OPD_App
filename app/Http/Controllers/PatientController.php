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
    public function __construct(Request $request)
    {
        $this->app_time = null;
        $this->app_no = 1;
        $this->common_insert = false;
        $this->email = $request->email;
        $this->date = $request->date;
    }

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

    public function getArray()
    {

    }

    public function search(Request $request)
    {

        $data = $request->name;

        $userData = patient::where('name', 'LIKE', '%' . $data . '%')
            ->orWhere('email', 'LIKE', '%' . $data . '%')->orWhere('address', 'LIKE', '%' . $data . '%')->orWhere('mobile_no', 'LIKE', '%' . $data . '%')->orWhere('date', 'LIKE', '%' . $data . '%')->orWhere('time', 'LIKE', '%' . $data . '%')->get();

        return json_encode(array('data' => $userData));
    }

    public function is_patient_exist()
    {

        $appointment_date = $this->date;

        $d_format = Carbon::parse($appointment_date)->format('Y-m-d');

        $patient_record = patient::Where('email', $this->email)->Where('date', $d_format)->exists();

        return $patient_record;
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
            'name' => 'required|max:255',
            'email' => 'required|',
            'mobile_no' => 'required|numeric|digits:10',
        ]);

        $appointment_date = $request->date;

        $app_id = DB::table('patients')->Where('date', $appointment_date)->max('appointment_no');

        $d_format = Carbon::parse($appointment_date)->format('Y-m-d');

        $day = Carbon::createFromFormat('Y-m-d', $d_format)->format('l');

        $name = $request->name;
        $email = $request->email;
        $address = $request->address;
        $mobile = $request->mobile_no;
        $date = $request->date;
        $msg = "Your appointment has been booked";

        if ($this->is_patient_exist() == null) {

            if ($app_id == null) {

                $start_time = DB::table('times')->where('day', $day)->value('start_time');
                $shorted_start_time = date('H:i', strtotime($start_time));

                if ($start_time == null) {

                    return redirect("/create")->with('success', 'Doctor is not available on ' . $day);

                } else {

                    $this->app_time = $shorted_start_time;
                    $this->common_insert = true;
                }
            } else {

                $last_record = patient::find(DB::table('patients')->Where('date', $appointment_date)->max('id'));

                if ($last_record == null) {

                    return "No last record";

                } else {

                    $time = $last_record->time;

                    $end_time = DB::table('times')->where('day', $day)->value('end_time');

                    $shorted_time = date('H:i', strtotime($time));

                    $shorted_end_time = date('H:i', strtotime($end_time));

                    if ($shorted_time == $shorted_end_time) {

                        return redirect("/create")->with('success', 'No appoinent is avaible today. Please try another day');

                    } else {

                        $this->common_insert = true;
                        $this->app_no = $app_id + 1;

                        $duration = DB::table('times')->where('day', $day)->value('duration');

                        $carbon_date = Carbon::parse($time);
                        $add_minutes = $carbon_date->addMinutes($duration);
                        $convert_time = date('H:i', strtotime($add_minutes));

                        $this->app_time = date('H:i', strtotime($convert_time));

                    }
                }
            }
        } else {

            return redirect("/create")->with('success', 'You have already booked the appiontment today');

        }

        if ($this->common_insert == true) {

            $patient = new patient();
            $patient->appointment_no = $this->app_no;
            $patient->name = $name;
            $patient->email = $email;
            $patient->address = $address;
            $patient->mobile_no = $mobile;
            $patient->date = $appointment_date;
            $patient->time = $this->app_time;
            $patient->save();

            $message = " Appointment No: " . $this->app_no . "/" . " Name: " . $name . "/" . " Email: " . $email . "/" . " Phone Number: " . $mobile . "/" . " Date: " . $d_format . "/" . " Time: " . $this->app_time . "/" . " Message: " . $msg;

            $details = [
                'title' => 'Appointment Details',
                'body' => $message,
                'header' => 'Content-Type: text/plain; charset=ISO-8859-1\r\n',
            ];

            \Mail::to('saeedramzaan@gmail.com')->send(new \App\Mail\sendMail($details));

            return redirect()->back()->with('success', 'Appointment details have been sent to your email. Please check..');

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
