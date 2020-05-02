<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FactoryFaker;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = FactoryFaker::create('pt_BR');

        User::firstOrCreate(
            [
                'email' => 'admin@email.com',
            ],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('admin'),
                'admin' => true,
                'status' => true
            ]
        );

        if (app()->environment('local')) {
            $this->funcionarios();
        }
    }

    private function funcionarios()
    {
        for ($i = 1; $i < 4; $i++) {
            User::firstOrCreate(
                [
                    'email' => "funcionario$i@email.com",
                ],
                [
                    'name' => $this->faker->firstName,
                    'email_verified_at' => now(),
                    'password' => Hash::make('funcionario'),
                    'admin' => false,
                    'status' => true
                ]
            );
        }
    }
}
