DROP TABLE IF EXISTS  ArticleComments, Comments, Answers, Articles, UserScores, User;

--
-- Table User
--

CREATE TABLE User (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `username` VARCHAR(80) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(80) UNIQUE NOT NULL,
    `activityScore` INT DEFAULT 0,
    `posts` INT DEFAULT 0
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Table articles
--

CREATE TABLE Articles (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `title` VARCHAR(80) NOT NULL,
    `content` TEXT NOT NULL,
    `tags` JSON NOT NULL,
    `score` INT DEFAULT 0,
    `userId` VARCHAR (80) NOT NULL,
    `created` DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userId) REFERENCES User(username)
) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Answers
--

CREATE TABLE Answers (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `articleId` INTEGER NOT NULL,
    `username` VARCHAR(80) NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    FOREIGN KEY (username) REFERENCES User(username),
    FOREIGN KEY (articleId) REFERENCES Articles(id)

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Comments
--

CREATE TABLE Comments (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    `articleId` INTEGER,
    `answerId` INTEGER,
    `userId` VARCHAR(80) NOT NULL,
    FOREIGN KEY (articleId) REFERENCES Articles(id),
    FOREIGN KEY (userId) REFERENCES User(username)

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;

--
-- Comments
--

CREATE TABLE ArticleComments (
    `id` INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `content` VARCHAR(255) NOT NULL,
    `articleId` INTEGER,
    `userId` VARCHAR(80) NOT NULL,
    FOREIGN KEY (articleId) REFERENCES Articles(id),
    FOREIGN KEY (userId) REFERENCES User(username)

) ENGINE INNODB CHARACTER SET utf8 COLLATE utf8_swedish_ci;
