
coronatime is a website which enables to monitor the latest covid statistics from different countries. The information it provides includes: new cases, recovered and deaths. You can sort the information in any order for better analysis.

#
### Table of Contents
* [Prerequisites](#prerequisites)
* [Tech Stack](#tech-stack)
* [Getting Started](#getting-started)
* [Migrations](#migration)
* [Development](#development)
* [Project Structure](#project-structure)
* [Create Database](#create-database)



#
### Prerequisites

* *PHP@8.1 and up*
* *MYSQL@8 and up*
* *npm@8.15 and up*
* *composer@2.4 and up*


#
### Tech Stack

* [Laravel@9.x](https://laravel.com/docs/6.x) - back-end framework
* [Vite](https://vitejs.dev/) - is a bundler which makes an ease for a developer to start working on JS files and compile them with such simplicity...
* [Spatie Translatable](https://github.com/spatie/laravel-translatable) - package for translation
* [TailwindCss](https://tailwindcss.com/) - css framework

#
### Getting Started
1\. First of all you need to clone coronatime repository from github:
```sh
git clone https://github.com/RedberryInternship/tornike-buchukuri-coronatime.git
```

2\. Go to the root of the folder:
```sh
cd tornike-buchukuri-coronatime/
```

3\. Next step requires you to run *composer install* in order to install all the dependencies.
```sh
composer install
```

4\. after you have installed all the PHP dependencies, it's time to install all the JS dependencies:
```sh
npm install
```

5\. Now we need to set our env file:
```sh
cp .env.example .env
```
And now you should provide **.env** file all the necessary environment variables(View Section [Create Database](#create-database)):

#
**MYSQL:**
>DB_CONNECTION=mysql

>DB_HOST=127.0.0.1

>DB_PORT=3306

>DB_DATABASE=coronatime

>DB_USERNAME=*****

>DB_PASSWORD=*****

Now execute in the root of you project following:
```sh
  php artisan key:generate
```
Which generates auth key.

after setting up **.env** file, execute:
```sh
php artisan config:cache
```
in order to cache environment variables.

##### Now, you should be good to go!


#
### Migration
if you've completed getting started section, then migrating database if fairly simple process, just execute:
```sh
php artisan migrate
```

#
### Development

You can run Laravel's built-in development server by executing:

```sh
  php artisan serve
```

when working on JS you may run:

```sh
  npm run dev
```
it builds your js files into executable scripts.

run command below in terminal to fill database daily:
```sh
php artisan schedule:work
```

#
### Project Structure

```bash
├─── app
│   ├─── Console
│   ├─── Exceptions
│   ├─── Http
│   ├─── Models
│   ├─── Providers
├─── bootstrap
├─── config
├─── database
├─── lang
├─── public
├─── resources
├─── routes
├─── storage
├─── tests
- .env
- artisan
- composer.json
- package.json
- phpunit.xml
```

Project structure is fairly straitforward(at least for laravel developers)...

For more information about project standards, take a look at these docs:
* [Laravel](https://laravel.com/docs/9.x)



[Database Design Diagram](https://drawsql.app/teams/oit/diagrams/coronatime)


### Create Database

1\. Firstly get into mysql prompt and provide password if neccessary:
```sh
sudo mysql
```

2\. After that create a new user, replace your_username and your_password with some other values:
```sh
CREATE USER 'your_username'@'localhost' IDENTIFIED BY 'your_password';
```

3\. Grant permissions to newly created user:
```sh
GRANT ALL PRIVILEGES ON *.* TO 'your_username'@'localhost' WITH GRANT OPTION;
```

4\. Create a database:
```sh
CREATE DATABASE coronatime;
```
