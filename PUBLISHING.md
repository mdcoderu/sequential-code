# Публикация пакета

## 1. Создание репозитория на GitHub

1. Перейдите на [GitHub](https://github.com/new)
2. Имя репозитория: `sequential-code`
3. Владелец: `mdcoderu`
4. Сделайте репозиторий публичным
5. Не инициализируйте с README, .gitignore или лицензией (у нас уже есть)

```bash
# Добавьте удалённый репозиторий
git remote add origin git@github.com:mdcoderu/sequential-code.git

# Загрузите код
git push -u origin master
```

## 2. Создание тега для релиза

```bash
# Создайте аннотированный тег
git tag -a v1.0.0 -m "Release v1.0.0"

# Загрузите тег
git push origin v1.0.0
```

## 3. Регистрация на Packagist

1. Перейдите на [Packagist](https://packagist.org/packages/new)
2. Введите URL репозитория: `https://github.com/mdcoderu/sequential-code`
3. Нажмите "Check"

## 4. Настройка вебхука (автоматические обновления)

Packagist предложит добавить вебхук в GitHub:
- Перейдите в настройки репозитория на GitHub
- Webhooks → Add webhook
- Payload URL: `https://packagist.org/api/github?username=ВАШ_USERNAME&apiToken=ВАШ_TOKEN`
- Content type: `application/json`
- Событие: `Push events`

## 5. Установка пакета

После публикации пакет можно установить в любой Laravel проект:

```bash
composer require mdcoderu/sequential-code
```

## Примечания

- Убедитесь, что в `composer.json` указана корректная версия PHP (`^8.1`)
- Пакет уже имеет лицензию MIT
- README.md уже содержит документацию
- После каждого обновления кода создавайте новый тег и загружайте его
