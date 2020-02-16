# SaveYourMoney
Accounting website to be hosted locally on your machine

# Preconditions

* Install Liquibase on your machine to setup the MySQL database (https://www.liquibase.org/documentation/installation-windows.html)
* Composer is installed (https://getcomposer.org/download/)
* Symfony is installed (https://symfony.com/download)

# Installation

* Execute bat script `/db/runLiquibase.bat` to install database tables and stuff
* Start development server with `php bin/console server:run`