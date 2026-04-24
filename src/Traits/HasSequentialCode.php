<?php

namespace Mdcoderu\SequentialCode\Traits;

use Illuminate\Support\Facades\DB;

trait HasSequentialCode
{
    protected static function bootHasSequentialCode(): void
    {
        static::creating(function ($model) {
            $counterKey = $model->getSequentialCodeKey();

            DB::transaction(function () use ($model, $counterKey) {
                $row = DB::table('model_counters')
                    ->where('key', $counterKey)
                    ->lockForUpdate()
                    ->first();

                $minCode = config('sequential-code.min_code', 100000);
                $maxCode = config('sequential-code.max_code', 999999);

                // Если код задан вручную
                if (!empty($model->code)) {
                    $manual = (int) $model->code;

                    if ($manual < $minCode || $manual > $maxCode) {
                        throw new \RuntimeException("Код должен быть числом от {$minCode} до {$maxCode}");
                    }

                    if (!$row) {
                        DB::table('model_counters')->insert([
                            'key'   => $counterKey,
                            'value' => $manual,
                        ]);
                    } elseif ($row->value < $manual) {
                        DB::table('model_counters')
                            ->where('key', $counterKey)
                            ->update(['value' => $manual]);
                    }

                    return;
                }

                // Если код не задан — генерируем автоматически
                if (!$row) {
                    DB::table('model_counters')->insert([
                        'key'   => $counterKey,
                        'value' => $minCode,
                    ]);

                    $row = (object) ['value' => $minCode];
                }

                $next = $row->value + 1;

                if ($next > $maxCode) {
                    throw new \RuntimeException("Исчерпан лимит кодов от {$minCode} до {$maxCode}");
                }

                DB::table('model_counters')
                    ->where('key', $counterKey)
                    ->update(['value' => $next]);

                $model->code = (string) $next;
            });
        });
    }


    /**
     * Уникальный ключ счётчика для модели
     */
    protected function getSequentialCodeKey(): string
    {
        return $this->getTable();
    }
}
