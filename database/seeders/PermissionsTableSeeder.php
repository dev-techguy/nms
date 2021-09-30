<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Manage Users',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Read Admin Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Read Reports',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Read Dispatchers Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'Read Driver Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'Read Watchers Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            6 =>
                array(
                    'id' => 7,
                    'name' => 'Read EMT Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            7 =>
                array(
                    'id' => 8,
                    'name' => 'Read Nurse Panel',
                    'guard_name' => 'web',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));


    }
}
