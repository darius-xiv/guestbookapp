<?php

use Illuminate\Database\Seeder;

class FilipayUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('filipay_users')->insert([
            'first_name' => str_random(10),
            'last_name' => str_random(10),
            'username' => str_random(10),
            'password' => bcrypt('secret'),
            'gender' => str_random(6),
            'b_day' => date('Y-m-d'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
