<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'name' => Str::random(10),
            'email' => 'admin' . '@gmail.com',
            'password' => Hash::make('admin1'),
        ]);

        $faker = Faker\Factory::create('id_ID');
    }
}
