create database rka2022;
use rka2022;

create table customer(
    CID int(11) not null primary key auto_increment,
    fname varchar(255) not null,
    lname varchar(255) not null,
    email varchar(50) not null,
    password varchar(255) not null
);