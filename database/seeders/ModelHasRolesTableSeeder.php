<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModelHasRolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_roles')->insert(array (
            0 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 1,
            ),
            1 =>
            array (
                'role_id' => 1,
                'model_type' => 'App\\Models\\User',
                'model_id' => 2,
            ),
            2 =>
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 7,
            ),
            3 =>
            array (
                'role_id' => 3,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            4 =>
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 3,
            ),
            5 =>
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 4,
            ),
            6 =>
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 5,
            ),
            7 =>
            array (
                'role_id' => 4,
                'model_type' => 'App\\Models\\User',
                'model_id' => 6,
            ),
            8 =>
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 7,
            ),
            9 =>
            array (
                'role_id' => 5,
                'model_type' => 'App\\Models\\User',
                'model_id' => 8,
            ),
            10 =>
            array (
                'role_id' => 6,
                'model_type' => 'App\\Models\\User',
                'model_id' => 9,
            ),
            11 =>
            array (
                'role_id' => 7,
                'model_type' => 'App\\Models\\User',
                'model_id' => 10,
            ),
        ));


    }
}
