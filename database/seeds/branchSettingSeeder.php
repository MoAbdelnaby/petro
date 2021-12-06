<?php

use Illuminate\Database\Seeder;

class branchSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
