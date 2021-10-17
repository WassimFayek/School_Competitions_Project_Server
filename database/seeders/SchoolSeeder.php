<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use\App\Models\school;
class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        school::create([
            'school_name' => 'XYZschool',
            'school_address' => 'certain region on earth',
            'school_phone' => '1234564',
            'is_approved' => '1',
        ]);
    }
}
