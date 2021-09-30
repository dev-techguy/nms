<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_has_permissions')->insert(array(
            0 =>
                array(
                    'permission_id' => 1,
                    'role_id' => 1,
                ),
            1 =>
                array(
                    'permission_id' => 2,
                    'role_id' => 2,
                ),
            2 =>
                array(
                    'permission_id' => 3,
                    'role_id' => 2,
                ),
            3 =>
                array(
                    'permission_id' => 4,
                    'role_id' => 2,
                ),
            4 =>
                array(
                    'permission_id' => 4,
                    'role_id' => 3,
                ),
            5 =>
                array(
                    'permission_id' => 5,
                    'role_id' => 4,
                ),
            6 =>
                array(
                    'permission_id' => 6,
                    'role_id' => 5,
                ),
            7 =>
                array(
                    'permission_id' => 7,
                    'role_id' => 6,
                ),
            8 =>
                array(
                    'permission_id' => 8,
                    'role_id' => 7,
                ),
        ));


    }
}
