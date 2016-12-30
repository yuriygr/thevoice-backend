THEVOICE Backend
==========
Backend на Phalcon PHP для **THEVOICE**

Для работы **необходимо скачать и установить Phalcon** на сервер. Инструкции можно прочитать [тут](http://phalconphp.com/en/download).

### Требования

Для запуска приложения необходимы:

* PHP >= 7.0
* Nginx c php-fpm
* Phalcon Framework >= 3.0

### Конфигурация

Все настройки базы данных и редиса находятся в файле окружения `.env`.

### Установка

Не знаю зачем вам это, но вдруг:

`composer create-project yuriygr/thevoice-backend . --stability=dev --profile --verbose`