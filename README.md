## TODO

### Backend

- [x] Создать миграций и моделей (php artisan make:model SomeModel -m)
  - [x] Добавляющую таблицу отделов
  - [x] Добавляющую таблицу UserInfo
- [x] Создать контроллеры и сервисы (без реализации) для запланированных маршрутов
- [x] Имплементировать сервисы

### Frontend

- [x] Добавить tailwind и scss
- [x] Создать базовое представление и страницы: БД, файлы

### Fullstack

- [x] Отказаться от проверки yup
- [x] Синхронизация работы с файлами в БД
- [x] Загрузка файлов
- [ ] Предпросмотр и удаление файлов
- [ ] Простой импорт
- [ ] CUD для таблиц
- [ ] Экспорт таблиц
- [ ] Подробный импорт

### Final

- [ ] Вынести проверку yup в отдельный метод в utils/api, разобраться с ним
- [ ] Ограничить время хранения файлов
- [ ] Разобраться с авторизацией Laravel+Inertia
- [ ] Оформить проект, переписать readme

## Запланированные маршруты

```
-- users, departments --

post / # create(fields) -> new_item
get / # list(fields) -> items
put /:id # update(id, fields) -> items[id]
delete /:id # delete(id) -> status

-- files --

post / # upload(fields) -> new_item
get / # list(fields) -> items
get /:file_id # download(file_id) -> file
delete /:file_id # delete(file_id) -> status

post /import # import(params) -> status
post /export # export(params) -> data
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
