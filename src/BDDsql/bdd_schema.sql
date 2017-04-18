create table user_app(
id integer PRIMARY KEY AUTO_INCREMENT,
email varchar(100) not null unique,
fullname varchar(100) not null, 
password varchar(200) not null
);


create  table publications(
    id varchar(100) default '--',
    date_create DATETIME default CURRENT_TIMESTAMP,
    user_app_id integer default null,
    published integer default 1,
    statu varchar(200) default null, 
    date_to_pub datetime default null,
    --media char, -- c une url de media twitter 
        FOREIGN KEY (user_app_id)
            REFERENCES user_app(id)
            ON DELETE SET NULL
);
