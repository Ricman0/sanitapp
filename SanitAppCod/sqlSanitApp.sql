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
-- Struttura della tabella `user`
--

CREATE TABLE appUser (
  Username varchar(15) NOT NULL,
  Password varchar(10) NOT NULL,
  Email varchar(320) NOT NULL,
  PEC varchar(320) DEFAULT NULL,
  Bloccato boolean DEFAULT FALSE,
  Confermato boolean DEFAULT FALSE,
  CodiceConferma varchar (255) NOT NULL,
  TipoUser ENUM('utente', 'medico', 'clinica', 'amministratore') NOT NULL,
  PRIMARY KEY (Username),
  UNIQUE (Email),
  UNIQUE (PEC),
  UNIQUE (CodiceConferma)
) ;


ALTER TABLE appUser ADD FULLTEXT INDEX fullTextPassword(Password);

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO appUser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES 
('appi', 'Appig4', 'info@appignano.it', 'info@appignano.pec', FALSE, TRUE, 'ciidisjwhf', 'clinica'),
('bise', 'Bisenti5', 'info@bisenti.it',  'info@bisenti.pec', FALSE,TRUE, 'cjdjdhdhrf', 'clinica'),
('claudim', 'Clau89', 'claudimarco@homail.it', 'clau@dim.pec.it',FALSE,TRUE, 'cwjwjhrf', 'medico'),
('ricman', 'Riccardo89', 'onizuka-89@hotmail.it', NULL,FALSE,TRUE, 'cjdjdehahah', 'utente'),
('annadima', 'Anna49', 'annadima@alice.it',NULL,FALSE,TRUE, 'annasjdjdhdhrf', 'utente');

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
  Provincia varchar (22) NOT NULL,
  Regione varchar (20) NOT NULL,
  Username varchar(15) NOT NULL,
  Telefono int(10) DEFAULT NULL,
  CapitaleSociale int(11) DEFAULT NULL,
  WorkingPlan text DEFAULT NULL,
  PRIMARY KEY (PartitaIVA),
  FOREIGN KEY (Username) REFERENCES appUser (Username)
);



ALTER TABLE clinica ADD FULLTEXT INDEX fullTextNomeClinica(NomeClinica);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextLocalitàClinica(Località);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextProvinciaClinica(Provincia);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextRegioneClinica(Regione);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextCAPClinica(CAP);



--
-- Dump dei dati per la tabella `clinica`
--

INSERT INTO clinica (PartitaIVA, NomeClinica, Titolare, Via, NumCivico, CAP, Località,
Provincia, Regione, Username, Telefono, CapitaleSociale, WorkingPlan) VALUES
('12345', 'Appignano', 'Riccardo', 'Del Carmine', 2, '65017', 'Penne', 'Pescara', 'Abruzzo', 'appi',  0856478563, 10000,
 '{"Lunedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Martedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Mercoledi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Giovedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Venerdi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Sabato":null,"Domenica":null,"tempoLimite":""}'),
('12346', 'Bisenti', 'Lucio', 'Del Corso', 87, '65017','Penne', 'Pescara' , 'Abruzzo', 'bise', 8613, 123456780,   
'{"Lunedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Martedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Mercoledi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Giovedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Venerdi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Sabato":null,"Domenica":null,"tempoLimite":""}');

--
-- Struttura della tabella `amministratore`
--

CREATE TABLE amministratore (
  IdAmministratore int NOT NULL AUTO_INCREMENT,
  Username varchar(15) NOT NULL,
  Telefono int(10) DEFAULT NULL,
  Fax int(10) DEFAULT NULL,
  PRIMARY KEY (IdAmministratore),
  FOREIGN KEY (Username) REFERENCES appUser (Username)
);


