# Laravel test project

## 1. Развертываение проекта.

1. Для начала нужно прописать команду: `composer install`.
2. После чего нужно будет ввести следующую команду: `php artisan sail:install` и выбрать в параметрах `redis, mysql`.
3. Затем, создать `.env` файл, пример данных которые использовались в `.env.example`.
4. После выше перечисленного прописываем команду: `./vendor/bin/sail up -d`, она создаст и поднимет наши контейнеры.
5. После того как контейнеры поднялись, мы вводим следующую команду: `./vendor/bin/sail artisan mirgate:fresh --seed`, а затем 
`./vendor/bin/sail npm install` и после неё `./vendor/bin/sail npm run dev`.
6. Заходим на сайт `http://localhost`.
