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
        // Публикация миграции
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
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
