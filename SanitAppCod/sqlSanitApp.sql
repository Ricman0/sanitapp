/**
 * Author:  Claudia Di Marco & Riccardo Mantini
 * Created: 20-ago-2016
 */

DROP DATABASE IF EXISTS sanitapp;
CREATE DATABASE sanitapp;
USE sanitapp;

--
-- Database: `sanitapp`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--

CREATE TABLE categoria (
  Nome varchar(30) NOT NULL,
  PRIMARY KEY (Nome)
);

--
-- Dump dei dati per la tabella `categoria`
--

INSERT INTO categoria (Nome) VALUES
('Analisi'),
('Raggi'),
('Tac'),
('Visita Preliminare');

-- --------------------------------------------------------

--
-- Struttura della tabella `clinica`
--

CREATE TABLE clinica (
  PartitaIVA varchar(11) NOT NULL,
  NomeClinica varchar(30) NOT NULL,
  Titolare varchar(50) NOT NULL,
  Via varchar(30) NOT NULL,
  NumCivico smallint(6) DEFAULT NULL,
  CAP varchar(5) NOT NULL,
  Località varchar (40) NOT NULL,
  Provincia varchar (20) NOT NULL,
  Regione varchar (20) NOT NULL,
  Email varchar(320) NOT NULL,
  Username varchar(10) NOT NULL,
  Password varchar(10) NOT NULL,
  PEC varchar(320) NOT NULL,
  Telefono int(10) DEFAULT NULL,
  CapitaleSociale int(11) DEFAULT NULL,
  OrarioAperturaAM time DEFAULT NULL,
  OrarioChiusuraAM time DEFAULT NULL,
  OrarioAperturaPM time DEFAULT NULL,
  OrarioChiusuraPM time DEFAULT NULL,
  OrarioContinuato boolean DEFAULT FALSE,
  Confermato boolean DEFAULT FALSE,
  CodiceConferma varchar (255) NOT NULL,
  PRIMARY KEY (PartitaIVA),
  UNIQUE (Email),
  UNIQUE (Username),
  UNIQUE (PEC),
  UNIQUE (Telefono), 
  UNIQUE (CodiceConferma)
);

ALTER TABLE clinica ADD FULLTEXT INDEX fullTextNomeClinica(NomeClinica);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextLocalitàClinica(Località);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextProvinciaClinica(Provincia);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextRegioneClinica(Regione);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextCAPClinica(CAP);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextUsernameClinica(Username);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextPasswordClinica(Password);


--
-- Dump dei dati per la tabella `clinica`
--

INSERT INTO clinica (PartitaIVA, NomeClinica, Titolare, Via, NumCivico, CAP, Località,
Provincia, Regione, Email, Username, Password, PEC, Telefono, CapitaleSociale, OrarioAperturaAM, 
OrarioChiusuraAM, OrarioAperturaPM, OrarioChiusuraPM, OrarioContinuato, Confermato, CodiceConferma) VALUES
('12345', 'appignano', 'riccardo', 'del carmine', 2, '65017', 'Penne', 'Pescara', 'Abruzzo', 'info@appignano.it', ' appi', 'Appig4', ' info@appignano.pec', 8612, 123456789, '08:00:00','12:00:00', '15:00:00', '20:00:00', FALSE, FALSE, 's12'),
('12346', 'bisenti', 'lucio', 'del corso', 87, '65017','Penne', 'Pescara' , 'Abruzzo', 'info@bisenti.it', ' bise', 'Bisenti5', ' info@bisenti.pec', 8613, 123456780, '09:00:00', '13:00:00','16:00:00', '19:00:00', FALSE, FALSE, 'w34');

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE esame(
  IDEsame varchar(13) NOT NULL,
  Nome varchar(50) NOT NULL,
  Descrizione varchar(200) DEFAULT NULL,
  Prezzo float NOT NULL,
  Durata time NOT NULL,
  MedicoEsame varchar(40) NOT NULL,
  NumPrestazioniSimultanee smallint(6) NOT NULL,
  NomeCategoria varchar(30) NOT NULL,
  PartitaIVAClinica varchar(20) NOT NULL,
  PRIMARY KEY (IDEsame,PartitaIVAClinica),
  FOREIGN KEY (PartitaIVAClinica) REFERENCES clinica (PartitaIVA),
  FOREIGN KEY (NomeCategoria) REFERENCES categoria (Nome)

);

