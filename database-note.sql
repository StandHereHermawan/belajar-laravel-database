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

CREATE TABLE counters
(
    id      VARCHAR(100)    NOT NULL PRIMARY KEY,
    counter int             NOT NULL default 0
) engine innodb;

INSERT INTO counters(id, counter) values ('sample', 0);

select * from counters;

CREATE TABLE products
(
    id          VARCHAR(100)    NOT NULL PRIMARY KEY,
    name        VARCHAR(100)    NOT NULL,
    description text,
    price       int             NOT NULL,
    category_id VARCHAR(100)    NOT NULL,
    created_at  timestamp,
    constraint  fk_category_id foreign key (category_id) references categories (id)
) engine innodb;

drop TABLE products;

drop TABLE counters;

drop TABLE categories;

show tables;

select * from migrations;