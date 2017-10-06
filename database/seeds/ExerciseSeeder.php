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
                'bodypart_id' => 1
            ],
            [
                'name' => 'Shoulder Press',
                'bodypart_id' => 2
            ],
            [
                'name' => 'Back Squats',
                'bodypart_id' => 3
            ],
            [
                'name' => 'Bench Press',
                'bodypart_id' => 4
            ],
            [
                'name' => 'Pull ups',
                'bodypart_id' => 5
            ]
        );

        \App\Exercise::insert($aData);
    }
}
