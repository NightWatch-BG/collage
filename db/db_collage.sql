-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema collage
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema collage
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `collage` DEFAULT CHARACTER SET utf8 ;
USE `collage` ;

-- -----------------------------------------------------
-- Table `collage`.`design`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `collage`.`design` (
  `design_id` INT NOT NULL AUTO_INCREMENT,
  `preview` VARCHAR(45) NULL,
  `background_color` VARCHAR(45) NULL,
  PRIMARY KEY (`design_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `collage`.`element`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `collage`.`element` (
  `element_id` INT NOT NULL AUTO_INCREMENT,
  `design_fk` INT NULL,
  `type` VARCHAR(45) NULL,
  `src` VARCHAR(45) NULL,
  `top` INT NULL,
  `e_left` INT NULL,
  `width` INT NULL,
  `height` INT NULL,
  `fill` VARCHAR(45) NULL,
  `radius` INT NULL,
  `e_text` VARCHAR(45) NULL,
  PRIMARY KEY (`element_id`),
  INDEX `design_fk_idx` (`design_fk` ASC),
  CONSTRAINT `design_fk`
    FOREIGN KEY (`design_fk`)
    REFERENCES `collage`.`design` (`design_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
