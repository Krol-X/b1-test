## TODO

### Common

- [*] Доделать совместимость по api между клиентом и сервером
- [ ] Разобраться с авторизацией Laravel+Inertia
- [ ] Оформить проект, переписать readme

### Backend

- [x] Создать миграций и моделей (php artisan make:model SomeModel -m)
  - [x] Добавляющую таблицу отделов
  - [x] Добавляющую таблицу UserInfo
- [x] Создать контроллеры и сервисы (без реализации) для запланированных маршрутов
- [x] Имплементировать сервисы

### Frontend

- [x] Добавить tailwind и scss
- [*] Создать базовое представление и страницы: БД, файлы

### Files

- [ ] Сохранение в БД записей о файлах

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

## Наброски внешнего вида

```
Layout

_______________________________________
| Справочники  | Файлы       |
---------------------------------------
| Пользователи |
| Отделы       | ...
|              |
|              |
|              |
|--------------|
| Users (site) |
---------------------------------------



Import

---------------------------------------
| File 1                        [del]
| File 2                        [del]
| File 3                        [del]
|

Внимание! Предполагается что все файлы имеют связь между собой.
Неизвестные ссылки сохраняться не будут!



Export

--------------------------------------
| Users.csv                     [save]
| Departments.csv               [save]
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
