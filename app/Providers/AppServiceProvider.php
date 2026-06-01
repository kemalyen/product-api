<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('local', 'staging') && !$this->isMigrationOrSeederCommand()) {
            Model::preventLazyLoading(
                fn($query) => $this->app->environment('local')
                    ? logger()->warning('Lazy loading detected: ' . $query->toSql())
                    : null
            );

            Model::handleLazyLoadingViolationUsing(function (Model $model, string $relation) {
                $class = $model::class;

                info("Attempted to lazy load [{$relation}] on model [{$class}].");
            });

            DB::listen(function ($query) {
                File::append(
                    storage_path('/logs/query.log'),
                    $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                );
            });
        }

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function isMigrationOrSeederCommand(): bool
    {
        $command = request()->server('argv')[1] ?? '';
        return in_array($command, ['migrate', 'migrate:fresh', 'migrate:reset', 'db:seed']);
    }
}
