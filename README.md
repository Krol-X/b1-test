## TODO

### Backend

- [x] Создать миграций и моделей (php artisan make:model SomeModel -m)
  - [x] Добавляющую таблицу отделов
  - [x] Добавляющую таблицу UserInfo
- [ ] Создать контроллеры и сервисы (без реализации) для запланированных маршрутов
- [ ] Имплементировать сервисы

### Frontend

- [ ] Добавить tailwind и scss
- [ ] Создать базовое представление и страницы: БД, файлы

### Files

- [ ] Реализовать экспорт (он проще)
- [ ] Реализовать импорт с распознованием типа csv

### Last

- [ ] Разобраться с авторизацией Laravel+Inertia
- [ ] Оформить проект, переписать readme

## Запланированные маршруты

```
users, departments

post / # create(fields) -> id
get / # list(fields) -> posts.fields
get /:id # read(id, fields) -> post[id].fields
put /:id # update(id, fields) -> post[id].fields
delete /:id # delete(id) -> status

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
