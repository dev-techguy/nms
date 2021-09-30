<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Admin',
                    'email' => 'matthewokusimba@gmail.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => Str::random(),
                    'phone' => NULL,
                    'id_number' => NULL,
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Test User',
                    'email' => 'testuser10@mailinator.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => Str::random(),
                    'phone' => NULL,
                    'id_number' => NULL,
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Alex Driver',
                    'email' => 'alexdriver@mailinator.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0722112211',
                    'id_number' => NULL,
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Edith Driver',
                    'email' => 'edithdriver@mailinator.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0724983616',
                    'id_number' => '123456',
                    'fcm_token' => '123Test',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'Evans Driver',
                    'email' => 'evansdriver@gmail.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0721826286',
                    'id_number' => NULL,
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'Moses Driver',
                    'email' => 'mosesgathecha@gmail.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0729436198',
                    'id_number' => '123123',
                    'fcm_token' => 'Test',
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            8 =>
                array(
                    'id' => 9,
                    'name' => 'Test EMT',
                    'email' => 'testemt@mailinator.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0788112233',
                    'id_number' => '112233',
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
            9 =>
                array(
                    'id' => 10,
                    'name' => 'Test Nurse',
                    'email' => 'testnurse@mailinator.com',
                    'email_verified_at' => NULL,
                    'password' => bcrypt('password'),
                    'two_factor_secret' => NULL,
                    'two_factor_recovery_codes' => NULL,
                    'remember_token' => NULL,
                    'phone' => '0788445566',
                    'id_number' => '445566',
                    'fcm_token' => NULL,
                    'created_at' => now(),
                    'updated_at' => now(),
                ),
        ));

        DB::table((new User())->getTable())->insert([
            array(
                'id' => 7,
                'name' => 'Test Watcher',
                'email' => 'testwatcher@mailinator.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('password'),
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'phone' => NULL,
                'is_watcher' => true,
                'id_number' => NULL,
                'fcm_token' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
            array(
                'id' => 8,
                'name' => 'Test Dispatcher',
                'email' => 'testdispatcher@mailinator.com',
                'email_verified_at' => NULL,
                'password' => bcrypt('password'),
                'two_factor_secret' => NULL,
                'two_factor_recovery_codes' => NULL,
                'remember_token' => NULL,
                'phone' => NULL,
                'is_dispatcher' => true,
                'id_number' => NULL,
                'fcm_token' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ),
        ]);
    }
}
