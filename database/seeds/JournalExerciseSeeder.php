<?php

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;

class JournalExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = new Faker;
        $aJournals = factory( App\Journal::class , 12 )->create()->each(function($journal) {
            //randomize: select 1 to 3 exercises
            $exercises = App\Exercise::all()->random( rand(1, 3) );
            
            foreach ($exercises as $exercise) {
                $exercise_id = $exercise->id;
    
                $journal->exercises()->attach( $exercise_id, [
                    'sets' => rand(1,4),
                    'reps' => rand(6,15),
                    'weight' => rand(30, 50)
                ]);
            }
        });
    }
}
