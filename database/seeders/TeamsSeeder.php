<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use\App\Models\team;
class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        team::create([
            'team_name' => 'XYZ school Team',
            'description' => 'Testing seeder record',
            'school_id' => '1',
            'user_id' => '2',
        ]);
    }
}
