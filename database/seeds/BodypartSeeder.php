<?php

use Illuminate\Database\Seeder;

class BodypartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aData = array(
            [
                'name' => 'arms'
            ],
            [
                'name' => 'shoulder'
            ],
            [
                'name' => 'legs'
            ],
            [
                'name' => 'chest'
            ],
            [
                'name' => 'back'
            ]
        );

        \App\Body_part::insert($aData);
    }
}
