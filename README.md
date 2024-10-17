## Команды чтобы развернуть проект
```bash
docker-compose up -d --build
php yii migrate/up --migrationPath=@vendor/pheme/yii2-settings/migrations # в php контейнере
```
Проект будет доступен по адресу: http://localhost:8000

## Проверка
1. В разделе Settings добавить настройки максимального/минимального развмера изображений.
2. Загрузить изображения (можно сразу 10)

Если выравнивание плиток галереи не нужно, можно отключить css класс aligned-item
