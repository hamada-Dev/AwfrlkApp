<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Page;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
         //change public path
//        $this->app->bind('path.public', function() {
//        return base_path('public_html');
//         });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Resource::withoutWrapping();
        view()->share('categories', Category::get());
        // view()->share('destinations', Destination::get());
        // view()->share('hotels', Hotel::get());
        // view()->share('skills', Skill::get());
        // view()->share('pages', Page::get());
    }
}
