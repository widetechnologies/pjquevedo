
CREATE TABLE IF NOT EXISTS `lingua` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `nivel` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `descricao_UNIQUE` (`descricao` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `aluno_lingua` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ra` VARCHAR(8) NULL DEFAULT NULL,
  `idnivel` INT(11) NOT NULL,
  `idlingua` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `idnivel`, `idlingua`),
  INDEX `fk_aluno_lingua_nivel_idx` (`idnivel` ASC),
  INDEX `fk_aluno_lingua_lingua1_idx` (`idlingua` ASC),
  CONSTRAINT `fk_aluno_lingua_nivel`
    FOREIGN KEY (`idnivel`)
    REFERENCES `nivel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_aluno_lingua_lingua1`
    FOREIGN KEY (`idlingua`)
    REFERENCES `lingua` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `parceiro` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `instituicao` VARCHAR(255) NULL DEFAULT NULL,
  `pais` VARCHAR(255) NULL DEFAULT NULL,
  `cidade` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `processo` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dtini` DATE NULL DEFAULT NULL,
  `dtfim` DATE NULL DEFAULT NULL,
  `idparceiro` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `idparceiro`),
  INDEX `fk_processo_parceiro1_idx` (`idparceiro` ASC),
  CONSTRAINT `fk_processo_parceiro1`
    FOREIGN KEY (`idparceiro`)
    REFERENCES `parceiro` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `situacao` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `decricao` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `inscricao` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ra` VARCHAR(8) NULL DEFAULT NULL,
  `dtinsc` DATETIME NULL DEFAULT NULL,
  `idsituacao` INT(11) NOT NULL,
  `idprocesso` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `idsituacao`, `idprocesso`),
  INDEX `fk_inscricao_situacao1_idx` (`idsituacao` ASC),
  INDEX `fk_inscricao_processo1_idx` (`idprocesso` ASC),
  CONSTRAINT `fk_inscricao_situacao1`
    FOREIGN KEY (`idsituacao`)
    REFERENCES `situacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscricao_processo1`
    FOREIGN KEY (`idprocesso`)
    REFERENCES `processo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `horario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `datahora` DATETIME NULL DEFAULT NULL,
  `idprocesso` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `idprocesso`),
  INDEX `fk_horario_processo1_idx` (`idprocesso` ASC),
  CONSTRAINT `fk_horario_processo1`
    FOREIGN KEY (`idprocesso`)
    REFERENCES `processo` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `agenda` (
  `id` INT(11) NOT NULL,
  `ra` VARCHAR(8) NULL DEFAULT NULL,
  `presente` TINYINT(5) NULL DEFAULT NULL,
  `idhorario` INT(11) NOT NULL,
  PRIMARY KEY (`id`, `idhorario`),
  INDEX `fk_agenda_horario1_idx` (`idhorario` ASC),
  CONSTRAINT `fk_agenda_horario1`
    FOREIGN KEY (`idhorario`)
    REFERENCES `horario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `tipo_doc` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `documento` VARCHAR(255) NULL DEFAULT NULL,
  `descricao` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
