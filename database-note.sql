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