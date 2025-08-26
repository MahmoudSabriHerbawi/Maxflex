<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Series;
use App\Models\Episode;
use App\Models\Category;
use App\Policies\SeriesPolicy;
use App\Policies\EpisodePolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Series::class   => SeriesPolicy::class,
        Episode::class  => EpisodePolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
