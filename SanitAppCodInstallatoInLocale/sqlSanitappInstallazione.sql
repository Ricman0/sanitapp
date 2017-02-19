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

-- --------------------------------------------------------

--
-- Struttura della tabella `categoria`
--


CREATE TABLE categoria (
  Nome varchar(30) NOT NULL,
  PRIMARY KEY (Nome)
);

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
  FOREIGN KEY (Username) REFERENCES appuser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);



ALTER TABLE clinica ADD FULLTEXT INDEX fullTextNomeClinica(NomeClinica);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextLocalitaClinica(Localita);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextProvinciaClinica(Provincia);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextRegioneClinica(Regione);
ALTER TABLE clinica ADD FULLTEXT INDEX fullTextCAPClinica(CAP);



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
  FOREIGN KEY (Username) REFERENCES appuser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);

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
  FOREIGN KEY (Username) REFERENCES appuser (Username) ON DELETE CASCADE ON UPDATE CASCADE
);


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
  FOREIGN KEY (Username) REFERENCES appuser (Username) ON DELETE CASCADE ON UPDATE CASCADE
) ;


ALTER TABLE utente ADD FULLTEXT INDEX fullTextCodFiscaleUtente(CodFiscale);


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

