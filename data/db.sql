-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versione server:              10.1.38-MariaDB - mariadb.org binary distribution
-- S.O. server:                  Win64
-- HeidiSQL Versione:            10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dump della struttura del database biblioteca
CREATE DATABASE IF NOT EXISTS `biblioteca` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `biblioteca`;

-- Dump della struttura di tabella biblioteca.autori
CREATE TABLE IF NOT EXISTS `autori` (
  `cod_autore` int(11) NOT NULL AUTO_INCREMENT,
  `nome` char(50) DEFAULT NULL,
  `cognome` char(50) DEFAULT NULL,
  PRIMARY KEY (`cod_autore`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella biblioteca.autori: ~2 rows (circa)
/*!40000 ALTER TABLE `autori` DISABLE KEYS */;
INSERT INTO `autori` (`cod_autore`, `nome`, `cognome`) VALUES
	(1, 'Alessandro', 'Manzoni'),
	(2, 'Dante', 'Alighieri');
/*!40000 ALTER TABLE `autori` ENABLE KEYS */;

-- Dump della struttura di tabella biblioteca.bibliotecari
CREATE TABLE IF NOT EXISTS `bibliotecari` (
  `username` char(20) NOT NULL,
  `password` char(20) NOT NULL,
  `nome` char(20) DEFAULT NULL,
  `cognome` char(20) DEFAULT NULL,
  `email` char(20) DEFAULT NULL,
  `telefono` char(20) DEFAULT NULL,
  `comune` char(20) DEFAULT NULL,
  `indirizzo` char(40) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT COMMENT='tabella contenente gli username e le rispettive password';

-- Dump dei dati della tabella biblioteca.bibliotecari: ~3 rows (circa)
/*!40000 ALTER TABLE `bibliotecari` DISABLE KEYS */;
INSERT INTO `bibliotecari` (`username`, `password`, `nome`, `cognome`, `email`, `telefono`, `comune`, `indirizzo`) VALUES
	('Achi11e', '1234', 'Francesco', 'Tormene', '', '', 'Vimercate', ''),
	('asd', 'asd', 'Mario', 'Rossi', 'mario.rossi@gmail.co', '123456789', 'Bergamo', 'Via Monza 1'),
	('bellissimo2001', '4321', 'Lorenzo', 'Tiraboschi', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `bibliotecari` ENABLE KEYS */;

-- Dump della struttura di tabella biblioteca.libri
CREATE TABLE IF NOT EXISTS `libri` (
  `cod_libro` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` char(50) DEFAULT NULL,
  `cod_autore` int(11) DEFAULT NULL,
  `username_utente` char(20) DEFAULT NULL,
  PRIMARY KEY (`cod_libro`),
  KEY `FK_libri_utenti` (`username_utente`),
  KEY `FK_libri_autori` (`cod_autore`),
  CONSTRAINT `FK_libri_autori` FOREIGN KEY (`cod_autore`) REFERENCES `autori` (`cod_autore`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_libri_utenti` FOREIGN KEY (`username_utente`) REFERENCES `utenti` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dump dei dati della tabella biblioteca.libri: ~3 rows (circa)
/*!40000 ALTER TABLE `libri` DISABLE KEYS */;
INSERT INTO `libri` (`cod_libro`, `titolo`, `cod_autore`, `username_utente`) VALUES
	(1, 'I promessi sposi', 1, NULL),
	(2, 'La divina commedia', 2, NULL),
	(3, 'Vediamo che cosa succede se metto un titolo lunghi', 1, NULL);
/*!40000 ALTER TABLE `libri` ENABLE KEYS */;

-- Dump della struttura di tabella biblioteca.utenti
CREATE TABLE IF NOT EXISTS `utenti` (
  `username` char(20) NOT NULL,
  `password` char(20) NOT NULL,
  `nome` char(20) DEFAULT NULL,
  `cognome` char(20) DEFAULT NULL,
  `email` char(20) DEFAULT NULL,
  `telefono` char(20) DEFAULT NULL,
  `comune` char(20) DEFAULT NULL,
  `indirizzo` char(40) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='tabella contenente gli username e le rispettive password';

-- Dump dei dati della tabella biblioteca.utenti: ~3 rows (circa)
/*!40000 ALTER TABLE `utenti` DISABLE KEYS */;
INSERT INTO `utenti` (`username`, `password`, `nome`, `cognome`, `email`, `telefono`, `comune`, `indirizzo`) VALUES
	('Achi11e', '1234', 'Francesco', 'Tormene', '', '', 'Vimercate', ''),
	('asd', 'asd', 'Mario', 'Rossi', 'mario.rossi@gmail.co', '123456789', 'Bergamo', 'Via Monza 1'),
	('bellissimo2001', '4321', 'Lorenzo', 'Tiraboschi', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `utenti` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
