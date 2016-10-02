<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * descrizione di Eclinica
 * 
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EClinica 
{
    /*
     * Attributi della classe EClinica
     */
    
    /**
     * @var string $_codiceConferma, variabile che contiente il codice per confermare 
     * l'account della clinica
     */
    private $_codiceConferma; 
    
    /**
     * @var string $_partitaIVA PartitaIVA della clinica
     */
    private $_partitaIVA;
    /**
     * @var string $_nomeClinica Nome della clinica
     */
    private $_nomeClinica;
    /**
     * @var string $_titolareClinica Titolare della clinica
     */
    private $_titolareClinica;
    /**
     * @var string $_via La via in cui è collocata la clinica
     */
    private $_via;
    /**
     * @var  int $_numeroCivico Numero civico della clinica
     */
    private $_numeroCivico;
    /**
     * @var  string $_CAP CAP della città o paese in cui si trova la clinica
     */
    private $_CAP;
    /**
     * @var  string $_località Città o paese in cui si trova la clinica
     */
    private $_località;
    /**
     * @var  string $_provincia Provincia della città o paese in cui si trova la clinica
     */
    private $_provincia;
    /**
     * @var  string $_regione regione della città o paese in cui si trova la clinica
     */
    private $_regione;
    /**
     * @var string $_email L'email della clinica
     */
    private $_email;
    /**
     * @var string $_PEC L'indizzo email certificato della clinica
     */
    private $_PEC;
    /**
     * @var string $_username Username scelto e usato dalla clinica per accedere al sistema
     */
    private $_username;
    /**
     * @var string $_password Password scelta e usata dalla clinica per accedere al sistema
     */
    private $_password;
    /**
     * @var string $_telefono Telefono della clinica
     */
    private $_telefono;
    /**
     * @var int $_capitaleSoociale Capitale sociale della clinica
     */
    private $_capitaleSociale;
    /**
     * @var datetime $_orarioAperturaAM Orario di apertura mattutina della clinica
     */
    private $_orarioAperturaAM;
    /**
     * @var datetime $_orarioChiusuraAM Orario di chiusura mattutina della clinica
     */
    private $_orarioChiusuraAM;
    /**
     * @var datetime $_orarioAperturaPM Orario di apertura pomeridiano della clinica
     */
    private $_orarioAperturaPM;
    /**
     * @var datetime $_orarioChiusuraPM Orario di chiusura pomeridiano della clinica
     */
    private $_orarioChiusuraPM;
    /**
     * @var boolean $_orarioContinuato Indica se la clinica effettua orario continuato 
     */
    private $_orarioContinuato;
    
    /**
     * @var string $_confermato permette di capire se l'account della clinica è 
     * stato confermato(TRUE) o meno          
     */
    private $_confermato;
    
    /**
     * @var Array(EEsame) $_esami array che contiente gli esami/servizi che la clinica fornisce
     */
    private $_esami; 
    // costruttore
    
    /**
     * Costruttore della classe EClinica
     * 
     * @param string $nome Il nome del medico
     * @param string $cognome Il cognome del medico
     * @param string $cf Il codice fiscale del medico
     * @param string $via La via in cui risiede il medico
     * @param string $cap Il cap del paese in cui risiede il medico
     * @param string $località Città o paese in cui risiede la clinica
     * @param string $provincia Provincia della città o paese in cui risiede la clinica
     * @param string $regione Regione della città o paese in cui risiede la clinica
     * @param string $email L'email del medico
     * @param string $password La password del medico
     * @param string $PEC La PEC del medico
     * @param string $provinciaAlbo La provincia dell'albo in cui il medico è iscritto
     * @param string o int? $numIscrizione Il numero di iscrizione nell'albo del medico
     * @param int o string? $cod Il codice per confermare l'account
     * @param array $esami Array di esami/servizi che la clinica fornisce
     */
    public function __construct($partitaIVA, $nomeClinica, $titolareClinica, 
            $via, $numeroCivico=NULL, $cap,$località, $provincia, $regione, $email,$PEC, $username, $password, 
            $telefono, $capitaleSociale, $orarioAperturaAM , $orarioChiusuraAM,
            $orarioAperturaPM, $orarioChiusuraPM, $orarioContinuato, $cod, $esami=NULL) 
    {
        $this->_partitaIVA= $partitaIVA;
        $this->_nomeClinica = $nomeClinica;
        $this->_titolareClinica =$titolareClinica;
        $this->_via = $via;
        if(isset($numeroCivico))
        {
            $this->_numeroCivico = $numeroCivico; 
        }
        else
            {
                $this->_numeroCivico = NULL; 
            }
       
        $this->_CAP = $cap;
        $this->_località = $località;
        $this->_provincia = $provincia;
        $this->_regione = $regione;
        $this->_email = $email;
        $this->_PEC = $PEC;
        $this->_username = $username;
        $this->_password = $password;
        $this->_telefono = $telefono;
        if(isset($capitaleSociale))
        {
            $this->_capitaleSociale = $capitaleSociale; 
        }
        else
            {
                $this->_capitaleSociale= NULL; 
            }
        if(isset($orarioAperturaAM))
        {
            $this->_orarioAperturaAM = $orarioAperturaAM; 
        }
        else
            {
                $this->_orarioAperturaAM= NULL; 
            }
        if(isset($orarioChiusuraAM))
        {
            $this->_orarioChiusuraAM = $orarioChiusuraAM; 
        }
        else
            {
                $this->_orarioChiusuraAM = NULL; 
            }
        if(isset($orarioAperturaPM))
        {
            $this->_orarioAperturaPM = $orarioAperturaPM; 
        }
        else
            {
                $this->_orarioAperturaPM= NULL; 
            }
        if(isset($orarioChiusuraPM))
        {
            $this->_orarioChiusuraPM = $orarioChiusuraPM; 
        }
        else
            {
                $this->_orarioChiusuraPM= NULL; 
            }
        if(isset($orarioContinuato))
        {
            $this->_orarioContinuato = $orarioContinuato; 
        }
        else
            {
                $this->_orarioContinuato= FALSE; 
            }
        $this->_confermato = FALSE;
        $this->_codiceConferma = $cod;
        $this->_esami = Array();
        if(isset($esami))
        {
            $this->_esami = $esami; 
        }
        
    }
    
    // metodi get
    /**
     * Metodo per conoscere gli esami/servizi chev a clinica fornisce
     * 
     * @return Array Gli esami/servizi che la clinica forniscw
     */
    public function getEsamiClinica()
    {
        return $this->_esami;
    }
    
    /**
     * Metodo per conoscere il codice di conferma della clinica
     * 
     * @return int/string Il codice della clinica
     */
    public function getCodiceConfermaClinica()
    {
        return $this->_codiceConferma;
    }
    
    /**
     * Metodo che restituisce la partita IVA della clinica
     * 
     * @return string La partita IVA della clinica
     */
    public function getPartitaIVAClinica()
    {
        return $this->_partitaIVA;
    }
    
    /**
     * Metodo che restituisce il nome della clinica
     * 
     * @return string Il nome della clinica
     */
    public function getNomeClinica()
    {
        return $this->_nomeClinica;
    }
    
    /**
     * Metodo che restituisce il titolare della clinica
     * 
     * @return string Il titolare della clinica
     */
    public function getTitolareClinica()
    {
        return $this->_titolareClinica;
    }
            
    /**
     * Metodo che restituisce l'indirizzo in cui è collocata la clinica
     * 
     * @return string Il nome della via
     */
    public function getViaClinica()
    {
        return $this->_via;
    }
    
    /**
     * Metodo che restituisce il numero civico in cui è collocata la clinica
     * 
     * @return int Il numero civico della clinica
     */
    public function getNumeroCivicoClinica()
    {
        return $this->_numeroCivico;
    }
    
    /**
     * Metodo che restituisce il CAP della città o paese in cui è collocata la clinica
     * 
     * @return string Il CAP della città o paese della clinica
     */
    public function getCAPClinica()
    {
        return $this->_CAP;
    }
    
    /**
     * Metodo che restituisce la città o paese in cui è collocata la clinica
     * 
     * @return string La città o paese della clinica
     */
    public function getLocalitàClinica()
    {
        return $this->_località;
    }
    
    /**
     * Metodo che restituisce la provincia della città o paese in cui è collocata la clinica
     * 
     * @return string La provincia della città o paese della clinica
     */
    public function getProvinciaClinica()
    {
        return $this->_provincia;
    }
    
    /**
     * Metodo che restituisce la regione della città o paese in cui è collocata la clinica
     * 
     * @return string La regione della città o paese della clinica
     */
    public function getRegioneClinica()
    {
        return $this->_regione;
    }
    
    /**
     * Metodo che restituisce l'indirizzo email della clinica
     * 
     * @return string L'email della clinica
     */
    public function getEmailClinica()
    {
        return $this->_email;
    }
    
    /**
     * Metodo che restituisce l'indirizzo email certificato PEC della clinica
     * 
     * @return string L'indirizzo PEC della clinica
     */
    public function getPECClinica()
    {
        return $this->_PEC;
    }
    
    /**
     * Metodo che restituisce l'username scelto e utilizzato dalla clinica
     * 
     * @return string Username della clinica
     */
    public function getUsernameClinica()
    {
        return $this->_username;
    }
    
    /**
     * Metodo che restituisce la password scelta e utilizzata dalla clinica
     * 
     * @return string Password della clinica
     */
    public function getPasswordClinica()
    {
        return $this->_password;
    }
    
    /**
     * Metodo che restituisce il numero di telefono dalla clinica
     * 
     * @return string Il numero di telefono della clinica
     */
    public function getTelefonoClinica()
    {
        return $this->_telefono;
    }
    
    /**
     * Metodo che restituisce il capitale sociale della clinica
     * 
     * @return string Capitale sociale della clinica
     */
    public function getCapitaleSocialeClinica()
    {
        return $this->_capitaleSociale;
    }
    
    /**
     * Metodo che restituisce TRUE se la clinica effettua l'orario continuato,
     * FALSE altrimenti.
     * 
     * @return boolean 
     */
    public function getOrarioContinuatoClinica()
    {
        return $this->_orarioContinuato;
    }
    
    /**
     * Metodo che restituisce l'orario di apertura mattutino della clinica
     * 
     * @return datetime L'orario di apertura mattutino
     */
    public function getOrarioAperturaAMClinica()
    {
        return $this->_orarioAperturaAM;
    }
    
    /**
     * Metodo che restituisce l'orario di chiusura mattutino della clinica
     * 
     * @return datetime L'orario di chiusura mattutino
     */
    public function getOrarioChiusuraAMClinica()
    {
        return $this->_orarioChiusuraAM;
    }
    
    /**
     * Metodo che restituisce l'orario di apertura pomeridiano della clinica
     * 
     * @return datetime L'orario di apertura pomeridiano
     */
    public function getOrarioAperturaPMClinica()
    {
        return $this->_orarioAperturaPM;
    }
    
    /**
     * Metodo che restituisce l'orario di chiusura pomeridiano della clinica
     * 
     * @return datetime L'orario di chiusura pomeridiano
     */
    public function getOrarioChiusuraPMClinica()
    {
        return $this->_orarioChiusuraPM;
    }
    
    /**
     * Metodo che permette di capire se l'account è stato confermato o meno
     * 
     * @return boolean TRUE se l'account è stato confermato, FALSE altrimenti
     */
    public function getConfermatoClinica()
    {
        return $this->_confermato;
    }
    
    //metodi set
    
    /**
     * Metodo che imposta l'orario d'apertura mattutino della clinica
     * 
     * @param datatime L'orario d'apertuta mattutino
     */
    public function setOrarioAperturaAM($orarioAperturaAM)
    {
        $this->_orarioAperturaAM = $orarioAperturaAM;
    }
    
    /**
     * Metodo che imposta l'orario di chiusura mattutino della clinica
     * 
     * @param datatime L'orario di chiusura mattutino
     */
    public function setOrarioChiusuraAM($orarioChiusuraAM)
    {
        $this->_orarioChiusuraAM = $orarioChiusuraAM;
    }
    
    /**
     * Metodo che imposta l'orario d'apertura pomeridiano della clinica
     * 
     * @param datatime L'orario d'apertuta pomeridiamo
     */
    public function setOrarioAperturaPM($orarioAperturaPM)
    {
        $this->_orarioAperturaPM = $orarioAperturaPM;
    }
    
    /**
     * Metodo che imposta l'orario di chiusura pomeridiano della clinica
     * 
     * @param datatime L'orario di chiusura pomeridiano
     */
    public function setOrarioChiusuraPM($orarioChiusuraPM)
    {
        $this->_orarioChiusuraPM = $orarioChiusuraPM;
    }
    
    /**
     * Metodo che modifica se la clinica effettua o meno l'orario continuato.
     * 
     * @param boolean
     */
    public function setOrarioContinuato($orarioContinuato)
    {
        $this->_orarioContinuato = $orarioContinuato;
    }
    
    /**
     * Metodo che imposta il titolare della clinica
     * 
     * @param string Titolare della clinica
     */
    public function setTitolareClinica($titolare)
    {
        $this->_titolareClinica = $titolare;
    }
    
    /**
     * Metodo che imposta la via della clinica
     * 
     * @param string Via della clinica
     */
    public function setViaClinica($via)
    {
        $this->_via = $via;
    }
    
    /**
     * Metodo che imposta il numero civico della clinica
     * 
     * @param int Numero civico della clinica
     */
    public function setNumeroCivicoClinica($numCivico)
    {
        $this->_numeroCivico = $numCivico;
    }
    
    /**
     * Metodo che imposta il CAP della clinica
     * 
     * @param string CAP della clinica
     */
    public function setCAPClinica($cap)
    {
        $this->_CAP = $cap;
    }
    
    /**
     * Metodo che imposta la città o paese della clinica
     * 
     * @param string Località della clinica
     */
    public function setLocalitàClinica($località)
    {
        $this->_località = $località;
    }
    
    /**
     * Metodo che imposta la provincia della città o paese della clinica
     * 
     * @param string Provincia della clinica
     */
    public function setProvinciaClinica($provincia)
    {
        $this->_provincia = $provincia;
    }
    
    /**
     * Metodo che imposta la regione della città o paese della clinica
     * 
     * @param string Regione della clinica
     */
    public function setRegioneClinica($regione)
    {
        $this->_regione = $regione;
    }
    
    /**
     * Metodo che imposta l'email della clinica
     * 
     * @param string Email della clinica
     */
    public function setEmailClinica($email)
    {
        $this->_email = $email;
    }
    
    /**
     * Metodo che imposta la pec della clinica
     * 
     * @param string PEC della clinica
     */
    public function setPECClinica($pec)
    {
        $this->_PEC = $pec;
    }
    
    /**
     * Metodo che imposta la password della clinica
     * 
     * @param string Password della clinica
     */
    public function setPasswordClinica($pw)
    {
        $this->_password = $pw;
    }
    
    /**
     * Metodo che imposta il capitale sociale della clinica
     * 
     * @param string Capitale sociale della clinica
     */
    public function setCapitaleSocialeClinica($cp)
    {
        $this->_capitaleSociale = $cp;
    }
    
    /**
     * Metodo che imposta il telefono della clinica
     * 
     * @param string Telefono della clinica
     */
    public function setTelefonoClinica($tel)
    {
        $this->_telefono = $tel;
    }
    
    /**
     * Metodo che permette di impostare la conferma dell'account 
     * 
     * @param boolean $confermato Imposta la conferma dell'account 
     */
    public function setConfermatoClinica($confermato)
    {
        $this->_confermato= $confermato;
    }
    
    /**
     * Metodo che permette di modificare il codice di conferma della clinica
     * 
     * @param string o int? $cod Il nuovo codice per la conferma della clinica
     */
    public function setCodiceConfermaClinica($cod)
    {
        $this->_codiceConferma = $cod; 
    }
    
    /**
     * Metodo che permette di modificare gli esami/servizi che la clinica offre
     * 
     * @param Array $esami Esami/servizi della clinica
     */
    public function setEsamiClinica($esami)
    {
        $this->_esami = $esami; 
    }
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EClinica nel DB
     * 
     * @access public
     * @param EClinica $eClinica L'oggetto di tipo EClinica che si vuole memorizzare nel DB
     */
    public function inserisciClinicaDB($eClinica) 
    {
        //crea un oggetto fClinica se non è esistente, si collega al DB e lo inserisce
        $fClinica = USingleton::getInstance('FClinica');
        $fClinica->inserisciClinica($eClinica);
    }
}
?>