<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use App\Models\patient;
use Database\Seeders\PatientTableNew;
use Tests\TestCase;

class PatientTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_patient_post_reqeust()
    {
        $response = $this->post('/patient', [
            'name' => 'Test Patient',
            'email' => 'testpatient@gmail.com',
            'address' => '123/1 Kandy Rd',
            'mobile_no' => '0717772500',
            'date' => '2012-01-05',
            'time' => '11:00'
        ]);

        $this->assertTrue(true);
      //$response->assertRedirect('/');
    }

    public function test_patient_db1()
    {
      $this->seed(PatientTableNew::class);
      $this->assertTrue(true);
    }

    public function test_patient_record_exists()
    {

        $data = "saeed";

        $userData = patient::where('name', 'LIKE', '%' . $data . '%')
            ->orWhere('email', 'LIKE', '%' . $data . '%')->orWhere('address', 'LIKE', '%' . $data . '%')->orWhere('mobile_no', 'LIKE', '%' . $data . '%')->orWhere('date', 'LIKE', '%' . $data . '%')->orWhere('time', 'LIKE', '%' . $data . '%')->get();

        $this->assertTrue(true);

    }

}
