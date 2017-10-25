<?php

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;

class JournalExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Makes 12 journals with random data inside pivot tables.
     * For every journal, there is 1-3 exercises that will be inserted.
     * and it will be attached to the pivot table.
     *
     * @return void
     */
    public function run()
    {
        // $faker = new Faker;
        $aJournals = factory( App\Journal::class , 12 )->create()->each(function($journal) {
            //randomize: select 1 to 3 exercises for every journal created
            $exercises = App\Exercise::all()->random( rand(1, 3) );
            
            // input random data inside their pivot table.
            // and attach the same time.
            foreach ($exercises as $exercise) {
                $journal->exercises()->attach( $exercise->id, [
                    'sets' => rand(1,4),
                    'reps' => rand(6,15),
                    'weight' => rand(30, 50)
                ]);
            }
        });
    }
}