-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE esame(
  IDEsame varchar(13) NOT NULL,
  NomeEsame varchar(50) NOT NULL,
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

ALTER TABLE esame ADD FULLTEXT INDEX fullTextEsame(NomeEsame);


--
-- Dump dei dati per la tabella `esame`
--

INSERT INTO esame (IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, 
NumPrestazioniSimultanee, NomeCategoria, PartitaIVAClinica) VALUES
(1, 'Raggi Braccio', 'Raggi al braccio', 30, '00:15:00', 'Riga', 1, 'Raggi', '12345'),
(2, 'Raggi Piede', 'Raggi al piede', 30, '00:15:00', 'Riga', 1, 'Raggi', '12345');

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
  Username varchar(15) NOT NULL,
  Validato tinyint(1) DEFAULT '0',
  ProvinciaAlbo varchar (22) NOT NULL,
  NumIscrizione smallint(6) NOT NULL,
  PRIMARY KEY (CodFiscale),
  FOREIGN KEY (Username) REFERENCES appUser (Username)
);



--
-- Dump dei dati per la tabella `medico`
--

INSERT INTO medico (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, Username,  Validato, ProvinciaAlbo, NumIscrizione) VALUES
('DMRCLD89S42G438S', 'Claudia', 'Di Marco', 'Acquaventina', 30, '65017', 'claudim', 0, 'PESCARA', 5464);

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
  Username varchar(15) NOT NULL,
  CodFiscaleMedico varchar(21) DEFAULT NULL,
  PRIMARY KEY (CodFiscale),
  FOREIGN KEY (CodFiscaleMedico) REFERENCES medico (CodFiscale),
  FOREIGN KEY (Username) REFERENCES appUser (Username)
) ;


ALTER TABLE utente ADD FULLTEXT INDEX fullTextCodFiscaleUtente(CodFiscale);

--
-- Dump dei dati per la tabella `utente`
--

INSERT INTO utente (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, 
 Username,  CodFiscaleMedico) VALUES
('DMTNNA89S42G438S', ' Anna', ' Di Matteo', ' Acquaventina', 30, '65017', 'annadima', 'DMRCLD89S42G438S'),
('MNTRCR89H21A488L', 'Riccardo', 'Mantini', 'Del Carmine', 31, '64034', 'ricman', 'DMRCLD89S42G438S');



--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE prenotazione (
  IDPrenotazione varchar(13) NOT NULL,
  IDEsame varchar(13) NOT NULL,
  PartitaIVAClinica varchar(20) NOT NULL,
  Tipo varchar(1) NOT NULL,
  Confermata tinyint(1) DEFAULT '0',
  Eseguita tinyint(1) DEFAULT '0',
  CodFiscaleUtenteEffettuaEsame varchar(16) NOT NULL,
  CodFiscaleMedicoPrenotaEsame varchar(16) DEFAULT NULL,
  CodFiscaleUtentePrenotaEsame varchar(16) DEFAULT NULL,
  DataEOra DATETIME NOT NULL,
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
(1, 1, '12345', 'M', 1, 1, 'DMTNNA89S42G438S', 'DMRCLD89S42G438S', NULL, '2016-10-17 09:30:00'),
(2, 1, '12345', 'M', 1, 1, 'MNTRCR89H21A488L', 'DMRCLD89S42G438S', NULL, '2016-10-17 10:00:00'),
(3, 2, '12346', 'U', 1, 1, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2016-11-29 12:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `referto`
--

CREATE TABLE referto (
  IDReferto varchar(13) NOT NULL,
  IDPrenotazione varchar(13) DEFAULT NULL,
  IDEsame varchar(13) DEFAULT NULL,
  PartitaIVAClinica varchar(20) DEFAULT NULL,
  FileName varchar(200) NOT NULL,
  Contenuto mediumblob  NOT NULL,
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
-- 
-- INSERT INTO referto (IDReferto, IDPrenotazione, IDEsame, PartitaIVAClinica, 
-- Contenuto, MedicoReferto, DataReferto) VALUES
-- (1, 1, 1, '12345', 0x696c207265666572746f20, 'Riga', '2016-04-26');

-- --------------------------------------------------------
