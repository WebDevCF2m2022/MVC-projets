-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mvcprojets
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mvcprojets
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mvcprojets` DEFAULT CHARACTER SET utf8 ;
USE `mvcprojets` ;

-- -----------------------------------------------------
-- Table `mvcprojets`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvcprojets`.`user` ;

CREATE TABLE IF NOT EXISTS `mvcprojets`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(80) NOT NULL,
  `usermail` VARCHAR(200) NOT NULL,
  `userpwd` VARCHAR(255) NOT NULL,
  `userscreen` VARCHAR(400) NOT NULL,
  `useruniqid` VARCHAR(120) NULL COMMENT 'idententifiant unique',
  `actif` TINYINT UNSIGNED NULL DEFAULT 0 COMMENT '0 => inactif\n1  => actif\n2 => banni',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `usermail_UNIQUE` (`usermail` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mvcprojets`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvcprojets`.`post` ;

CREATE TABLE IF NOT EXISTS `mvcprojets`.`post` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `content` TEXT NOT NULL,
  `datecreate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 => not visible\n1 => visible',
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_post_user_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_post_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `mvcprojets`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mvcprojets`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvcprojets`.`category` ;

CREATE TABLE IF NOT EXISTS `mvcprojets`.`category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL,
  `content` VARCHAR(800) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mvcprojets`.`category_has_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mvcprojets`.`category_has_post` ;

CREATE TABLE IF NOT EXISTS `mvcprojets`.`category_has_post` (
  `category_id` INT UNSIGNED NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  INDEX `fk_category_has_post_post1_idx` (`post_id` ASC) VISIBLE,
  INDEX `fk_category_has_post_category1_idx` (`category_id` ASC) VISIBLE,
  PRIMARY KEY (`category_id`, `post_id`),
  CONSTRAINT `fk_category_has_post_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `mvcprojets`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_has_post_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `mvcprojets`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
