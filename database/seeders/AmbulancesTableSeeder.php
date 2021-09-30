<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmbulancesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('ambulances')->insert(array(
            0 =>
                array(
                    'id' => 6,
                    'dispatch_center_id' => 5,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 8,
                    'driver_stats' => 4,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 7,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'id' => 7,
                    'dispatch_center_id' => 6,
                    'basic_stats' => 0,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 3,
                    'driver_stats' => 0,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            2 =>
                array(
                    'id' => 8,
                    'dispatch_center_id' => 9,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 5,
                    'driver_stats' => 2,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            3 =>
                array(
                    'id' => 9,
                    'dispatch_center_id' => 8,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 10,
                    'driver_stats' => 5,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 7,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            4 =>
                array(
                    'id' => 10,
                    'dispatch_center_id' => 10,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 2,
                    'driver_stats' => 2,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            5 =>
                array(
                    'id' => 11,
                    'dispatch_center_id' => 11,
                    'basic_stats' => 2,
                    'advanced_stats' => 2,
                    'EMTs_stats' => 2,
                    'driver_stats' => 2,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            6 =>
                array(
                    'id' => 13,
                    'dispatch_center_id' => 12,
                    'basic_stats' => 1,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 18,
                    'driver_stats' => 20,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            7 =>
                array(
                    'id' => 14,
                    'dispatch_center_id' => 13,
                    'basic_stats' => 0,
                    'advanced_stats' => 4,
                    'EMTs_stats' => 4,
                    'driver_stats' => 3,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            8 =>
                array(
                    'id' => 15,
                    'dispatch_center_id' => 14,
                    'basic_stats' => 5,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 0,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 5,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            9 =>
                array(
                    'id' => 16,
                    'dispatch_center_id' => 15,
                    'basic_stats' => 2,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 4,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 5,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            10 =>
                array(
                    'id' => 17,
                    'dispatch_center_id' => 16,
                    'basic_stats' => 6,
                    'advanced_stats' => 7,
                    'EMTs_stats' => 22,
                    'driver_stats' => 28,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 18,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            11 =>
                array(
                    'id' => 18,
                    'dispatch_center_id' => 17,
                    'basic_stats' => 0,
                    'advanced_stats' => 3,
                    'EMTs_stats' => 15,
                    'driver_stats' => 12,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            12 =>
                array(
                    'id' => 20,
                    'dispatch_center_id' => 18,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 4,
                    'driver_stats' => 2,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 4,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            13 =>
                array(
                    'id' => 21,
                    'dispatch_center_id' => 19,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 3,
                    'driver_stats' => 3,
                    'shift_stats' => 1,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            14 =>
                array(
                    'id' => 22,
                    'dispatch_center_id' => 20,
                    'basic_stats' => 4,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 0,
                    'driver_stats' => 45,
                    'shift_stats' => 7,
                    'staff_per_shift_stats' => 1,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            15 =>
                array(
                    'id' => 23,
                    'dispatch_center_id' => 21,
                    'basic_stats' => 2,
                    'advanced_stats' => 2,
                    'EMTs_stats' => 4,
                    'driver_stats' => 3,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            16 =>
                array(
                    'id' => 24,
                    'dispatch_center_id' => 22,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 5,
                    'driver_stats' => 0,
                    'shift_stats' => 5,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            17 =>
                array(
                    'id' => 25,
                    'dispatch_center_id' => 23,
                    'basic_stats' => 1,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 5,
                    'shift_stats' => 3,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            18 =>
                array(
                    'id' => 26,
                    'dispatch_center_id' => 24,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 1,
                    'driver_stats' => 2,
                    'shift_stats' => 4,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            19 =>
                array(
                    'id' => 27,
                    'dispatch_center_id' => 20,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 1,
                    'driver_stats' => 2,
                    'shift_stats' => 4,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            20 =>
                array(
                    'id' => 28,
                    'dispatch_center_id' => 25,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 0,
                    'driver_stats' => 10,
                    'shift_stats' => 5,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            21 =>
                array(
                    'id' => 29,
                    'dispatch_center_id' => 26,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 2,
                    'driver_stats' => 3,
                    'shift_stats' => 4,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            22 =>
                array(
                    'id' => 30,
                    'dispatch_center_id' => 27,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 2,
                    'driver_stats' => 2,
                    'shift_stats' => 1,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            23 =>
                array(
                    'id' => 31,
                    'dispatch_center_id' => 28,
                    'basic_stats' => 2,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 4,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 1,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            24 =>
                array(
                    'id' => 32,
                    'dispatch_center_id' => 30,
                    'basic_stats' => 1,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 1,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            25 =>
                array(
                    'id' => 33,
                    'dispatch_center_id' => 31,
                    'basic_stats' => 1,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 1,
                    'driver_stats' => 1,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            26 =>
                array(
                    'id' => 34,
                    'dispatch_center_id' => 32,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 2,
                    'driver_stats' => 2,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            27 =>
                array(
                    'id' => 35,
                    'dispatch_center_id' => 33,
                    'basic_stats' => 0,
                    'advanced_stats' => 6,
                    'EMTs_stats' => 5,
                    'driver_stats' => 5,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            28 =>
                array(
                    'id' => 36,
                    'dispatch_center_id' => 34,
                    'basic_stats' => 2,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 4,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 3,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            29 =>
                array(
                    'id' => 37,
                    'dispatch_center_id' => 35,
                    'basic_stats' => 2,
                    'advanced_stats' => 0,
                    'EMTs_stats' => 0,
                    'driver_stats' => 3,
                    'shift_stats' => 5,
                    'staff_per_shift_stats' => 0,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            30 =>
                array(
                    'id' => 38,
                    'dispatch_center_id' => 36,
                    'basic_stats' => 0,
                    'advanced_stats' => 1,
                    'EMTs_stats' => 2,
                    'driver_stats' => 3,
                    'shift_stats' => 2,
                    'staff_per_shift_stats' => 2,
                    'gps_enabled' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));


    }
}