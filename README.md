# Intelivita - Quiz Management Task

This task having features like to manage quizes from the admin side and use by user.

## Features

-   Created a Table only using Migration & Used seeder for admin data and one Test User data
-   Admin & User should be logged in at the same time in different tabs on the same browser. when User logged out then admin should not logged out and when Admin logged out then user
    should not be logged out.
-   Authentication using Laravel Auth Bootstrap-based.
-   Ability to create a new user using Laravel Auth.
-   Quiz Management
-   Questions Management with Time Limitation for each Questions.
-   Answers Management.
-   View Result for Quiz.
-   Restriction on Page Refresh.

## Installation

Clone Github Repo : [https://github.com/devrudz/intelivita]

```bash
  git clone https://github.com/devrudz/intelivita.git
  cd intelivita

  npm Install
  npm run dev

  composer Install
  php artisan migrate --seed
  php artisan serve

  got to : http://localhost:8000/
```

## To Login with Admin

Follow below instructions :

```bash
  url :  http://localhost:8000/admin/login
  user : admin@example.com
  pswd : Admin@123
```

This credintials detail are stored in seeder as well for your reference.

## To Login with User

Follow below instructions :

```bash
  url :  http://localhost:8000/login
  user : user@example.com
  pswd : User@123
```

This credintials detail are stored in seeder as well for your reference.

## Installation

Clone Github Repo : https://github.com/devrudz/intelivita.git

```bash
  git clone https://github.com/devrudz/intelivita.git
  cd intelivita

  npm Install
  npm run dev

  composer Install
  php artisan migrate --seed
  php artisan serve

  got to : http://localhost:8000/
```
