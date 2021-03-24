Добавление возможности отложенной публикации в ЖЛ

Необходимо реализовать возможность отложенной публикации сообщений из Живой Ленты. Для выполнения задачи нужно добавить свое поле в форму публикации поста в ЖЛ типа дата/время. Если данное поле заполнено, запись публикуется в статусе “Черновик”. При наступлении указанного времени пост публикуется в ЖЛ.
При решении задачи запрещено использование кастомизированных компонентов, своих таблиц. Поддержка обновлении Битрикс24 должна полностью сохраниться.


Требуется доработка.
1) Нет папки с именем модуля
2) Используются пути с local, модуль не работает из папки /bitrix/modules/
3) Не используются лэнги
4) Могут возникать проблемы с кэшированием, из-за того, что скрипт исполняется напрямую из js
https://dev.1c-bitrix.ru/community/blogs/dev_bx/embedded-in-the-interface-box-bitrix24.php
См. текст со строки Важно! Весь JS-код, добавленный с помощью классов CJSCore....
5) Нет классов в js
6) Используется аттрибут style, вместо файла стилей
7) Js не устанавливается в /bitrix/js/module_name/
в следствие чего при правах из коробки видим: https://адрес_портала/bitrix/modules/nizamov.blogpostformext/js_libs/blogpostform.js?16154648242301 net::ERR_ABORTED 403
8) Для показа календаря не используется стандартный js-компонент BX.calendar
9) Агент отработал - пост не опубликовался.
Я знаю почему, предлагаю тебе - ответить.
10) D7 используется частично, например, события не через него регаются RegisterModuleDependences
11) Определение url в js - считаю недочетом, тк в php богаче возможности плюс см. пункт 4
12) Обновление прав - излишне (SOCNET_RIGHTS)
