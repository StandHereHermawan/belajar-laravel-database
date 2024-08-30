CREATE DATABASE belajar_laravel_database;

use belajar_laravel_database;

CREATE TABLE categories
(
    id              VARCHAR(100) NOT NULL PRIMARY KEY,
    name            VARCHAR(100) NOT NULL,
    description     text,
    created_at timestamp
) engine innodb;

desc categories;