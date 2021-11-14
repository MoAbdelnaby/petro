<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::withoutEvents(function () {
            $user = \App\User::updateOrCreate(
                ['id'=>3],
                [
                    'systempass'=>'petro@wakeb2030',
                ]
            );
            return $user;
        });
    }
}
