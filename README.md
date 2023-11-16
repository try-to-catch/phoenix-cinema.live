<p align="center"><a href="https://phoenix-cinema.live" target="_blank"><img src="https://raw.githubusercontent.com/try-to-catch/phoenix-cinema.live/4c377a789aa12e284a447dd715d8f995bda3066b/public/images/icons/logo.svg" width="400" alt="Phoenix Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel icon"/>
<img src="https://img.shields.io/badge/vue-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white" alt="Vue.js icon"/>
<img src="https://img.shields.io/badge/inertia-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia icon"/>
<img src="https://img.shields.io/badge/vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite icon"/>
<img src="https://img.shields.io/badge/typescript-3178C6?style=for-the-badge&logo=TypeScript&logoColor=white" alt="TypeScript icon"/>
<img src="https://img.shields.io/badge/mysql-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySql icon"/>
<img src="https://img.shields.io/badge/redis-white?style=for-the-badge&logo=redis&logoColor=DC382D" alt="Redis icon"/>
</p>

## About Phoenix
___
Phoenix is a web service for booking cinema tickets from anywhere in the world where you have internet access. The application has numerous features, some of which are described below:

- viewing information about films and their shows
- selection of shows
- selection of seats
- authorization
- roles
- order form
- downloading tickets in pdf format
- user profile with the history of orders
- console command to create a user and give him roles
- admin panel with the ability to create, update and view films halls, screenings.

## Used technologies
___
Laravel, Vue.js(Composition API), Inertia.js, TypeScript, Redis, MySQL, Docker, NPM, Vite, Tailwind CSS, Sanctum, Intervention Image, PHPUnit, Simple QrCode, laravel-dompdf, Laravel Breeze, Artisan Console Commands, Prettier, ESLint, Git, Github.

## Installation guide
___
There is two ways to install this project:
1. Using Docker(recommended)
2. Using local environment

### Using Docker
To run in prod mode, use the `docker-compose -f docker-compose.prod.yml up -d` command in step 4

1. Clone this repository
2. Run `cp .env.example .env` in the root directory of the project to create .env file
3. Specify the database password in the .env file (Also you can change other parameters if you need)
4. Run `docker-compose up -d` in the root directory of the project
5. Run `docker-compose exec app npm install` to install npm dependencies
6. Run `docker-compose exec app composer install` to install composer dependencies
7. Run `docker-compose exec app php artisan key:generate` to generate application key
8. Run `docker-compose exec app chmod -R 777 storage bootstrap/cache` to give permissions to storage and bootstrap/cache directories
9. Run `docker-compose exec app php artisan migrate` to migrate database
10. Run `docker-compose exec app php artisan db:seed` to seed database (If you need mock data)
11. Run `docker-compose exec app php artisan storage:link` to create symbolic link to storage

### Using local environment
If you choose this way, you need to install all dependencies on your local machine. You have to install imagick to render tickets. Also, you need to install redis and mysql (You can switch CACHE_DRIVER to file, and use sqlite to skip this step). After that you can follow the steps below:

1. Clone this repository
2. Run `cp .env.example .env` in the root directory of the project to create .env file
3. Specify the database password in the .env file (Also you can change other parameters if you need)
4. Run `npm install` to install npm dependencies
5. Run `composer install` to install composer dependencies
6. Run `php artisan key:generate` to generate application key
7. Run `chmod -R 777 storage bootstrap/cache` to give permissions to storage and bootstrap/cache directories (If you use linux)
8. Run `php artisan migrate` to migrate database
9. Run `php artisan db:seed` to seed database (If you need mock data)
10. Run `php artisan storage:link` to create symbolic link to storage

#### Optional steps:
1. Run `php artisan serve` to start local server
2. Run `npm run dev` to start development server

## Conclusion
___
The project is currently hosted on DigitalOcean. You can visit it by clicking on the link below:
<a href="https://phoenix-cinema.live" target="_blank">phoenix-cinema.live</a>