ALTER TABLE esame ADD FULLTEXT INDEX fullTextEsame(Nome);


--
-- Dump dei dati per la tabella `esame`
--

INSERT INTO esame (IDEsame, Nome, Descrizione, Prezzo, Durata, MedicoEsame, 
NumPrestazioniSimultanee, NomeCategoria, PartitaIVAClinica) VALUES
(1, 'raggi braccio', 'raggi al braccio', 30, '00:15:00', 'Riga', 1, 'Raggi', '12345'),
(2, 'raggi piede', 'raggi al piede', 30, '00:15:00', 'Riga', 1, 'Raggi', '12345');

-- --------------------------------------------------------

--
-- Struttura della tabella `medico`
--

CREATE TABLE medico (
  CodFiscale varchar(16) NOT NULL,
  Nome varchar(20) NOT NULL,
  Cognome varchar(20) NOT NULL,
  Via varchar(30) NOT NULL,
  NumCivico smallint(6) DEFAULT NULL,
  CAP varchar(5) NOT NULL,
  Email varchar(320) NOT NULL,
  Username varchar(15) NOT NULL,
  Password varchar(10) NOT NULL,
  PEC varchar(320) NOT NULL,
  Validato tinyint(1) DEFAULT '0',
  ProvinciaAlbo varchar(2) NOT NULL,
  NumIscrizione smallint(6) NOT NULL,
  Confermato boolean DEFAULT FALSE,
  CodiceConferma varchar (255) NOT NULL,
  PRIMARY KEY (CodFiscale),
  UNIQUE (Email),
  UNIQUE (Username),
  UNIQUE (PEC), 
  UNIQUE (CodiceConferma)
);

ALTER TABLE medico ADD FULLTEXT INDEX fullTextUsernameMedico(Username);
ALTER TABLE medico ADD FULLTEXT INDEX fullTextPasswordMedico(Password);
--
-- Dump dei dati per la tabella `medico`
--

INSERT INTO medico (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, Email, Username, 
Password, PEC, Validato, ProvinciaAlbo, NumIscrizione, Confermato, CodiceConferma) VALUES
('dmrcld89s42g438s', 'claudia', 'di marco', 'acquaventina', 30, '65017', 
'clau@hotmail.it','claudim', 'Clau89', 'clau@dim.pec.it', 0, ' P', 5464, FALSE, 'm786f');

-- --------------------------------------------------------


--
-- Struttura della tabella `utente`
--

CREATE TABLE utente (
  CodFiscale varchar(16) NOT NULL,
  Nome varchar(20) NOT NULL,
  Cognome varchar(20) NOT NULL,
  Via varchar(30) NOT NULL,
  NumCivico smallint(6) DEFAULT NULL,
  CAP varchar(5) NOT NULL,
  Email varchar(320) NOT NULL,
  Username varchar(15) NOT NULL,
  Password varchar(10) NOT NULL,
  CodFiscaleMedico varchar(21) DEFAULT NULL,
  Confermato boolean DEFAULT FALSE,
  CodiceConferma varchar (255) NOT NULL,
  PRIMARY KEY (CodFiscale),
  UNIQUE (Email),
  UNIQUE (Username),
  UNIQUE (CodiceConferma),
  FOREIGN KEY (CodFiscaleMedico) REFERENCES medico (CodFiscale)
) ;

ALTER TABLE utente ADD FULLTEXT INDEX fullTextUsernameUtente(Username);
ALTER TABLE utente ADD FULLTEXT INDEX fullTextPasswordUtente(Password);
ALTER TABLE utente ADD FULLTEXT INDEX fullTextCodFiscaleUtente(CodFiscale);
--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO utente (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, Email,
 Username, Password, CodFiscaleMedico, Confermato, CodiceConferma) VALUES
