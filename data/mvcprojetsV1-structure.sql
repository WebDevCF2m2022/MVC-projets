-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0;
SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0;
SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = ''TRADITIONAL,ALLOW_INVALID_DATES'';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema mvcprojets
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mvcprojets
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mvcprojets` DEFAULT CHARACTER SET utf8;
USE `mvcprojets`;

-- -----------------------------------------------------
-- Table `mvcprojets`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mvcprojets`.`category`
(
    `id`      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`   VARCHAR(100)     NOT NULL,
    `content` VARCHAR(800)     NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `title_UNIQUE` (`title` ASC)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 6
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mvcprojets`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mvcprojets`.`user`
(
    `id`         INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `username`   VARCHAR(80)         NOT NULL,
    `usermail`   VARCHAR(200)        NOT NULL,
    `userpwd`    VARCHAR(255)        NOT NULL,
    `userscreen` VARCHAR(400)        NOT NULL,
    `useruniqid` VARCHAR(120)        NULL DEFAULT NULL COMMENT '' idententifiant unique '',
    `actif`      TINYINT(3) UNSIGNED NULL DEFAULT 0 COMMENT ''0 => inactif\\n1 => actif\\n2 => banni '',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `username_UNIQUE` (`username` ASC),
    UNIQUE INDEX `usermail_UNIQUE` (`usermail` ASC)
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 5
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mvcprojets`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mvcprojets`.`post`
(
    `id`         INT(10) UNSIGNED    NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(200)        NOT NULL,
    `content`    TEXT                NOT NULL,
    `datecreate` DATETIME            NULL     DEFAULT CURRENT_TIMESTAMP(),
    `visible`    TINYINT(3) UNSIGNED NOT NULL DEFAULT 0 COMMENT ''0 => not visible \\n1 => visible '',
    `user_id`    INT(10) UNSIGNED    NULL     DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `fk_post_user_idx` (`user_id` ASC),
    CONSTRAINT `fk_post_user`
        FOREIGN KEY (`user_id`)
            REFERENCES `mvcprojets`.`user` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB
    AUTO_INCREMENT = 5
    DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `mvcprojets`.`category_has_post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mvcprojets`.`category_has_post`
(
    `category_id` INT(10) UNSIGNED NOT NULL,
    `post_id`     INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (`category_id`, `post_id`),
    INDEX `fk_category_has_post_post1_idx` (`post_id` ASC),
    INDEX `fk_category_has_post_category1_idx` (`category_id` ASC),
    CONSTRAINT `fk_category_has_post_category1`
        FOREIGN KEY (`category_id`)
            REFERENCES `mvcprojets`.`category` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION,
    CONSTRAINT `fk_category_has_post_post1`
        FOREIGN KEY (`post_id`)
            REFERENCES `mvcprojets`.`post` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
)
    ENGINE = InnoDB
    DEFAULT CHARACTER SET = utf8;


SET SQL_MODE = @OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS;
