# Blue Bird Big Band

This is the repository housing the website for the Blue Bird Big Band from the music school in Speyer, Germany.

This project uses the [Laravel framework](https://laravel.com/), currently in version 10,
including [Inertia](https://inertiajs.com/) with [Vue](https://vuejs.org/) as the JavaScript Framework.

## Installation Guide

### Prerequisites

- [PHP](https://www.php.net/manual/en/install.php) with min. version 8.1 installed
- Latest version [Composer](https://getcomposer.org/download/) installed
- [Node.js](https://nodejs.org/en) installed. Minimum Version 16.
- With Node.js usually npm will be installed. npm is also required.

### Installation Steps

After taking care of the prerequisites, you can proceed to run the following command line scripts.

- Install all the Composer dependencies with `composer install`.
- Now all Node.js packages/dependencies need to be installed with `npm install`.
- After that the database can be prepared to be used. Run `php artisan migrate` to create all database tables
- Optionally with `php artisan db:seed` the database can be filled with some dummy data

You can run the project with two terminal windows which run the following commands concurrently:

1) `php artisan serve`
2) `npm run dev`
