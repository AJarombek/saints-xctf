-- Author: Andrew Jarombek
-- Date: 5/25/2016 - 1/18/2017
-- Reset Database File, contains all of the tables, dependencies, and some initial values.
-- Version 0.4 (BETA) - 12/24/2016
-- Version 0.5 (FEEDBACK UPDATE) - 1/18/2017

use saintsxctf;

drop table if exists weekstart;
drop table if exists codes;
drop table if exists forgotpassword;
drop table if exists events;
drop table if exists messages;
drop table if exists groupmembers;
drop table if exists comments;
drop table if exists logs;
drop table if exists metrics;
drop table if exists types;
drop table if exists admins;
drop table if exists groups;
drop table if exists users;

-- USERS TABLE - Contains all the login and profile information of the users
create table users(
    username VARCHAR(20) PRIMARY KEY,
    first VARCHAR(30) NOT NULL,
    last VARCHAR(30) NOT NULL,
    salt VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    profilepic LONGBLOB,
    profilepic_name VARCHAR(50),
    description VARCHAR(255),
    member_since DATE NOT NULL,
    class_year INT(4),
    location VARCHAR(50),
    favorite_event VARCHAR(20),
    activation_code VARCHAR(8) NOT NULL,
    email VARCHAR(50),
    subscribed TINYINT(1),
    last_signin DATETIME NOT NULL,
    week_start VARCHAR(15)
);

-- FLAIR TABLE - Contains a list of all the flairs and their respective users
create table flair(
    flair_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20),
    flair VARCHAR(25)
);

-- WEEKSTART TABLE - Contains the weekdays available for week starts
create table weekstart(
    week_start VARCHAR(15) PRIMARY KEY
);

-- CODES TABLE - Contains a list of all the beta activation codes
create table codes(
    activation_code VARCHAR(8) PRIMARY KEY
);

-- FORGOT PASSWORD TABLE - Contains a list of all the forgot password codes
create table forgotpassword(
    forgot_code VARCHAR(8) PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    expires DATETIME NOT NULL
);

-- GROUPS TABLE - Contains a list of all the groups along with their full name
create table groups(
    group_name VARCHAR(20) PRIMARY KEY,
    group_title VARCHAR(50),
    grouppic LONGBLOB,
    grouppic_name VARCHAR(50),
    description VARCHAR(255)
);

-- GROUP_MEMBERS TABLE - Contains a list of the members of the groups
create table groupmembers(
    group_name VARCHAR(20),
    username VARCHAR(20),
    status VARCHAR(10),
    PRIMARY KEY (group_name,username)
);

-- STATUS TABLE - Contains the status' available for logs
create table status(
    status VARCHAR(10) PRIMARY KEY
);

-- LOGS TABLE - Contains a list of all the running logs
create table logs(
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    first VARCHAR(30) NOT NULL,
    last VARCHAR(30) NOT NULL,
    name VARCHAR(40),
    location VARCHAR(50),
    date DATE NOT NULL,
    type VARCHAR(40) NOT NULL,
    distance FLOAT,
    metric VARCHAR(15),
    miles FLOAT,
    time TIME,
    pace TIME,
    feel INT(2) NOT NULL,
    description VARCHAR(255),
    time_created DATETIME NOT NULL
);

-- METRICS TABLE - Contains the metrics available for logs
create table metrics(
    metric VARCHAR(15) PRIMARY KEY
);

-- TYPES TABLE - Contains the types of workouts available for logs
create table types(
    type VARCHAR(15) PRIMARY KEY
);

-- EVENTS TABLE - Contains information for group events
create table events(
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(40) NOT NULL,
    group_name VARCHAR(20) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    start_time TIME,
    description VARCHAR(1000)
);

-- MESSAGES TABLE - Contains a list of all the messages left on a message board
-- Message boards will be available for each group
create table messages(
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    first VARCHAR(30) NOT NULL,
    last VARCHAR(30) NOT NULL,
    group_name VARCHAR(20) NOT NULL,
    time DATETIME NOT NULL,
    content VARCHAR(1000)
);

-- COMMENTS TABLE - Contains a list of all the comments on logs
create table comments(
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    first VARCHAR(30) NOT NULL,
    last VARCHAR(30) NOT NULL,
    log_id INT NOT NULL,
    time DATETIME NOT NULL,
    content VARCHAR(1000)
);

-- ADMINS TABLE - Contains a list of all the admins and the group that
-- they have admin privileges for
create table admins(
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(20) NOT NULL,
    group_name VARCHAR(20)
);

-- Add all the realtionships between tables
alter table groupmembers add FOREIGN KEY(group_name) references groups(group_name);
alter table groupmembers add FOREIGN KEY(status) references status(status);

alter table users add FOREIGN KEY(week_start) references weekstart(week_start);

alter table flair add FOREIGN KEY(username) references users(username);

alter table logs add FOREIGN KEY(metric) references metrics(metric);
alter table logs add FOREIGN KEY(type) references types(type);
alter table logs add FOREIGN KEY(username) references users(username);

alter table forgotpassword add FOREIGN KEY(username) references users(username);

alter table events add FOREIGN KEY(group_name) references groups(group_name);

alter table messages add FOREIGN KEY(group_name) references groups(group_name);
alter table messages add FOREIGN KEY(username) references users(username);

alter table comments add FOREIGN KEY(log_id) references logs(log_id);
alter table comments add FOREIGN KEY(username) references users(username);

alter table admins add FOREIGN KEY(username) references users(username);
alter table admins add FOREIGN KEY(group_name) references groups(group_name);

-- Add table indexes
alter table users add INDEX(first(10));
alter table users add INDEX(last(10));
alter table users add INDEX(class_year(4));
alter table users add INDEX(email(30));

alter table forgotpassword add INDEX(username(10));

alter table groups add INDEX(group_title(10));

alter table groupmembers add INDEX(group_name(10));
alter table groupmembers add INDEX(username(10));

alter table logs add INDEX(username(10));
alter table logs add INDEX(date);
alter table logs add INDEX(type(5));
alter table logs add INDEX(miles);
alter table logs add INDEX(time);
alter table logs add INDEX(feel);

-- Insert the pre set groups into the groups table
insert into groups(group_name,group_title) values ("mensxc","Men's Cross Country");
insert into groups(group_name,group_title) values ("wmensxc","Women's Cross Country");
insert into groups(group_name,group_title) values ("menstf","Men's Track & Field");
insert into groups(group_name,group_title) values ("wmenstf","Women's Track & Field");
insert into groups(group_name,group_title) values ("alumni","Alumni");

-- Insert the available metrics for this application
insert into metrics(metric) values ("miles");
insert into metrics(metric) values ("kilometers");
insert into metrics(metric) values ("meters");

-- Insert the available types of workouts for this application
insert into types(type) values ("run");
insert into types(type) values ("bike");
insert into types(type) values ("swim");
insert into types(type) values ("other");

-- Insert the available week starts for this application
insert into weekstart(week_start) values ("monday");
insert into weekstart(week_start) values ("sunday");

-- Insert the available status' for this application
insert into status(status) values ("accepted");
insert into status(status) values ("pending");