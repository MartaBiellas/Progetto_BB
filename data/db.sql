-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.4.22-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dump della struttura del database database_bb
CREATE DATABASE IF NOT EXISTS `database_bb` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `database_bb`;

-- Dump della struttura di tabella database_bb.alunno
CREATE TABLE IF NOT EXISTS `alunno` (
  `matricola` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `email` char(50) NOT NULL,
  `password` char(200) NOT NULL,
  `nome` char(50) NOT NULL,
  `cognome` char(50) NOT NULL,
  `data_nascita` date NOT NULL,
  `sezione` char(3) NOT NULL,
  `anno` int(1) unsigned NOT NULL,
  PRIMARY KEY (`matricola`) USING BTREE,
  UNIQUE KEY `Email` (`email`) USING BTREE,
  KEY `Sezione_anno` (`sezione`,`anno`) USING BTREE,
  CONSTRAINT `FK_alunno_classe` FOREIGN KEY (`sezione`, `anno`) REFERENCES `classe` (`Sezione`, `anno`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.alunno: ~0 rows (circa)
/*!40000 ALTER TABLE `alunno` DISABLE KEYS */;
INSERT INTO `alunno` (`matricola`, `email`, `password`, `nome`, `cognome`, `data_nascita`, `sezione`, `anno`) VALUES
	(00000000002, 'guido.astori@liceobanfi.eu', 'guasto', 'Guido', 'Astori', '2005-02-12', 'C', 3),
	(00000000005, 'vittoria.seccia@liceobanfi.eu', '1234', 'Vittoria', 'Seccia', '2005-04-06', 'C', 3),
	(00000000008, 'alberto.dani@liceobanfi.eu', 'DaNi', 'Alberto', 'Dani', '2004-03-23', 'P', 4),
	(00000000010, 'andrea.ficco@liceobanfi.eu', '2004', 'Andrea', 'Ficco', '2004-05-05', 'P', 4),
	(00000000012, 'giancarlo.tiro@liceobanfi.eu', 'Cannone', 'Giancarlo', 'Tiro', '2007-05-21', 'A', 1),
	(00000000016, 'angela.tesone@liceobanfi.eu', 't<3', 'Angela', 'Tesone', '2007-12-21', 'A', 1);
/*!40000 ALTER TABLE `alunno` ENABLE KEYS */;

-- Dump della struttura di tabella database_bb.classe
CREATE TABLE IF NOT EXISTS `classe` (
  `sezione` char(3) NOT NULL,
  `anno` int(1) unsigned NOT NULL,
  `indirizzo_studio` char(50) NOT NULL,
  PRIMARY KEY (`sezione`,`anno`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.classe: ~0 rows (circa)
/*!40000 ALTER TABLE `classe` DISABLE KEYS */;
INSERT INTO `classe` (`sezione`, `anno`, `indirizzo_studio`) VALUES
	('A', 1, 'LC'),
	('C', 3, 'LS'),
	('P', 4, 'LSSA');
/*!40000 ALTER TABLE `classe` ENABLE KEYS */;

-- Dump della struttura di tabella database_bb.insegna_in
CREATE TABLE IF NOT EXISTS `insegna_in` (
  `matricola_professore` int(10) unsigned NOT NULL,
  `sezione` char(3) NOT NULL DEFAULT '',
  `anno` int(1) unsigned NOT NULL,
  KEY `FK_insegna_in_classe` (`sezione`,`anno`),
  KEY `matricola_professore` (`matricola_professore`),
  CONSTRAINT `FK_insegna_in_classe` FOREIGN KEY (`sezione`, `anno`) REFERENCES `classe` (`Sezione`, `anno`) ON UPDATE CASCADE,
  CONSTRAINT `FK_insegna_in_professore` FOREIGN KEY (`matricola_professore`) REFERENCES `professore` (`matricola`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.insegna_in: ~0 rows (circa)
/*!40000 ALTER TABLE `insegna_in` DISABLE KEYS */;
INSERT INTO `insegna_in` (`matricola_professore`, `sezione`, `anno`) VALUES
	(1, 'C', 3),
	(1, 'A', 1),
	(2, 'P', 4),
	(3, 'P', 4),
	(4, 'A', 1);
/*!40000 ALTER TABLE `insegna_in` ENABLE KEYS */;

-- Dump della struttura di tabella database_bb.professore
CREATE TABLE IF NOT EXISTS `professore` (
  `matricola` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `email` char(50) NOT NULL,
  `password` char(200) NOT NULL,
  `nome` char(50) NOT NULL,
  `cognome` char(50) NOT NULL,
  `data_nascita` date NOT NULL,
  `materia` char(50) NOT NULL,
  PRIMARY KEY (`matricola`) USING BTREE,
  UNIQUE KEY `Email` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.professore: ~0 rows (circa)
/*!40000 ALTER TABLE `professore` DISABLE KEYS */;
INSERT INTO `professore` (`matricola`, `email`, `password`, `nome`, `cognome`, `data_nascita`, `materia`) VALUES
	(0000000001, 'tina.soleno@liceobanfi.eu', 'sole', 'Tina', 'Soleno', '1990-04-06', 'Italiano'),
	(0000000002, 'guido.piano@liceobanfi.eu', 'inclinato', 'Guido', 'Piano', '1973-09-09', 'Scienze'),
	(0000000003, 'nando.maturi@liceobanfi.eu', '9876', 'Nando', 'Maturi', '1980-08-08', 'Matematica'),
	(0000000004, 'alessandra.citti@liceobanfi.eu', 'asdasd', 'Alessandra', 'Citti', '1985-02-01', 'Storia');
/*!40000 ALTER TABLE `professore` ENABLE KEYS */;

-- Dump della struttura di tabella database_bb.valutati_da
CREATE TABLE IF NOT EXISTS `valutati_da` (
  `matricola_professore` int(10) unsigned NOT NULL,
  `matricola_alunno` int(11) unsigned NOT NULL,
  KEY `matricola_alunno` (`matricola_alunno`),
  KEY `matricola_professore` (`matricola_professore`),
  CONSTRAINT `FK_valutati_da_alunno` FOREIGN KEY (`matricola_alunno`) REFERENCES `alunno` (`matricola`) ON UPDATE CASCADE,
  CONSTRAINT `FK_valutati_da_professore` FOREIGN KEY (`matricola_professore`) REFERENCES `professore` (`matricola`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.valutati_da: ~0 rows (circa)
/*!40000 ALTER TABLE `valutati_da` DISABLE KEYS */;
INSERT INTO `valutati_da` (`matricola_professore`, `matricola_alunno`) VALUES
	(2, 10),
	(2, 8),
	(3, 10),
	(3, 8),
	(4, 12),
	(4, 16),
	(1, 2),
	(1, 5),
	(1, 12),
	(1, 16);
/*!40000 ALTER TABLE `valutati_da` ENABLE KEYS */;

-- Dump della struttura di tabella database_bb.voto
CREATE TABLE IF NOT EXISTS `voto` (
  `materia` char(50) NOT NULL,
  `data` date NOT NULL,
  `tipo` char(50) NOT NULL,
  `valutazione` int(2) unsigned NOT NULL,
  `codice_voto` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `matricola_alunno` int(11) unsigned zerofill NOT NULL,
  `matricola_professore` int(10) unsigned zerofill NOT NULL,
  PRIMARY KEY (`codice_voto`) USING BTREE,
  KEY `Matricola_alunno` (`matricola_alunno`) USING BTREE,
  KEY `Matricola_professore` (`matricola_professore`) USING BTREE,
  CONSTRAINT `matricola_alunno` FOREIGN KEY (`matricola_alunno`) REFERENCES `alunno` (`matricola`) ON UPDATE CASCADE,
  CONSTRAINT `matricola_professore` FOREIGN KEY (`matricola_professore`) REFERENCES `professore` (`matricola`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

-- Dump dei dati della tabella database_bb.voto: ~0 rows (circa)
/*!40000 ALTER TABLE `voto` DISABLE KEYS */;
INSERT INTO `voto` (`materia`, `data`, `tipo`, `valutazione`, `codice_voto`, `matricola_alunno`, `matricola_professore`) VALUES
	('Italiano', '2022-04-09', 'Orale', 7, 0000000001, 00000000002, 0000000001),
	('Italiano', '2022-04-09', 'Orale', 8, 0000000002, 00000000005, 0000000001),
	('Italiano', '2021-12-12', 'Scritto', 6, 0000000004, 00000000002, 0000000001),
	('Italiano', '2022-01-30', 'Orale', 9, 0000000005, 00000000012, 0000000001),
	('Italiano', '2022-02-13', 'Scritto', 10, 0000000006, 00000000016, 0000000001),
	('Storia', '2022-02-16', 'Scritto', 8, 0000000007, 00000000012, 0000000004),
	('Storia', '2022-03-29', 'Scritto', 6, 0000000008, 00000000016, 0000000004),
	('Italiano', '2022-03-17', 'Orale', 9, 0000000009, 00000000016, 0000000001),
	('Storia', '2022-02-07', 'Orale', 4, 0000000010, 00000000012, 0000000004),
	('Storia', '2022-03-29', 'Scritto', 7, 0000000011, 00000000012, 0000000004),
	('Storia', '2022-03-29', 'Scritto', 4, 0000000012, 00000000016, 0000000004);
/*!40000 ALTER TABLE `voto` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
