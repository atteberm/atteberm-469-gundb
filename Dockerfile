FROM php:8.1-apache

WORKDIR /var/www/html

COPY index.php index.php
COPY edit-page.php edit-page.php
COPY style.css style.css
COPY script.js script.js
COPY submit.php submit.php

COPY pistol.csv pistol.csv
COPY sniper.csv sniper.csv
COPY shotgun.csv shotgun.csv
COPY rifle.csv rifle.csv
COPY smg.csv smg.csv

RUN chmod -R 777 /var/www/html/

EXPOSE 80