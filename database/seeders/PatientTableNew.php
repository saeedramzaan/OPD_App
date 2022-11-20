<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatientTableNew extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
            'appointment_no' => '11',
            'name' => 'Test Patient',
            'email' => 'testpatient@gmail.com',
            'address' => '34 Colombo',
            'mobile_no' => '0775558889',
            'date' => '2012-10-11',
            'time' => '11:00'
        ]);

    }

    public function test_database1(){

        $this->assertDatabasehas('patients', [
            'name' => 'Test Patient'
        ]);
    }
}
