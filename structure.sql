CREATE DATABASE hmw1;

use hmw1;


CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    password varchar(255) not null,
    email varchar(255) not null unique,
    name varchar(255) not null,
    surname varchar(255) not null,
    propic varchar(255),
    since timestamp not null default current_timestamp,
    nfollowers integer default 0,
    nfollowing integer default 0,
    nposts integer default 0
) Engine = InnoDB;

CREATE TABLE posts (
    id integer primary key auto_increment,
    user integer not null,
    time timestamp not null default current_timestamp,
    nlikes integer default 0,
    ncomments integer default 0,
    content json,
    foreign key(user) references users(id) on delete cascade on update cascade
) Engine = InnoDB;

CREATE TABLE likes (
    user integer not null,
    post integer not null,
    index xuser(user),
    index xpost(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade,
    primary key(user, post)
) Engine = InnoDB;

CREATE TABLE comments (
    id integer primary key auto_increment,
    user integer not null,
    post integer not null,
    time timestamp not null default current_timestamp,
    text varchar(255),
    index xuser(user),
    index xpost(post),
    foreign key(user) references users(id) on delete cascade on update cascade,
    foreign key(post) references posts(id) on delete cascade on update cascade
) Engine = InnoDB;


CREATE TABLE `follow` (
    utente varchar(24) NOT NULL,
    follower varchar(24) NOT NULL,
    index xuser(utente),
    index xfollow(follower),
    foreign key(utente) references users(username) on delete cascade on update cascade,
    foreign key(follower) references users(username) on delete cascade on update cascade,
    primary key(utente, follower)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;




DELIMITER //
CREATE TRIGGER likes_trigger
AFTER INSERT ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes + 1
WHERE id = new.post;
END //
DELIMITER ;


DELIMITER //
CREATE TRIGGER unlikes_trigger
AFTER DELETE ON likes
FOR EACH ROW
BEGIN
UPDATE posts 
SET nlikes = nlikes - 1
WHERE id = old.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER comments_trigger
AFTER INSERT ON comments
FOR EACH ROW
BEGIN
UPDATE posts 
SET ncomments = ncomments + 1
WHERE id = new.post;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER posts_trigger
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
UPDATE users 
SET nposts = nposts + 1
WHERE id = new.user;
END //
DELIMITER ;





DELIMITER //
CREATE TRIGGER follow_trigger
AFTER INSERT ON follow
FOR EACH ROW
BEGIN
UPDATE users 
SET nfollowers = nfollowers + 1
WHERE username = new.utente;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER follow2_trigger
AFTER delete ON follow
FOR EACH ROW
BEGIN
UPDATE users 
SET nfollowers = nfollowers -1
WHERE username = old.utente;
END //
DELIMITER ;




DELIMITER //
CREATE TRIGGER following_trigger
AFTER INSERT ON follow
FOR EACH ROW
BEGIN
UPDATE users 
SET nfollowing = nfollowing + 1
WHERE username = new.follower;
END //
DELIMITER ;

DELIMITER //
CREATE TRIGGER nofollowing_trigger
AFTER delete ON follow
FOR EACH ROW
BEGIN
UPDATE users 
SET nfollowing = nfollowing -1
WHERE username = old.follower;
END //
DELIMITER ;




INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `surname`, `propic`) VALUES
('1', 'bill28',('$2y$10$kVALrW36iFy7C41fcKGsZOJlw4m8IES4EG/NnnuHnQJC3/c.8geqO'), 'bill@gmail.com', 'Bill', 'Rossi', 'images/Bill.jpg');



INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('1', '1', '2022-05-28 18:13:24', '0', '0','{"type": "sports", "text": "my favourite sports", "id": "87", "url": "https://sports-api-production.s3.amazonaws.com/uploads/sport/images/87/americanfootball.jpg"}');

INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('2', '1', '2022-05-28 19:13:24', '0', '0','{"type": "spotify", "text": "Love", "id": "2p5OyhSm5fS90n0Q7R3r6D"}');



INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `surname`, `propic`) VALUES
('2', 'jeff64',('$2y$10$pR8Zrd7YWCCQxoSTIX479ukh3rflP6S.DHDVygax85QMktCEu6fWC'), 'jeff64@gmail.com', 'Jeff', 'Bez', 'images/jeff.jpg');

INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('4', '2', '2022-05-28 19:08:24', '0', '0','{"type": "giphy", "text": "as", "id": "1hMjFZY16VxGWrfDfq", "url": "https://media3.giphy.com/media/1hMjFZY16VxGWrfDfq/giphy.gif?cid=ea99b86750ee05fea955158b35dbe52b048459430b05e14c&rid=giphy.gif&ct=g"}');

INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('3', '2', '2022-05-28 19:10:24', '0', '0','{"type": "sports", "text": "I like swimming", "id": "224", "url": "https://sports-api-production.s3.amazonaws.com/uploads/sport/images/224/swimming.jpg"}');



INSERT INTO `users` (`id`, `username`, `password`, `email`, `name`, `surname`, `propic`) VALUES
('3', 'michelle17',('$2y$10$.pvrEchaqmfMGobrD9tXJ.1EvJHzFgSTPoKJcceidJ9KW4bpIuzay'), 'michelle17@gmail.com', 'Michelle', 'Ferrari', 'images/michelle.jpg');

INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('5', '3', '2022-05-28 20:08:24', '0', '0','{"type": "sports", "text": "I ll try it", "id": "996", "url": "https://sports-api-production.s3.amazonaws.com/uploads/sport/images/996/kayak.jpg"}');

INSERT INTO `posts` (`id`, `user`,`time`, `nlikes`,`ncomments` , `content`) VALUES('6', '3', '2022-05-28 21:10:24', '0', '0','{"type": "giphy", "text": "i love cats", "id": "ICOgUNjpvO0PC", "url": "https://media3.giphy.com/media/ICOgUNjpvO0PC/giphy.gif?cid=ea99b8674c29331d763eceb0b41179f1c1144c154ee39066&rid=giphy.gif&ct=g"}');



INSERT INTO `follow` (`utente`, `follower`) VALUES('jeff64', 'bill28'),('bill28', 'jeff64'),('jeff64', 'michelle17'),('michelle17', 'jeff64'),('bill28', 'michelle17'),('michelle17', 'bill28');

INSERT INTO `comments`(`user`, `post`,text) VALUES('1','3','fantastic'),('1','4','ahahah'),('3','3','yeees'),('2','1','wow'),('2','2','crazy'),('3','1','Really?'),('3','2','wonderfull');

INSERT INTO `likes`(`user`, `post`) VALUES('1','3'),('1','4'),('2','1'),('2','2'),('3','1'),('3','2'),('3','3'),('3','4'),('1','5'),('1','6');;


/* username:bill28 password:bill2810*/

/*username:jeff64 password:jeff2810 */


/*username:michelle17 password:michelle1701 */
