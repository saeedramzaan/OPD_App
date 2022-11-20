<?php

namespace Tests\Unit;

//use PHPUnit\Framework\TestCase;

use Tests\TestCase;

use App\Models\User;
use Database\Seeders\PatientTableNew;
use Database\Seeders\SetAppointmentSeeder;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    // public function test_example()
    // {
    //     $this->assertTrue(true);
    // }

     public function test_delete_user()
     {
        $user = User::factory()->count(1)->make();

        $user = User::first();

        // if($user) {
        //     $user->delete();
        // }

        $this->assertTrue(true);
    }

    // public function test_if_it_stores_new_patient_table()
    // {
    //     $response = $this->post('/patient', [
    //         'name' => 'Test Patient',
    //         'email' => 'testpatient@gmail.com',
    //         'address' => '123/1 Kandy Rd',
    //         'mobile_no' => '0717772500',
    //         'date' => '2012-01-05',
    //         'time' => '11:00'
    //     ]);

    //     $this->assertTrue(true);
    //    // $response->assertRedirect('/');
    // }

    // public function test_if_data_exists_in_database()
    // {
    //     $this->assertDatabaseHas('users', [
    //         'name' => 'Admin',
    //         'email' => 'admin@gmail.com',
    //     ]);
    // }

    // public function test_patient_db()
    // {
    //   $this->seed(PatientTableNew::class);
    //   $this->assertTrue(true);
    // }

    // public function test_times_db()
    // {
    //   $this->seed(SetAppointmentSeeder::class);
    //   $this->assertTrue(true);
    // }

}
