use devsbook;


drop table user_relations;
drop table post_comments;
drop table likes;
drop table posts;
drop table users;

CREATE TABLE users(
    id int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(100) not null,
    email VARCHAR(100) not null,
    pass VARCHAR(255) not null,
    birthdate date not null,
    city VARCHAR(100),
    work VARCHAR(100),
    avatar varchar(150),
    cover varchar(150),
    token varchar(255)
);

create table user_relations(
    id int PRIMARY KEY AUTO_INCREMENT,
    user_from int,
    user_to int 
);

create table posts(
    id int primary key AUTO_INCREMENT,
    id_author int,
    typ varchar(20),
    created_at DATETIME default CURRENT_TIMESTAMP,
    body TEXT
);

create table post_comments(
    id int PRIMARY KEY auto_increment,
    id_user int,
    id_post int,
    created_at datetime default CURRENT_TIMESTAMP,
    body text,
    FOREIGN KEY(id_user) REFERENCES users(id),
    FOREIGN KEY(id_post) REFERENCES posts(id)
);
CREATE TABLE likes(
    id int PRIMARY key auto_increment,
    id_user int,
    id_post int,
    created_at DATETIME default CURRENT_TIMESTAMP,
    FOREIGN KEY(id_user) REFERENCES users(id),
    FOREIGN KEY(id_post) REFERENCES posts(id)
);

-- Chaves estrangeiras da tabela de relações
ALTER TABLE `user_relations` ADD CONSTRAINT `fk_user_from` FOREIGN KEY ( `user_from` ) REFERENCES `users` ( `id` ) ;
ALTER TABLE `user_relations` ADD CONSTRAINT `fk_user_to` FOREIGN KEY ( `user_to` ) REFERENCES `users` ( `id` ) ;

-- Chave estrangeira da tabela post
ALTER TABLE `posts` ADD CONSTRAINT `fk_id_author` FOREIGN KEY ( `id_author` ) REFERENCES `users` ( `id` ) ;




