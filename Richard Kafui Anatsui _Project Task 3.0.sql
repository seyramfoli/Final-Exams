create database finalexam_84422022;
use finalexam_84422022;

create table customers(
customerID int not null primary key auto_increment,
fname varchar(255) not null,
lname varchar(255) not null, 
email varchar(50) not null,
password varchar(255) not null
);

create table products(
productID int not null primary key auto_increment,
pName varchar(255) not null,
price float(5,2) not null,
rating int not null,
image varchar(255) not null
);

create table orders(
orderID int not null primary key auto_increment,
orderTime datetime not null,
customerID int not null,
foreign key (customerID) references customers(customerID)
);

create table payments(
paymentID int not null primary key auto_increment,
accountDetails varchar(255) not null,
customerID int not null,
orderID int not null,
foreign key (customerID) references customers(customerID),
foreign key (orderID) references orders(orderID)
);

create table products_customer(
prod_custID int not null primary key auto_increment,
productID int not null,
customerID int not null,
quantity int not null,
foreign key (productID) references products(productID),
foreign key (customerID) references customers(customerID)
);

create table products_payments(
prod_payID int not null primary key auto_increment,
productID int not null,
paymentID int not null,
quantity int not null,
foreign key (productID) references products(productID),
foreign key (paymentID) references payments(paymentID)
);

use finalexam_84422022;
insert into products(pName, price, rating, image) values("Louis Moinet Blue Strap", 34.99,3, "watch1.jpg"),
("Omega De Ville Co-Axial Chronometer", 24.99,4, "watch2.jpg"), (" Louis Moinet Blue Strap", 54.99,2, "watch3.jpg"),
("S-Force Strength Overcomes", 27.99,3, "watch4.jpg"), ("Michael Kors Brown Leather Strap Watch", 29.99,3, "watch5.jpg"),
("Rolex Oyster Perpetual Cosmograph Daytona", 99.99,3, "watch6.jpg"), ("Casio Vinatge Watch Silver", 20.99,2, "watch7.jpg");