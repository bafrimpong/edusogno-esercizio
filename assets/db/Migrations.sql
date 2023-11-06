CREATE TABLE IF NOT EXISTS users (
id int NOT NULL AUTO_INCREMENT,
first_name varchar(45),
last_name varchar(45),
email varchar(255),
password varchar(255),
is_admin boolean DEFAULT false,
PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS events (
id int NOT NULL AUTO_INCREMENT,
attendees text,
event_name varchar(255),
event_date datetime,
event_description text,
PRIMARY KEY (id)
);

INSERT INTO `events`(`attendees`, `event_name`, `event_date`, `event_description`) VALUES ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 1', '2022-10-13 14:00', 'test description 1'), ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net','Test Edusogno 2', '2022-10-15 19:00', 'test description 2'), ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net','Test Edusogno 3', '2022-10-15 19:00', 'test description 3');
INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES ('Bismark A', 'Frimpong', 'battafrimpong@gmail.com', '@passWord23', true);
INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES ('Marco', 'Rossi', 'ulysses200915@varen8.com', 'Edusogno123', false);
INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES ('Fillipo', 'D’Amelio', 'qmonkey14@falixiao.com', 'Edusogno?123', false);
INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES ('Gian Luca', 'Carta', 'mavbafpcmq@hitbase.net', 'EdusognoCiao', false);
INSERT INTO `users`(`first_name`, `last_name`, `email`, `password`, `is_admin`) VALUES ('Stella', 'De Grandis', 'dgipolga@edume.me', 'EdusognoGia', false);