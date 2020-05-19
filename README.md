# SaveYourMoney
Accounting website to be hosted locally on your machine

# Preconditions

* Composer is installed (https://getcomposer.org/download/)
* Symfony is installed (https://symfony.com/download)

# Installation

* Start development server with `php bin/console server:run`

# Database migrations

* First you need to create the diff `php bin/console make:migration`
* Now we are able to publish the changes to the database `php bin/console doctrine:migrations:migrate`