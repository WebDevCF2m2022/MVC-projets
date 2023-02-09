-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema db_melvin_model
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_melvin_model
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_melvin_model` DEFAULT CHARACTER SET utf8 ;
USE `db_melvin_model` ;

-- -----------------------------------------------------
-- Table `db_melvin_model`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_melvin_model`.`user` ;

CREATE TABLE IF NOT EXISTS `db_melvin_model`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(80) NOT NULL,
  `usermail` VARCHAR(200) NOT NULL,
  `userpwd` VARCHAR(255) NOT NULL,
  `userscreen` VARCHAR(400) NOT NULL,
  `useruniquid` VARCHAR(120) NOT NULL COMMENT 'identifiant unique',
  `actif` TINYINT UNSIGNED NULL DEFAULT 0 COMMENT '0=> inactif\n1=> actif\n2=> banni',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `usermail_UNIQUE` (`usermail` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_melvin_model`.`post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_melvin_model`.`post` ;

CREATE TABLE IF NOT EXISTS `db_melvin_model`.`post` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `content` TEXT NOT NULL,
  `datecreate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `visible` TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT '0 = not visible\n1 = visible',
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC) VISIBLE,
  INDEX `fk_post_user_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_post_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `db_melvin_model`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_melvin_model`.`category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_melvin_model`.`category` ;

CREATE TABLE IF NOT EXISTS `db_melvin_model`.`category` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tiltle` VARCHAR(100) NOT NULL,
  `content` VARCHAR(800) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `tiltle_UNIQUE` (`tiltle` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `db_melvin_model`.`category_has_post`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_melvin_model`.`category_has_post` ;

CREATE TABLE IF NOT EXISTS `db_melvin_model`.`category_has_post` (
  `category_id` INT UNSIGNED NOT NULL,
  `post_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`category_id`, `post_id`),
  INDEX `fk_category_has_post_post1_idx` (`post_id` ASC) VISIBLE,
  INDEX `fk_category_has_post_category1_idx` (`category_id` ASC) VISIBLE,
  CONSTRAINT `fk_category_has_post_category1`
    FOREIGN KEY (`category_id`)
    REFERENCES `db_melvin_model`.`category` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_category_has_post_post1`
    FOREIGN KEY (`post_id`)
    REFERENCES `db_melvin_model`.`post` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
