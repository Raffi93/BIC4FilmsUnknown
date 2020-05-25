# BIC4 Project: The films about the unknown

## The films about the unknown

This software lists films and actors belongs to them.
It is possible to search for films by various parameters.

## Exercise

### Already providing

All routes that are needed are implemented:
 * **GET** ```/actor``` &rarr; Lists all actors
 * **GET** ```/list/actor``` &rarr; Returns JSON of all actors
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/actor``` &rarr; Stores new actors
 * **GET** ```/actor/{slug}``` &rarr; Show actor
 * **PUT** ```/actor/{slug}``` &rarr; Update actor
 * **GET** ```/actor/{slug}/edit``` &rarr; Edit actor
 * **GET** ```/search/actor``` &rarr; Search actors
 * **POST** ```/search/actor``` &rarr; Query actors
 * **GET** ```/film``` &rarr; Lists all films
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/film``` &rarr; Stores new film
 * **GET** ```/film/{slug}``` &rarr; Show film
 * **PUT** ```/film/{slug}``` &rarr; Update film
 * **GET** ```/film/{slug}/edit``` &rarr; Edit film

All views can be found in ```/resources/views```.

### TODO

#### VueJS

Implement your [VueJS](https://vue.js) components in the folder ```/resources/views/js/components```.
Register your components in ```/resources/views/js/app.js``` and use them in the following files:

 * ```/resources/views/film```
     * ```/resources/views/film/create.blade.php```
     * ```/resources/views/film/edit.blade.php```
     * ```/resources/views/film/index.blade.php```
     * ```/resources/views/film/show.blade.php```
 * ```/resources/views/actor```
      * ```/resources/views/actor/create.blade.php```
      * ```/resources/views/actor/edit.blade.php```
      * ```/resources/views/actor/index.blade.php```
      * ```/resources/views/actor/search.blade.php```
      * ```/resources/views/actor/show.blade.php```

To query data for dropdowns in forms or to reload lists use the list routes:
 * **GET** ```/list/film```
 * **GET** ```/list/actor```

For the search form use ```q``` as the name for the text input.
The search will be handled by the backend.

#### CSS (SCSS)

The design of the software need to be adapted.
[Bulma](https://bulma.io) is used to layout and style the website.
If wanted default styles can be overwritten by setting variables in the ```/resources/sass/_variables.scss``` file.
Also it is possible to write custom styles in ```/resources/sass/_custom.scss```.

A new logo need to be set. If pictures will be present on the website place them in ```/public/img``` folder.
Here you will also find the logo.

### Hints

#### JavaScript and CSS (SCSS)

To compile scss and JavaScript ```npm run dev``` need to be executed in the project folder.
It is also possible to run ```npm run watch``` so it is not need to execute ```npm run dev``` every time a change happend.

#### Data for Database

To make starting developing fast there are some seeders implemented to fill all needed tables except the user table.
To populate the database run the command ```php artisan db:seed``` in the filminal in project root folder.

### Install

* Clone project via git-bash or git-GUI
* Copy the database-file in the folder ```database```
* Start cmd and navigate to the project folder and run ```composer install``` and ```npm install```
* Open project with PHPStorm
* Rename ```.env.example``` to ```.env``` and run ```php artisan key:generate``` in the terminal in PHPStorm 
* Now an entry should be in the ```APP_KEY``` in the file ```.env```
* Execute ```npm run dev``` also in the terminal in PHPStorm
* Execute ```php artisan migrate``` in the terminal in PHPStorm this creates the tables
* Execute ```php artisan db:seed``` to fill the tables with values
* Run ```php artisan serve``` in the PHPStorm terminal
* Now follow http://127.0.0.1:8000 
