<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class branchSettingSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $create = \App\Models\BranchSetting::create([
            'type' => 'hours',
            'duration' => '2',
        ]);
    }
}
