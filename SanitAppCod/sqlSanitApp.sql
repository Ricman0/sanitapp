/**
 * Author:  Claudia Di Marco & Riccardo Mantini
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

CREATE TABLE appuser (
  Username varchar(15) NOT NULL,
  Password varchar(60) NOT NULL,
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


ALTER TABLE appuser ADD FULLTEXT INDEX fullTextPassword(Password);

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO appuser (Username, Password, Email, PEC, Bloccato, Confermato, CodiceConferma, TipoUser) VALUES 
('appi', '$2y$10$f9a3b0SA9pGL4yeFQtQ3bODP0mIxtHeGuxgGNvOD08g2g2icazvSe', 'info@appignano.it', 'info@appignano.pec', FALSE, TRUE, 'bf145eb094228deba0b5048970afeb73', 'clinica'),
('bise', '$2y$10$SoZO7Cv6g/0AF.uoOR2PBOTdk2izK4IDPMu3UYMFh2iOiIIhCCdxe', 'info@bisenti.it',  'info@bisenti.pec', FALSE,TRUE, 'cjdjdhdhrf', 'clinica'),
('ricman', '$2y$10$DJX0Vb/mFUi64QMBFWIGlOZwgeXVipewdDbUjs8S4JcbaX6XfcLka', 'onizuka-89@hotmail.it', NULL, FALSE, TRUE, 'f79ebe26b19eb881a495490bbc314427', 'utente'),
('clau', '$2y$10$nbhhUPzHplLeALa0fehaVOxxplxAVkLiP6nCDvptlMgjVpxi0c7Ie', 'claudia.dimarco89@gmail.com', NULL, FALSE, FALSE, 'edbc6990b6c17ce9a0a15464030e5a26', 'utente'),
-- ('claudim', '$2y$10$tXDgXrJ8bw5zL0miqTle0.ji25mTIG.OvQ7NlnNLRzId4g8mrL2PC', 'claudimarco@hotmail.it', 'clau@dim.pec.it',FALSE,TRUE, 'cwjwjhrf', 'medico'),
-- ('ricman', '$2y$10$XPh.cbdQCFT.xNzZVYdUee/ofH1K8wDQkEj1VtCrQgY2sW8C0YHOW', 'onizuka-89@hotmail.it', NULL,FALSE,TRUE, 'cjdjdehahah', 'utente'),
('ricla', '$2y$10$PVNVAf5wFfLJSHB/PBv2COam15ec7HJ4OlSeMVTzvo6WxboR/SID6', 'mantini.riccardo@gmail.com', NULL,FALSE,TRUE, 'cjdjdehahag', 'amministratore'),
('claudim', '$2y$10$4A54BVonrOOOkM7O5SKWb.OaRUVW2EINjHuz6a5fD2OIDYn7t7eMW', 'claudimarco@hotmail.it', 'claudimarco@hotmail.it', FALSE, TRUE, '30c4c0a8eb9f1e5bed37984c53630b67', 'medico');
-- ('annadima', '$2y$10$q40th0aKO8zCM5yENXm2q.HNvhIAMf/9hLQUNRljgtGZp9ESUsI3m', 'annadima@alice.it',NULL,FALSE,TRUE, 'annasjdjdhdhrf', 'utente'),
-- ('annadimatteo', '$2y$10$q40th0aKO8zCM5yENXm2q.HNvhIAMf/9hLQUNRljgtGZp9ESUsI3m', 'annadima@aliceyjyjyjjg.it',NULL,FALSE,TRUE, 'annasjdjdhdhsjjsjjsrf', 'medico');

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
('Visita Preliminare'),
('Visita Specialistica'),
('Ecografia'),
('Screening'),
('Vaccino'),
('Prove allergiche'),
('Risonanza');

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
  Localita varchar (40) NOT NULL,
  Provincia varchar (22) NOT NULL,
  Regione varchar (20) NOT NULL,
  Username varchar(15) NOT NULL,
  Telefono varchar(10) DEFAULT NULL,
  CapitaleSociale int(11) DEFAULT NULL,
  WorkingPlan text DEFAULT NULL,
  Validato boolean DEFAULT FALSE,
  PRIMARY KEY (PartitaIVA),
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);



ALTER TABLE clinica ADD FULLTEXT INDEX fullTextNomeClinica(NomeClinica);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextLocalitaClinica(Localita);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextProvinciaClinica(Provincia);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextRegioneClinica(Regione);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextCAPClinica(CAP);



--
-- Dump dei dati per la tabella `clinica`
--

INSERT INTO clinica (PartitaIVA, NomeClinica, Titolare, Via, NumCivico, CAP, Localita,
Provincia, Regione, Username, Telefono, CapitaleSociale, WorkingPlan, Validato) VALUES
('01200304050', 'Appignano', 'Riccardo', 'Del Carmine', 2, '65017', 'Penne', 'Pescara', 'Abruzzo', 'appi',  '0851111111', 10000,
'{"Lunedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Martedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Mercoledi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Giovedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Venerdi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Sabato":null,"Domenica":null,"tempoLimite":""}', TRUE),
('00123004600', 'Bisenti', 'Lucio', 'Del Corso', 87, '65017','Penne', 'Pescara' , 'Abruzzo', 'bise', '0852222222', 126780,   
'{"Lunedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Martedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Mercoledi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Giovedi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Venerdi":{"Start":"09:00","End":"18:00","BreakStart":"13:00","BreakEnd":"14:00"},"Sabato":null,"Domenica":null,"tempoLimite":""}',TRUE);

--
-- Struttura della tabella `amministratore`
--

CREATE TABLE amministratore (
  IdAmministratore int NOT NULL AUTO_INCREMENT,
  Username varchar(15) NOT NULL,
  Nome varchar(20) NOT NULL,
  Cognome varchar(20) NOT NULL,
  Telefono varchar(10) DEFAULT NULL,
  PRIMARY KEY (IdAmministratore),
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO amministratore (IdAmministratore, Username, Nome, Cognome, Telefono) VALUES (NULL, 'ricla', 'Riccardo', 'Claudia', '0858279642');

-- --------------------------------------------------------

--
-- Struttura della tabella `esame`
--

CREATE TABLE esame(
  IDEsame varchar(24) NOT NULL,
  NomeEsame varchar(50) NOT NULL,
  Descrizione varchar(600) DEFAULT NULL,
  Prezzo float NOT NULL,
  Durata time NOT NULL,
  MedicoEsame varchar(40) NOT NULL,
  NumPrestazioniSimultanee smallint(6) NOT NULL,
  NomeCategoria varchar(30) NOT NULL,
  PartitaIVAClinica varchar(11) NOT NULL,
  Eliminato boolean DEFAULT FALSE,
  PRIMARY KEY (IDEsame),
  FOREIGN KEY (PartitaIVAClinica) REFERENCES clinica (PartitaIVA),
  FOREIGN KEY (NomeCategoria) REFERENCES categoria (Nome) ON DELETE NO ACTION ON UPDATE CASCADE

);

ALTER TABLE esame ADD FULLTEXT INDEX fullTextEsame(NomeEsame);


--
-- Dump dei dati per la tabella `esame`
--

INSERT INTO esame (IDEsame, NomeEsame, Descrizione, Prezzo, Durata, MedicoEsame, 
NumPrestazioniSimultanee, NomeCategoria, PartitaIVAClinica, Eliminato) VALUES
('0120030405058a33077a8a99', 'Raggi Braccio', 'Raggi al braccio', 30, '00:15:00', 'Riga', 1, 'Raggi', '01200304050', FALSE),
('0120030405058a2bdb2a242f', 'Analisi del sangue', 'Analisi del sangue', 34, '00:15:00', 'Licia Verdi', 1, 'Analisi', '01200304050', FALSE),
('0120030405058a2e69645366', 'Ecografia Addome', 'L’ecografia addome completo/addominale è una metodica diagnostica non invasiva che, utilizzando gli ultrasuoni emessi da una sonda appoggiata sulla pelle del paziente, consente di visualizzare e studiare tutti gli organi dell’addomee i principali vasi sanguigni che si trovano nella cavità addominale.', 45, '00:45:00', 'Luigi Neri', 1, 'Ecografia', '01200304050', FALSE),
('0120030405058a4ccf59b242', 'Raggi Piede', 'Raggi al piede', 30, '00:15:00', 'Riga', 1, 'Raggi', '01200304050', FALSE),
('0120030405058a4ccf59b247', 'Vaccino Meningococco', 'Vaccino per la meningite di tipo C.', 40, '00:10:00', 'Rita Nervo' ,1, 'Vaccino', '01200304050', FALSE);

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
  ProvinciaAlbo varchar (22) NOT NULL,
  NumIscrizione varchar(6) NOT NULL,
  Validato boolean DEFAULT FALSE,
  PRIMARY KEY (CodFiscale),
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);



--
-- Dump dei dati per la tabella `medico`
--

INSERT INTO medico (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, Username, ProvinciaAlbo, NumIscrizione, Validato) VALUES
('DMRCLD89S42G438S', 'Claudia', 'Di Marco', 'Via Acquaventina', 31, '65017', 'claudim', 'PESCARA', '123456', TRUE); 
-- ('DMRCLD89S42G438S', 'Claudia', 'Di Marco', 'Via Acquaventina', 30, '65017', 'claudim','PESCARA', 546474, TRUE),
-- ('DMTNNA89S42G438S', 'Anna', 'Di Matteo', 'Via Acquaventina', 30, '65017', 'annadimatteo','PESCARA', 546064, TRUE);

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
  FOREIGN KEY (CodFiscaleMedico) REFERENCES medico (CodFiscale) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE ON UPDATE CASCADE
) ;


ALTER TABLE utente ADD FULLTEXT INDEX fullTextCodFiscaleUtente(CodFiscale);

--
-- Dump dei dati per la tabella `utente`
--

 INSERT INTO utente (CodFiscale, Nome, Cognome, Via, NumCivico, CAP, 
  Username,  CodFiscaleMedico) VALUES
('MNTRCR89H21A488L', 'Riccardo', 'Mantini', 'Via Del Carmine', 31, '64034', 'ricman', 'DMRCLD89S42G438S'),
('DMRCLD89S42G438S', 'Claudia', 'Di Marco', 'Via Acquaventina', 30, '65017', 'clau', 'DMRCLD89S42G438S');
-- ('DMTNNA89S42G438S', ' Anna', ' Di Matteo', ' Acquaventina', 30, '65017', 'annadima', 'DMRCLD89S42G438S'),
-- ('MNTRCR89H21A488L', 'Riccardo', 'Mantini', 'Del Carmine', 31, '64034', 'ricman', 'DMRCLD89S42G438S');



--
-- Struttura della tabella `prenotazione`
--

CREATE TABLE prenotazione (
  IDPrenotazione varchar(37) NOT NULL,
  IDEsame varchar(24) NOT NULL,
  Tipo varchar(1) NOT NULL,
  Confermata boolean DEFAULT FALSE,
  Eseguita boolean DEFAULT FALSE,
  CodFiscaleUtenteEffettuaEsame varchar(16) NOT NULL,
  CodFiscaleMedicoPrenotaEsame varchar(16) DEFAULT NULL,
  CodFiscaleUtentePrenotaEsame varchar(16) DEFAULT NULL,
  DataEOra DATETIME NOT NULL,
  PRIMARY KEY (IDPrenotazione),
  FOREIGN KEY (IDEsame) REFERENCES esame (IDEsame) ON UPDATE CASCADE,
  FOREIGN KEY (CodFiscaleUtenteEffettuaEsame) REFERENCES utente (CodFiscale) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (CodFiscaleMedicoPrenotaEsame) REFERENCES medico (CodFiscale) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (CodFiscaleUtentePrenotaEsame) REFERENCES utente (CodFiscale) ON DELETE SET NULL ON UPDATE CASCADE
);

--
-- Dump dei dati per la tabella `prenotazione`
--

INSERT INTO prenotazione (IDPrenotazione, IDEsame, Tipo, 
Confermata, Eseguita, CodFiscaleUtenteEffettuaEsame, CodFiscaleMedicoPrenotaEsame,
CodFiscaleUtentePrenotaEsame, DataEOra) VALUES
('0120030405058a4ccf59b24758a6c74c84b01', '0120030405058a4ccf59b247', 'U', TRUE, FALSE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-17 09:00:00'),
('0120030405058a4ccf59b24758a6c74c84b51', '0120030405058a4ccf59b247', 'U', TRUE, FALSE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-28 09:00:00');
-- (2, '1234558a33077a8a99', 'M', TRUE, TRUE, 'MNTRCR89H21A488L', 'DMRCLD89S42G438S', NULL, '2016-10-17 10:00:00'),
-- (4, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-01-23 12:00:00'),
-- (3, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2016-11-29 12:00:00'),
-- (5, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-01 16:00:00'),
-- (6, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-01 12:00:00'),
-- (7, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-02 12:00:00'),
-- (8, 2, 'U', TRUE, TRUE, 'MNTRCR89H21A488L', NULL, 'MNTRCR89H21A488L', '2017-02-03 12:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `referto`
--

CREATE TABLE referto (
  IDReferto varchar(37) NOT NULL,
  IDPrenotazione varchar(37) DEFAULT NULL,
  FileName varchar(200) NOT NULL,
  Contenuto mediumblob  NOT NULL,
  MedicoReferto varchar(40) NOT NULL,
  DataReferto date NOT NULL,
  CondivisoConMedico boolean DEFAULT FALSE,
  CondivisoConUtente text DEFAULT NULL,
  PRIMARY KEY (IDReferto),
  FOREIGN KEY (IDPrenotazione) REFERENCES prenotazione (IDPrenotazione) ON DELETE CASCADE ON UPDATE CASCADE
);



--
-- Dump dei dati per la tabella `referto`
--
-- 
-- INSERT INTO referto (IDReferto, IDPrenotazione, 
-- Contenuto, MedicoReferto, DataReferto) VALUES
-- (1, 1, 1, '12345', 0x696c207265666572746f20, 'Riga', '2016-04-26');

-- --------------------------------------------------------
