-- -----------------------------------------------------
-- Schema NetWork
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `NetWork` DEFAULT CHARACTER SET utf8 ;
USE `NetWork` ;

-- -----------------------------------------------------
-- Table `NetWork`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `lastName` VARCHAR(45) NULL,
  `name` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `phone` VARCHAR(10) NULL,
  `photo` VARCHAR(255) NULL,
  `password` VARCHAR(256) NOT NULL,
  `status` ENUM('company', 'employee') NOT NULL,
  `job` VARCHAR(45) NULL,
  `company` VARCHAR(45) NULL,
  `town` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `mail_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`contacts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `contact` INT NULL,
  `user` INT NOT NULL,
  PRIMARY KEY (`id`, `user`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_contacts_users1_idx` (`user` ASC) ,
  CONSTRAINT `fk_contacts_users1`
    FOREIGN KEY (`user`)
    REFERENCES `NetWork`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`privateMessages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`privateMessages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` LONGTEXT NULL,
  `reicever` INT NULL,
  `sendDate` DATETIME NULL,
  `sender` INT NOT NULL,
  PRIMARY KEY (`id`, `sender`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_privateMessages_users1_idx` (`sender` ASC) ,
  CONSTRAINT `fk_privateMessages_users1`
    FOREIGN KEY (`sender`)
    REFERENCES `NetWork`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `eventDate` DATETIME NOT NULL,
  `place` VARCHAR(45) NULL,
  `admin` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`publications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`publications` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NULL,
  `postDate` DATETIME NULL,
  `type` ENUM('text', 'image') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`post` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `publication` INT NOT NULL,
  `user` INT NOT NULL,
  PRIMARY KEY (`id`, `publication`, `user`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_post_publications1_idx` (`publication` ASC) ,
  INDEX `fk_post_users1_idx` (`user` ASC) ,
  CONSTRAINT `fk_post_publications1`
    FOREIGN KEY (`publication`)
    REFERENCES `NetWork`.`publications` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_users1`
    FOREIGN KEY (`user`)
    REFERENCES `NetWork`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`participate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`participate` (
  `id` INT ZEROFILL NOT NULL,
  `user` INT NOT NULL,
  `event` INT NOT NULL,
  PRIMARY KEY (`id`, `user`, `event`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_participate_users1_idx` (`user` ASC) ,
  INDEX `fk_participate_events1_idx` (`event` ASC) ,
  CONSTRAINT `fk_participate_users1`
    FOREIGN KEY (`user`)
    REFERENCES `NetWork`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_participate_events1`
    FOREIGN KEY (`event`)
    REFERENCES `NetWork`.`events` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`groups` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `createDate` DATE NULL,
  `admin` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `titre_UNIQUE` (`title` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`coms`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`coms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  `comDate` DATETIME NOT NULL,
  `user` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`comment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `com` INT NOT NULL,
  `publication` INT NOT NULL,
  PRIMARY KEY (`id`, `com`, `publication`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_comment_coms1_idx` (`com` ASC) ,
  INDEX `fk_comment_publications1_idx` (`publication` ASC) ,
  CONSTRAINT `fk_comment_coms1`
    FOREIGN KEY (`com`)
    REFERENCES `NetWork`.`coms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_publications1`
    FOREIGN KEY (`publication`)
    REFERENCES `NetWork`.`publications` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetWork`.`groupAdd`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `NetWork`.`groupAdd` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` LONGTEXT NULL,
  `addDate` DATETIME NOT NULL,
`user` INT NOT NULL,
  `status` ENUM('message', 'member') NULL,
  `group` INT NOT NULL,
  PRIMARY KEY (`id`, `user`, `group`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_groupMessages_users1_idx` (`user` ASC) ,
  INDEX `fk_groupAdd_groups1_idx` (`group` ASC) ,
  CONSTRAINT `fk_groupMessages_users1`
    FOREIGN KEY (`user`)
    REFERENCES `NetWork`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_groupAdd_groups1`
    FOREIGN KEY (`group`)
    REFERENCES `NetWork`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
