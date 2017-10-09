<?php

use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
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
                'name' => 'Biceps Curl',
                'body_part_id' => 1
            ],
            [
                'name' => 'Shoulder Press',
                'body_part_id' => 2
            ],
            [
                'name' => 'Back Squats',
                'body_part_id' => 3
            ],
            [
                'name' => 'Bench Press',
                'body_part_id' => 4
            ],
            [
                'name' => 'Pull ups',
                'body_part_id' => 5
            ]
        );

        \App\Exercise::insert($aData);
    }
}
