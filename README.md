Reseaux AVEC
============

Web site for Reseaux AVEC. Brioude.

Installation
============

```
git clone https://github.com/Websreferencement/reseaux-avec.git
cd reseaux-avec
```

Install composer and download the vendors :

```
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

Configure the web site by edit `app/config/parameters.yml.dist`

Create your database datas and tables.

```
php app/console doctrine:database:create
php app/console doctrine:schema:update --force
```

Enjoy !