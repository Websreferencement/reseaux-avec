Reseaux AVEC
============

Web site for Reseaux AVEC. Brioude.

## Installation

```
git clone https://github.com/Websreferencement/reseaux-avec.git
cd reseaux-avec
```

Install composer and download the vendors :

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

Configure the web site by copy the `app/config/parameters.yml.dist` to `app/config/parameters.yml` and edit it.

Create your database datas and tables.

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

Install all the assets

```
php app/console assets:install --symlink
```

Last steps ! Configure the security by copy the `app/config/security.yml.dist` to `app/config/security.yml` and edit
it.

Enjoy !