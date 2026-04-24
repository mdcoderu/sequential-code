# Laravel Sequential Code

Laravel пакет для генерации последовательных -значных кодов для моделей с поддержкой ручного указания кода.

## Возможности

- ✅ Автоматическая генерация уникальных 6-значных кодов
- ✅ Возможность ручного указания кода
- ✅ Потокобезопасность через транзакции и блокировки
- ✅ Отдельная таблица счетчиков для каждой модели
- ✅ Конфигурируемые границы кодов

## Установка

### 1. Добавление пакета через Composer

```bash
composer require mdcoderu/sequential-code
```

### 2. Публикация миграции

```bash
php artisan vendor:publish --tag="sequential-code-migrations"
```

### 3. Запуск миграций

```bash
php artisan migrate
```

## Использование

### Базовое использование

Примените trait `HasSequentialCode` к вашей модели:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mdcode\SequentialCode\Traits\HasSequentialCode;

use Mdcoderu\SequentialCode\Traits\HasSequentialCode;

class Order extends Model
{
    use HasSequentialCode;
    
    // ...
}
```

Теперь при создании новой записи код будет генерироваться автоматически:

```php
$order = Order::create([
    // другие поля...
]);

echo $order->code; // "100000", "100001", ...
```

### Ручное указание кода

Вы можете указать код вручную:

```php
$order = Order::create([
    'code' => 123456,
    // другие поля...
]);
```

### Кастомный ключ счетчика

По умолчанию в качестве ключа счетчика используется имя таблицы модели. Если нужно использовать кастомный ключ, переопределите метод `getSequentialCodeKey()`:

```php
class Order extends Model
{
    use HasSequentialCode;
  
    protected function getSequentialCodeKey(): string
    {
        return 'order_' . $this->type;
    }
}
```

## Конфигурация

Пакет имеет конфигурационный файл `config/sequential-code.php`:

```php
return [
    'min_code' => 100000, // Минимальное значение кода
    'max_code' => 999999, // Максимальное значение кода
];
```

Вы можете опубликовать конфигурацию:

```bash
php artisan vendor:publish --tag="sequential-code-config"
```

## Таблица model_counters

Пакет использует таблицу `model_counters` для хранения текущих значений счетчиков:


| Поле | Тип           | Описание                                 |
| -------- | ---------------- | ------------------------------------------------ |
| key      | string (primary) | Уникальный ключ счетчика   |
| value    | unsigned integer | Текущее значение счетчика |

## Ограничения

- Код должен быть 6-значным числом (от 100000 до 999999)
- При достижении максимума (999999) будет выброшено исключение `RuntimeException`
- Для каждого ключа счетчика хранится отдельное значение

## Лицензия

MIT
