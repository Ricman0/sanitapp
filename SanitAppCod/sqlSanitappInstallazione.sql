/**
 * Author:  Claudia Di Marco & Riccardo Mantini
 * Created: 2-gen-2017
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
  Localita varchar (40) NOT NULL,
  Provincia varchar (22) NOT NULL,
  Regione varchar (20) NOT NULL,
  Username varchar(15) NOT NULL,
  Telefono varchar(10) DEFAULT NULL,
  CapitaleSociale int(11) DEFAULT NULL,
  WorkingPlan text DEFAULT NULL,
  Validato boolean DEFAULT FALSE,
  PRIMARY KEY (PartitaIVA),
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE
);



ALTER TABLE clinica ADD FULLTEXT INDEX fullTextNomeClinica(NomeClinica);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextLocalitaClinica(Localita);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextProvinciaClinica(Provincia);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextRegioneClinica(Regione);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextCAPClinica(CAP);



--
-- Dump dei dati per la tabella `clinica`
--


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
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE
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
  FOREIGN KEY (NomeCategoria) REFERENCES categoria (Nome) ON DELETE NO ACTION

);

ALTER TABLE esame ADD FULLTEXT INDEX fullTextEsame(NomeEsame);


--
-- Dump dei dati per la tabella `esame`
--

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
  NumIscrizione smallint(6) NOT NULL,
  Validato boolean DEFAULT FALSE,
  PRIMARY KEY (CodFiscale),
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE
);



--
-- Dump dei dati per la tabella `medico`
--


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
  FOREIGN KEY (CodFiscaleMedico) REFERENCES medico (CodFiscale) ON DELETE SET NULL,
  FOREIGN KEY (Username) REFERENCES appUser (Username) ON DELETE CASCADE
) ;


ALTER TABLE utente ADD FULLTEXT INDEX fullTextCodFiscaleUtente(CodFiscale);

--
-- Dump dei dati per la tabella `utente`
--



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
  FOREIGN KEY (CodFiscaleUtenteEffettuaEsame) REFERENCES utente (CodFiscale) ON DELETE CASCADE,
  FOREIGN KEY (CodFiscaleMedicoPrenotaEsame) REFERENCES medico (CodFiscale) ON DELETE SET NULL,
  FOREIGN KEY (CodFiscaleUtentePrenotaEsame) REFERENCES utente (CodFiscale) ON DELETE SET NULL
);

--
-- Dump dei dati per la tabella `prenotazione`
--


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
  FOREIGN KEY (IDPrenotazione) REFERENCES prenotazione (IDPrenotazione) ON DELETE CASCADE,
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
