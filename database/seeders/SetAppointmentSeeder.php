<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SetAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('times')->insert([
            'day' => 'Testday',
            'start_time' => '13:00',
            'end_time' => '17:00',
            'duration' => '20',
        ]);
    }

    public function test_database1(){

        $this->assertDatabasehas('patients', [
            'name' => 'Test Patient'
        ]);
    }
}
