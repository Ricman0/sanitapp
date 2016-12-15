<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EMedico
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EMedico extends EUser {
    //attributi della classe EMedico

    /**
     * @var string $_codFiscale Il codice fiscale del medico
     */
    private $_codFiscale;

    /**
     * @var string $_nome Il nome del medico
     */
    private $_nome;

    /**
     * @var string $_cognome Il cognome del medico
     */
    private $_cognome;

    /**
     * @var string $_via La via in cui ha ... il medico
     */
    private $_via;

    /**
     * @var  int $_numeroCivico Numero civico del medico
     */
    private $_numeroCivico;

    /**
     * @var  string $_CAP CAP della città o paese in cui si trova il medico
     */
    private $_CAP;


    /**
     * @var boolean $_validato Indica se il medico è stato validato dal amministratore
     */
    private $_validato;

    /**
     * @var string $_provinciaAlbo Indica la provincia in cui il medico è iscritto all'albo
     */
    private $_provinciaAlbo;

    /**
     * @var string $_numIscrizione Indica il numero di iscrizione del medico nell'albo
     */
    private $_numIscrizione;

    /**
     * Costruttore della classe EMedico
     * @param string $cf Il codice fiscale del medico
     * @param string $username Username dell'utente medico
     * @param string $nome Il nome del medico
     * @param string $cognome Il cognome del medico
     * @param string $via La via in cui risiede il medico
     * @param string $cap Il cap del paese in cui risiede il medico
     * @param string $email L'email del medico
     * @param string $password La password del medico
     * @param string $PEC La PEC del medico
     * @param string $provinciaAlbo La provincia dell'albo in cui il medico è iscritto
     * @param string o int? $numIscrizione Il numero di iscrizione nell'albo del medico
     * @param int o string? $cod Il codice per confermare l'account
     * @throws XMedicoException Se il medico relativo al codice fiscale immesso non esiste
     */
    public function __construct($cf = NULL, $username=NULL, $nome='', $cognome='', $via='', $numeroCivico='', $cap='', $email='', $password='',  $provinciaAlbo='', $numIscrizione='') 
    {
        if ($cf === NULL || $username === NULL) 
        {
            $fMedico = USingleton::getInstance('FMedico');
            if ($cf === NULL && $username !== NULL) 
            {
                //caso in cui possiedo l'username ma non il codice fiscale
//            $sessione = USingleton::getInstance('USession');
//            $username = $sessione->leggiVariabileSessione('usernameLogIn');

                $attributiMedico = $fMedico->cercaMedico($username);
            } 
            //elseif ($cf !== NULL && $username === NULL) {
            else{  
            //caso in cui possiedo il codice fiscale ma non l'username 
                $attributiMedico = $fMedico->cercaMedicoByCF($cf);

            }
            if (is_array($attributiMedico) && count($attributiMedico) === 1) 
            {
                // esiste quell'utente
                parent::setUsername($attributiMedico[0]['Username']);
                parent::setPassword($attributiMedico[0]['Password']);
                parent::setEmail($attributiMedico[0]['Email']);                
                parent::setPEC($attributiMedico[0]['PEC']);
                parent::setConfermato($attributiMedico[0]['Confermato']);
                parent::setCodiceConfermaUtente($attributiMedico[0]['CodiceConferma']);
                parent::setTipoUser($attributiMedico[0]['TipoUser']);
                $this->setNomeMedico($attributiMedico[0]['Nome']);
                $this->setCognomeMedico($attributiMedico[0]['Cognome']);
                $this->setCodiceFiscaleMedico($attributiMedico[0]['CodFiscale']);
                $this->setViaMedico($attributiMedico[0]['Via']);
                $this->setNumCivicoMedico($attributiMedico[0]['NumCivico']);
                $this->setCAPMedico($attributiMedico[0]['CAP']);
                $this->setProvinciaAlboMedico($attributiMedico[0]['ProvinciaAlbo']);
                $this->setnumIscrizioneMedico($attributiMedico[0]['NumIscrizione']);
            } 
            else {
                //il medico cercato non esiste 
                throw new XMedicoException('Medico inesistente');
            }
        } else {
            // caso in cui gli passo tutti i parametri
            // richiamo il costruttore padre

            parent::__construct($username, $password, $email, $PEC);
            $this->_nome = $nome;
            $this->_cognome = $cognome;
            $this->_codFiscale = $cf;
            $this->_via = $via;
            if (isset($numeroCivico)) {
                $this->_numeroCivico = $numeroCivico;
            } else {
                $this->_numeroCivico = NULL;
            }

            $this->_CAP = $cap;
            $this->_provinciaAlbo = $provinciaAlbo;
            $this->_numIscrizione = $numIscrizione;
        }
    }

    //metodi get
    /**
     * Metodo per conoscere il nome del medico
     * 
     * @return string Il nome del medico
     */
    public function getNomeMedico() {
        return ucwords($this->_nome); // imposta la lettera  maiuscola a tutte le parole
    }

    /**
     * Metodo per conoscere il cognome del medico
     * 
     * @return string Il cognome del medico
     */
    public function getCognomeMedico() {
        return ucwords($this->_cognome);
    }

    /**
     * Metodo per conoscere il codice fiscale del medico
     * 
     * @return string Il codice fiscale del medico
     */
    public function getCodiceFiscaleMedico() {
        return $this->_codFiscale;
    }

    /**
     * Metodo per conoscere la via in cui risiede il medico
     * 
     * @return string Il nome della via in cui risiede il medico
     */
    public function getViaMedico() {
        return ucwords($this->_via);
    }

    /**
     * Metodo per conoscere il numero civico della via in cui risiede il medico
     * 
     * @return int Il numero civico della via in cui risiede il  medico
     */
    public function getNumCivicoMedico() {
        return $this->_numeroCivico;
    }

    /**
     * Metodo per conoscere il cap del paese in cui risiede il medico
     * 
     * @return int Il cap del paese in cui risiede il medico
     */
    public function getCAPMedico() {
        return $this->_CAP;
    }

    

    /**
     * Metodo per conoscere se il medico è stato validato 
     * 
     * @return boolean True se il medico è stato validato, False altrimenti
     */
    public function getValidatoMedico() {
        return $this->_validato;
    }

    /**
     * Metodo per conoscere il numero d'iscrizione del medico all'albo
     * 
     * @return string Il numero d'iscrizione del medico all'albo
     */
    public function getNumIscrizioneMedico() {
        return $this->_numIscrizione;
    }

    /**
     * Metodo per conoscere la provincia dell'albo a cui è iscritto il medico
     * 
     * @return string La provincia dell'albo a cui è iscritto il medico
     */
    public function getProvinciaAlboMedico() {
        return $this->_provinciaAlbo;
    }

    //metodi set

    /**
     * Metodo che permette di modificare il nome del medico
     * 
     * @param string $nome Il nome del medico
     */
    public function setNomeMedico($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome del medico
     * 
     * @param string $cognome Il cognome del medico
     */
    public function setCognomeMedico($cognome) {
        $this->_cognome = $cognome;
    }

    /**
     * Metodo che permette di modificare il codice fiscale del medico
     * 
     * @param string $codFiscale Il codice fiscale del medico
     */
    public function setCodiceFiscaleMedico($codFiscale) {
        $this->_codFiscale = $codFiscale;
    }

    /**
     * Metodo che permette di modificare la via del medico
     * 
     * @param string $via La nuova via del medico
     */
    public function setViaMedico($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare il numero civico del medico
     * 
     * @param int $numCiv Il nuovo numero civico del medico
     */
    public function setNumCivicoMedico($numCiv) {
        $this->_numeroCivico = $numCiv;
    }

    /**
     * Metodo che permette di modificare il CAP del medico
     * 
     * @param int $cap Il nuovo CAP del medico
     */
    public function setCAPMedico($cap) {
        $this->_CAP = $cap;
    }


    /**
     * Metodo che permette di modificare la validità del medico 
     * 
     * @param boolean $validato True se il medico è stato validato, False altrimenti
     */
    public function setValidatoMedico($validato) {
        $this->_validato = $validato;
    }

    /**
     * Metodo che permette di modificare il numero d'iscrizione del medico all'albo
     * 
     * @param string $numIscrizione Il numero d'iscrizione del medico all'albo
     */
    public function setnumIscrizioneMedico($numIscrizione) {
        $this->_numIscrizione = $numIscrizione;
    }

    /**
     * Metodo che permette di modificare la provincia dell'albo a cui è iscritto il medico
     * 
     * @param string $provinciaAlbo La provincia dell'albo a cui è iscritto il medico
     */
    public function setProvinciaAlboMedico($provinciaAlbo) {
        $this->_provinciaAlbo = $provinciaAlbo;
    }
    
    
    /**
     * Permette di trovare tutti i pazienti del medico
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return array|string Tutti i pazienti del medico se ci sono, altrimenti un messaggio 
     */
    public function cercaPazienti() 
    {
        $fMedico = USingleton::getInstance("FMedico");
        $pazienti = $fMedico->cercaPazienti(parent::getUsername());
        return $pazienti;                     
        
    }
    
   /**
     * Permette di trovare tutti i referti dei pazienti del medico
     * @throws XDBException Se la query per recuperare i referti non è stata eseguita con successo
     * @return array|boolean Tutti i referti dei oazienti del medico se ci sono
     */
    public function cercaReferti() {
        
        $fReferto = USingleton::getInstance("FReferto");
        return $fReferto->cercaRefertiPazientiMedico($this->_codFiscale);
        
    }
    
    /**
     * Metodo che consente di cercare tutte le prenotazioni che il medico ha effettuato
     * 
     * @access public
     * @return Array Un array contenente tutte le prenotazioni del medico
     */
    public function cercaPrenotazioni() 
    {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        return $fPrenotazioni->cercaPrenotazioniMedico($this->_codFiscale);
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EMedico nel DB
     * 
     * @access public
     * @return string|Boolean Il codice di conferma se il medico è stato inserito correttamente, altrimenti FALSE (il medico non è stato inserito correttamente nel DB)
     */
    public function inserisciMedicoDB() {
        //crea un oggetto fMedico se non è esistente, si collega al DB e lo inserisce
        $fMedico = USingleton::getInstance('FMedico');
        if ($fMedico->inserisciMedico($this) === TRUE) {
            return parent::getCodiceConferma();
        } 
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Metodo che permette di modificare l'indirizzo, numero civico e CAP (la modifica avviene anche nel DB)
     * 
     * @access public
     * @param Array $datiIndirizzoValidi Array contenente i valori di indirizzo, numero civico e CAP validi
     * @return boolean TRUE modifica effettuata, FALSE altrimenti
     */
    public function modificaIndirizzoCAP($datiIndirizzoValidi) 
    {
        $this->setViaMedico($datiIndirizzoValidi['Via']);
        $this->setNumCivicoMedico($datiIndirizzoValidi['NumCivico']);
        $this->setCAPMedico($datiIndirizzoValidi['CAP']);
        $fMedico = USingleton::getInstance('FMedico');
        return $fMedico->modificaIndirizzoCAP($this->getCodiceFiscaleMedico(), $this->getViaMedico(), $this->getNumCivicoMedico(),  $this->getCAPMedico());
    }

}
