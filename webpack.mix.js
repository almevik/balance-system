const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .vue() // Поддержка Vue 3
    .sass('resources/scss/app.scss', 'public/css') // Компиляция SCSS
    .setPublicPath('public'); // Установка пути к публичным файлам
