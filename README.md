Окружение: PHP 7.2 и выше, Lavarel
Задание: 
Создать API на базе чистого проекта Lavarel. API будет представлять из себя 3 запроса:

GET: /api/books/list - Получение списка книг

GET: /api/book/{bookId} - Получение данных книги по ID

POST: /api/book/add - Добавление книги

Дополнительные требования:
1. Создать миграции для таблиц books и categories:
    books: id, name, category_id, created_at, updated_at, deleted_at
    categories: id, name, created_at, updated_at, deleted_at
2. Таблица books должна содержать колонку category_id и иметь внешний ключь на таблицу categories
3. Обе таблицы должны иметь модели с использованием мягкого удаление softDeletes
4. В моделях должны быть описаны связи(relationships)
5. Создать Seed для наполнения таблицы categories любыми данными
6. Для POST запроса дожен бысть создан класс запроса AddBookRequest с описанием правил валидации входящих данных
    * одним из полем запроса должно быть поле categoryId
7. Создать тесты для каждого из API запросов. В тестах должны быть описаны ситуации полчения корректного статуса и Json обьека, получения некорректного Json обьекта с соответствующим статусом
8. Аутендификация пользователя и создание api_token не требуется, но если будет реализована тогда это будет плюсом
# laravelrestapitest
