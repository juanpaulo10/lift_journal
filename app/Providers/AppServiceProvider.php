<?php

namespace App\Providers;

use App\Journal;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->includeSidebar();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function includeSidebar()
    {
        view()->composer('journals.sidebar', function ($oView) {
            $oView->with([
                'aMonthlyWorkouts' => Journal::monthlyWorkouts()
            ]);
        });
    }
}
