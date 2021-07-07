-- MySQL Workbench Synchronization
-- Generated: 2021-07-07 09:57
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Authentic

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

ALTER TABLE `u589673144_mukunday02`.`promotion` 
CHANGE COLUMN `dateCreation` `dateCreation` DATETIME NULL DEFAULT current_timestamp ;

ALTER TABLE `u589673144_mukunday02`.`options` 
CHANGE COLUMN `dateCreation` `dateCreation` DATETIME NULL DEFAULT current_timestamp ;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`parent` (
  `idparent` INT(11) NOT NULL AUTO_INCREMENT,
  `nomcomplet` VARCHAR(45) NULL DEFAULT NULL,
  `prenom` VARCHAR(45) NULL DEFAULT NULL,
  `login` VARCHAR(45) NULL DEFAULT NULL,
  `password` TEXT NULL DEFAULT NULL,
  `adresse` VARCHAR(45) NULL DEFAULT NULL,
  `idpiece` INT(11) NOT NULL,
  PRIMARY KEY (`idparent`),
  INDEX `fk_parent_pieceidentite1_idx` (`idpiece` ASC) ,
  CONSTRAINT `fk_parent_pieceidentite1`
    FOREIGN KEY (`idpiece`)
    REFERENCES `u589673144_mukunday02`.`pieceidentite` (`idpiece`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`parent_has_etudiant` (
  `idparent` INT(11) NOT NULL,
  `idetudiant` INT(11) NOT NULL,
  PRIMARY KEY (`idparent`, `idetudiant`),
  INDEX `fk_parent_has_etudiant_etudiant1_idx` (`idetudiant` ASC) ,
  INDEX `fk_parent_has_etudiant_parent1_idx` (`idparent` ASC) ,
  CONSTRAINT `fk_parent_has_etudiant_parent1`
    FOREIGN KEY (`idparent`)
    REFERENCES `u589673144_mukunday02`.`parent` (`idparent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_parent_has_etudiant_etudiant1`
    FOREIGN KEY (`idetudiant`)
    REFERENCES `u589673144_mukunday02`.`etudiant` (`idetudiant`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`ecole` (
  `idecole` INT(11) NOT NULL AUTO_INCREMENT,
  `nomecole` VARCHAR(45) NULL DEFAULT NULL,
  `login` VARCHAR(45) NULL DEFAULT NULL,
  `password` TEXT NULL DEFAULT NULL,
  `logo` TEXT NULL DEFAULT NULL,
  `derniere_activite` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`idecole`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`pieceidentite` (
  `idpiece` INT(11) NOT NULL AUTO_INCREMENT,
  `intitule` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`idpiece`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`eleve` (
  `ideleve` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(45) NULL DEFAULT NULL,
  `postnom` VARCHAR(45) NULL DEFAULT NULL,
  `prenom` VARCHAR(45) NULL DEFAULT NULL,
  `matricule` VARCHAR(45) NULL DEFAULT NULL,
  `adresse` VARCHAR(45) NULL DEFAULT NULL,
  `password` TEXT NULL DEFAULT NULL,
  `idclasse` INT(11) NOT NULL,
  PRIMARY KEY (`ideleve`),
  INDEX `fk_eleve_classe1_idx` (`idclasse` ASC) ,
  CONSTRAINT `fk_eleve_classe1`
    FOREIGN KEY (`idclasse`)
    REFERENCES `u589673144_mukunday02`.`classe` (`idclasse`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`parent_has_eleve` (
  `idparent` INT(11) NOT NULL,
  `ideleve` INT(11) NOT NULL,
  PRIMARY KEY (`idparent`, `ideleve`),
  INDEX `fk_parent_has_eleve_eleve1_idx` (`ideleve` ASC) ,
  INDEX `fk_parent_has_eleve_parent1_idx` (`idparent` ASC) ,
  CONSTRAINT `fk_parent_has_eleve_parent1`
    FOREIGN KEY (`idparent`)
    REFERENCES `u589673144_mukunday02`.`parent` (`idparent`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_parent_has_eleve_eleve1`
    FOREIGN KEY (`ideleve`)
    REFERENCES `u589673144_mukunday02`.`eleve` (`ideleve`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`optionecole` (
  `idoptionecole` INT(11) NOT NULL AUTO_INCREMENT,
  `intituleOption` VARCHAR(45) NULL DEFAULT NULL,
  `idsection` INT(11) NOT NULL,
  PRIMARY KEY (`idoptionecole`, `idsection`),
  INDEX `fk_optionecole_section1_idx` (`idsection` ASC) ,
  CONSTRAINT `fk_optionecole_section1`
    FOREIGN KEY (`idsection`)
    REFERENCES `u589673144_mukunday02`.`section` (`idsection`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`section` (
  `idsection` INT(11) NOT NULL AUTO_INCREMENT,
  `intitulesection` VARCHAR(45) NULL DEFAULT NULL,
  `idecole` INT(11) NOT NULL,
  PRIMARY KEY (`idsection`),
  INDEX `fk_section_ecole1_idx` (`idecole` ASC) ,
  CONSTRAINT `fk_section_ecole1`
    FOREIGN KEY (`idecole`)
    REFERENCES `u589673144_mukunday02`.`ecole` (`idecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`classe` (
  `idclasse` INT(11) NOT NULL AUTO_INCREMENT,
  `intituleclasse` VARCHAR(45) NULL DEFAULT NULL,
  `idoptionecole` INT(11) NOT NULL,
  `idannee_scolaire_ecole` INT(11) NOT NULL,
  PRIMARY KEY (`idclasse`),
  INDEX `fk_classe_optionecole1_idx` (`idoptionecole` ASC) ,
  INDEX `fk_classe_annee_scolaire_ecole1_idx` (`idannee_scolaire_ecole` ASC) ,
  CONSTRAINT `fk_classe_optionecole1`
    FOREIGN KEY (`idoptionecole`)
    REFERENCES `u589673144_mukunday02`.`optionecole` (`idoptionecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_classe_annee_scolaire_ecole1`
    FOREIGN KEY (`idannee_scolaire_ecole`)
    REFERENCES `u589673144_mukunday02`.`annee_scolaire_ecole` (`idannee_scolaire_ecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`annee_scolaire_ecole` (
  `idannee_scolaire_ecole` INT(11) NOT NULL AUTO_INCREMENT,
  `date_debut` DATE NULL DEFAULT NULL,
  `date_fin` DATE NULL DEFAULT NULL,
  `idecole` INT(11) NOT NULL,
  `actif` TINYINT(4) NULL DEFAULT NULL,
  PRIMARY KEY (`idannee_scolaire_ecole`),
  INDEX `fk_annee_scolaire_ecole_ecole1_idx` (`idecole` ASC) ,
  CONSTRAINT `fk_annee_scolaire_ecole_ecole1`
    FOREIGN KEY (`idecole`)
    REFERENCES `u589673144_mukunday02`.`ecole` (`idecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`frais_ecole` (
  `idfrais_ecole` INT(11) NOT NULL AUTO_INCREMENT,
  `intitulefrais` VARCHAR(45) NULL DEFAULT NULL,
  `montant` DOUBLE NULL DEFAULT NULL,
  `iddevise` INT(11) NOT NULL,
  `idannee_scolaire_ecole` INT(11) NOT NULL,
  `idbanque` INT(11) NOT NULL,
  PRIMARY KEY (`idfrais_ecole`),
  INDEX `fk_frais_ecole_devise1_idx` (`iddevise` ASC) ,
  INDEX `fk_frais_ecole_annee_scolaire_ecole1_idx` (`idannee_scolaire_ecole` ASC) ,
  INDEX `fk_frais_ecole_banque1_idx` (`idbanque` ASC) ,
  CONSTRAINT `fk_frais_ecole_devise1`
    FOREIGN KEY (`iddevise`)
    REFERENCES `u589673144_mukunday02`.`devise` (`iddevise`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_frais_ecole_annee_scolaire_ecole1`
    FOREIGN KEY (`idannee_scolaire_ecole`)
    REFERENCES `u589673144_mukunday02`.`annee_scolaire_ecole` (`idannee_scolaire_ecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_frais_ecole_banque1`
    FOREIGN KEY (`idbanque`)
    REFERENCES `u589673144_mukunday02`.`banque` (`idbanque`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `u589673144_mukunday02`.`paiement_ecole` (
  `idpaiement_ecole` INT(11) NOT NULL AUTO_INCREMENT,
  `date_paiement` VARCHAR(45) NULL DEFAULT NULL,
  `montant` DOUBLE NULL DEFAULT NULL,
  `commission` DOUBLE NULL DEFAULT NULL,
  `montantTot` DOUBLE NULL DEFAULT NULL,
  `ideleve` INT(11) NOT NULL,
  `idfrais_ecole` INT(11) NOT NULL,
  PRIMARY KEY (`idpaiement_ecole`),
  INDEX `fk_paiement_ecole_eleve1_idx` (`ideleve` ASC) ,
  INDEX `fk_paiement_ecole_frais_ecole1_idx` (`idfrais_ecole` ASC) ,
  CONSTRAINT `fk_paiement_ecole_eleve1`
    FOREIGN KEY (`ideleve`)
    REFERENCES `u589673144_mukunday02`.`eleve` (`ideleve`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_paiement_ecole_frais_ecole1`
    FOREIGN KEY (`idfrais_ecole`)
    REFERENCES `u589673144_mukunday02`.`frais_ecole` (`idfrais_ecole`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
