# verysimpleadmin
**Just like micro-phpmyadmin**

> Structure: 
```
admin/
├── index.php     # Главная страница админки (список таблиц)
├── config.php    # Конфигурация подключения к БД
├── db.php      # Функции для работы с БД (CRUD операции)
├── table.php      #  Вывод таблицы с данными
├── form.php      #  Форма 
├── assets/     # Директория для ресурсов (CSS, JS, images)
│  ├── css/
│  │  └── style.css # Пользовательские стили
│  └── js/
│    └── script.js # Пользовательские скрипты
│    └── pagination.js # Навигация
│    └── search.js # Поиск
│    └── form_validation.js # Валидация
├── templates/   # Шаблоны для отображения
│  ├── header.php  # Шапка сайта
│  ├── footer.php  # Подвал сайта
│  ├── table_list.php # Шаблон для отображения списка таблиц
│  ├── table_data.php # Шаблон для отображения данных таблицы
│  └── form.php    # Шаблон для формы добавления/редактирования
└── actions/    # Обработчики действий (CRUD)
  ├── create.php  # Обработчик создания записи
  ├── update.php  # Обработчик обновления записи
  └── delete.php  # Обработчик удаления записи
# Авторизация
├── auth.php    # Логика проверки авторизации 
├── login.php    # Логика входа 
├── logout.php    # Логика выхода
├── auth.php    # Логика проверки авторизации 
```
---
## Please, don't use it for production! 
