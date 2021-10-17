<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
       
        protected $users = [
        [
            'name' => 'Admin',
            'email' => 'Admin@gmail.com',
            'password' => 'admin123',
            'role' => '1',
            'school_id' => '0',
        ],
        [
            'name' => 'coordinatorSeeder',
            'email' => 'coordinator@gmail.com',
            'password' => 'coordinator123',
            'role' => '2',
            'school_id' => '1',
        ],
        [
            'name' => 'coachSeeder',
            'email' => 'coach@gmail.com',
            'password' => 'coach123',
            'role' => '3',
            'school_id' => '1',
        ],
        ];
    public function run()
    {
        foreach($this->users as $user) {
            User::create(array_merge(
                $user,
            ['password'=> bcrypt($user['password'])]
        ));
        }
    }

}
