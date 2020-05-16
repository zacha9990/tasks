<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('id_ID');

        DB::table('positions')->insert([
            'name' => 'Director'
        ]);

        DB::table('positions')->insert([
            'name' => 'Senior Staff'
        ]);

        DB::table('positions')->insert([
            'name' => 'Junior Staff'
        ]);

        DB::table('education')->insert([
            'name' => 'SD'
        ]);

        DB::table('education')->insert([
            'name' => 'SMP'
        ]);

        DB::table('education')->insert([
            'name' => 'SMA'
        ]);

        DB::table('education')->insert([
            'name' => 'S1'
        ]);

        DB::table('education')->insert([
            'name' => 'S2'
        ]);

        DB::table('education')->insert([
            'name' => 'S3'
        ]);

        DB::table('employees')->insert([
            'photo' => $faker->imageUrl($width = 640, $height = 480, 'people', 'Faker'),
            'name' => $faker->name,
            'email' => 'pegawai' . '@gmail.com',
            'place_of_birth' => $faker->city,
            'date_of_birth' => $faker->dateTimeThisCentury->format('Y-m-d'),
            'address' => $faker->streetAddress,
            'phone' => $faker->phoneNumber,
            'sex' => 'Male',
            'position_id' => 1,
            'education_id' => 6,
            'password' => Hash::make('pegawai1'),
        ]);

        for ($i = 0; $i < 50; $i++) {
            DB::table('employees')->insert([
                'photo' => $faker->imageUrl($width = 640, $height = 480, 'people', 'Faker'),
                'name' => $faker->name,
                'email' => $faker->email,
                'place_of_birth' => $faker->city,
                'date_of_birth' => $faker->dateTimeThisCentury->format('Y-m-d'),
                'address' => $faker->streetAddress,
                'phone' => $faker->phoneNumber,
                'sex' => ($i % 2 == 0) ? 'Male' : 'Female',
                'position_id' => rand(1, 3),
                'education_id' => rand(1, 6),
                'password' => Hash::make('pegawailain'),
            ]);
        }
    }
}
