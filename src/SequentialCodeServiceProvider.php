<?php

namespace Mdcoderu\SequentialCode;

use Illuminate\Support\ServiceProvider;

class SequentialCodeServiceProvider extends ServiceProvider
{
    /**
     * Регистрация сервисов пакета.
     */
    public function register(): void
    {
        // Объединение конфигурации пакета
        $this->mergeConfigFrom(
            __DIR__.'/../config/sequential-code.php', 'sequential-code'
        );
    }

    /**
     * Загрузка сервисов пакета.
     */
    public function boot(): void
    {
        // Публикация миграции и конфигурации
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'sequential-code-migrations');
            $this->publishes([
                __DIR__.'/../config/sequential-code.php' => config_path('sequential-code.php'),
            ], 'sequential-code-config');
        }
    }

    /**
     * Получить путь к конфигурационному файлу пакета.
     */
    public function configPath(): string
    {
        return __DIR__.'/../config/sequential-code.php';
    }
}