('dmntnna89s42g438s', ' anna', ' di matteo', ' acquaventina', 30, '65017', ' annadima@alice.it', 'annadima' , 'Anna49', 'dmrcld89s42g438s', FALSE, 'u4728tdgd'),
('mntrcr89h21a488l', 'riccardo', 'mantini', 'del carmine', 31, '64034', 'onizuka-89@hotmail.it', 'ricman', 'Riccardo89', 'dmrcld89s42g438s', FALSE, 'sjsj474r8'),
('rndndt56s53t657o', 'rnd', 'ndt', 'bologna', 3, '64034', 'rnd@libero.it', 'rdnndt', 'Rndnd89', 'dmrcld89s42g438s', FALSE, 'jd784hfh58f');



--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE prenotazione (
  IDPrenotazione int(11) NOT NULL,
  IDEsame varchar(13) NOT NULL,
  PartitaIVAClinica varchar(20) NOT NULL,
  Tipo varchar(1) NOT NULL,
  Confermata tinyint(1) DEFAULT '0',
  Eseguita tinyint(1) DEFAULT '0',
  CodFiscaleUtenteEffettuaEsame varchar(16) NOT NULL,
  CodFiscaleMedicoPrenotaEsame varchar(16) DEFAULT NULL,
  CodFiscaleUtentePrenotaEsame varchar(16) DEFAULT NULL,
  DataEOra timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (IDPrenotazione, IDEsame, PartitaIVAClinica),
  FOREIGN KEY (IDEsame) REFERENCES esame (IDEsame),
  FOREIGN KEY (PartitaIVAClinica) REFERENCES clinica (PartitaIVA),
  FOREIGN KEY (CodFiscaleUtenteEffettuaEsame) REFERENCES utente (CodFiscale),
  FOREIGN KEY (CodFiscaleMedicoPrenotaEsame) REFERENCES medico (CodFiscale),
  FOREIGN KEY (CodFiscaleUtentePrenotaEsame) REFERENCES utente (CodFiscale)
);

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO prenotazione (IDPrenotazione, IDEsame, PartitaIVAClinica, Tipo, 
Confermata, Eseguita, CodFiscaleUtenteEffettuaEsame, CodFiscaleMedicoPrenotaEsame,
CodFiscaleUtentePrenotaEsame, DataEOra) VALUES
(1, 1, '12345', 'M', 0, 0, 'dmntnna89s42g438', 'dmrcld89s42g438s', NULL, '2016-04-26 09:25:54'),
(2, 1, '12345', 'M', 0, 0, 'mntrcr89h21a488l', 'dmrcld89s42g438s', NULL, '2016-04-27 15:03:40'),
(3, 2, '12346', 'U', 0, 0, 'mntrcr89h21a488l', NULL, 'mntrcr89h21a488l', '2016-04-29 12:00:00'),
(5, 2, '12345', 'U', 1, 0, 'rndndt56s53t657o', NULL, 'rndndt56s53t657o', '2016-04-28 08:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `referto`
--

CREATE TABLE referto (
  IDReferto int(11) NOT NULL,
  IDPrenotazione int(11) DEFAULT NULL,
  IDEsame varchar(13) DEFAULT NULL,
  PartitaIVAClinica varchar(20) DEFAULT NULL,
  Contenuto longblob NOT NULL,
  MedicoReferto varchar(40) NOT NULL,
  DataReferto date NOT NULL,
  PRIMARY KEY (IDReferto),
  FOREIGN KEY (IDPrenotazione) REFERENCES prenotazione (IDPrenotazione),
  FOREIGN KEY (IDEsame) REFERENCES esame (IDEsame),
  FOREIGN KEY (PartitaIVAClinica) REFERENCES clinica (PartitaIVA)
);



--
-- Dump dei dati per la tabella `referto`
--

INSERT INTO referto (IDReferto, IDPrenotazione, IDEsame, PartitaIVAClinica, 
Contenuto, MedicoReferto, DataReferto) VALUES
(1, 1, 1, '12345', 0x696c207265666572746f20, 'Riga', '2016-04-26');

-- --------------------------------------------------------







