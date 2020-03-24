create database scs;
use scs;

create table users (
    id int auto_increment primary key,
    e_mail text,
    password text,
    username text
);

create table feeds (
    id int auto_increment primary key,
    name text,
    user_id int not null,
    image_file_name text,
    video_file_name text,
    message text,
    update_at datetime,
    create_at datetime,
    foreign key  feeds_users (user_id) references users(id)
)