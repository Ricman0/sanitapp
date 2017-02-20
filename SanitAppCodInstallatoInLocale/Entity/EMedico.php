<?php

/**
 * La classe EMedico si occupa della gestione in ram dei medici.
 *
 * @package Entity
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
     * @var string $_via La via in cui ha residenza il medico
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
     * @var boolean $_validato Indica se il medico è stato validato dall' amministratore
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
     * @var array $_pazienti Array che contiene i pazienti del medico. 
     * Realizza l'aggregazione con la classe EUtente.
     */
    private $_pazienti;
    
    /**
     * @var array $_prenotazioni Array che contiene le prenotazione effettuate dal medico. 
     * Realizza aggregazione con la classe EUtente.
     */
    private $_prenotazioni;
    
    /**
     * @var array $_referti array(EReferto) che contiene i referti condivisi con il medico. 
     * Realizza l'aggregazione con la classe EReferto.
     */
    private $_referti;
    

    /**
     * Costruttore della classe EMedico.
     * 
     * @access public
     * @param string $cf Il codice fiscale del medico
     * @param string $username Username del medico
     * @param string $nome Il nome del medico
     * @param string $cognome Il cognome del medico
     * @param string $via La via in cui risiede il medico
     * @param int $numeroCivico Il numero civico in cui risiede il medico
     * @param string $cap Il cap del paese in cui risiede il medico
     * @param string $email L'email del medico
     * @param string $password La password del medico
     * @param string $PEC La PEC del medico
     * @param string $provinciaAlbo La provincia dell'albo in cui il medico è iscritto
     * @param string $numIscrizione Il numero di iscrizione nell'albo del medico
     * @param boolean $validato TRUE se il medico è validato, FALSE altrimenti
     * @throws XMedicoException Se il medico relativo al codice fiscale immesso non esiste
     */               
    public function __construct($cf = NULL, $username=NULL, $nome='', $cognome='', $via='', $numeroCivico='', $cap='', $email='', $password='', $PEC=NULL, $provinciaAlbo='', $numIscrizione='', $validato = FALSE) 
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
                $cf = strtoupper($cf);
                $attributiMedico = $fMedico->cercaMedicoByCF($cf);

            }
            if (is_array($attributiMedico) && count($attributiMedico) === 1) 
            {
                // esiste quell'utente
                parent::setUsername($attributiMedico[0]['Username']);
                parent::setPassword($attributiMedico[0]['Password']);
                parent::setEmail($attributiMedico[0]['Email']);                
                parent::setPEC($attributiMedico[0]['PEC']);
                parent::setBloccato($attributiMedico[0]['Bloccato']);
                parent::setConfermato($attributiMedico[0]['Confermato']);
                parent::setCodiceConfermaUser($attributiMedico[0]['CodiceConferma']);
                parent::setTipoUser($attributiMedico[0]['TipoUser']);
                $this->setNomeMedico($attributiMedico[0]['Nome']);
                $this->setCognomeMedico($attributiMedico[0]['Cognome']);
                $this->setCodiceFiscaleMedico($attributiMedico[0]['CodFiscale']);
                $this->setViaMedico($attributiMedico[0]['Via']);
                $this->setNumCivicoMedico($attributiMedico[0]['NumCivico']);
                $this->setCAPMedico($attributiMedico[0]['CAP']);
                $this->setProvinciaAlboMedico($attributiMedico[0]['ProvinciaAlbo']);
                $this->setnumIscrizioneMedico($attributiMedico[0]['NumIscrizione']);
                $this->setValidatoMedico($attributiMedico[0]['Validato']);
                $this->_pazienti = Array();
                $this->_prenotazioni = Array();
                $this->_referti = Array();
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
            $this->_codFiscale = strtoupper($cf);
            $this->_via = $via;
            if (isset($numeroCivico)) {
                $this->_numeroCivico = $numeroCivico;
            } else {
                $this->_numeroCivico = NULL;
            }
            $this->_CAP = $cap;
            $this->_provinciaAlbo = $provinciaAlbo;
            $this->_numIscrizione = $numIscrizione;
            $this->_validato = $validato;
            $this->_pazienti = Array();
            $this->_prenotazioni = Array();
            $this->_referti = Array();
            parent::setTipoUser('medico');
        }
    }

    //metodi get
    /**
     * Metodo per conoscere il nome del medico.
     * 
     * @access public
     * @return string Il nome del medico
     */
    public function getNomeMedico() {
        return ucwords($this->_nome); // imposta la lettera  maiuscola a tutte le parole
    }

    /**
     * Metodo per conoscere il cognome del medico.
     * 
     * @access public
     * @return string Il cognome del medico
     */
    public function getCognomeMedico() {
        return ucwords($this->_cognome);
    }

    /**
     * Metodo per conoscere il codice fiscale del medico.
     * 
     * @access public
     * @return string Il codice fiscale del medico
     */
    public function getCodFiscaleMedico() {
        return $this->_codFiscale;
    }

    /**
     * Metodo per conoscere la via in cui risiede il medico-
     * 
     * @access public
     * @return string Il nome della via in cui risiede il medico
     */
    public function getViaMedico() {
        return ucwords($this->_via);
    }

    /**
     * Metodo per conoscere il numero civico della via in cui risiede il medico.
     * 
     * @access public
     * @return int Il numero civico della via in cui risiede il  medico
     */
    public function getNumCivicoMedico() {
        return $this->_numeroCivico;
    }

    /**
     * Metodo per conoscere il cap del paese in cui risiede il medico.
     * 
     * @access public
     * @return int Il cap del paese in cui risiede il medico
     */
    public function getCAPMedico() {
        return $this->_CAP;
    }

    /**
     * Metodo per conoscere l'username del medico.
     * 
     * @access public
     * @return string L'username del medico
     */
    public function getUsernameMedico() {
        return parent::getUsernameUser();
    }
    

    /**
     * Metodo per conoscere se il medico è stato validato. 
     * 
     * @access public
     * @return boolean TRUE se il medico è stato validato, FALSE altrimenti
     */
    public function getValidatoMedico() {
        return $this->_validato;
    }

    /**
     * Metodo per conoscere il numero d'iscrizione del medico all'albo.
     * 
     * @access public
     * @return string Il numero d'iscrizione del medico all'albo
     */
    public function getNumIscrizioneMedico() {
        return $this->_numIscrizione;
    }

    /**
     * Metodo per conoscere i pazienti del medico.
     * 
     * @access public
     * @return array I pazienti del medico
     */
    public function getPazientiMedico() {
        return $this->_pazienti;
    }
    
    /**
     * Metodo per conoscere le prenotazioni effettuate dal medico per i pazienti.
     * 
     * @access public
     * @return array Le prenotazione del medico
     */
    public function getPrenotazioniMedico() {
        return $this->_prenotazioni;
    }
    
    /**
     * Metodo per conoscere la provincia dell'albo a cui è iscritto il medico.
     * 
     * @access public
     * @return string La provincia dell'albo a cui è iscritto il medico
     */
    public function getProvinciaAlboMedico() {
        return $this->_provinciaAlbo;
    }

    //metodi set

    /**
     * Metodo che permette di impostare i pazienti del medico.
     * 
     * @access public
     * @param array $pazienti Pazienti del medico
     */
    public function setPazientiMedico($pazienti) {
        $this->_pazienti = $pazienti;
    }
    
    /**
     * Metodo che permette di impostare le prenotazione prenotate dal medico.
     * 
     * @access public
     * @param array $prenotazioni Prenotazioni del medico
     */
    public function setPrenotazioniMedico($prenotazioni ) {
        $this->_pazienti = $prenotazioni ;
    }
    
    /**
     * Metodo che permette di modificare il nome del medico.
     * 
     * @access public
     * @param string $nome Il nome del medico
     */
    public function setNomeMedico($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome del medico.
     * 
     * @access public
     * @param string $cognome Il cognome del medico
     */
    public function setCognomeMedico($cognome) {
        $this->_cognome = $cognome;
    }

    /**
     * Metodo che permette di modificare il codice fiscale del medico.
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale del medico
     */
    public function setCodiceFiscaleMedico($codFiscale) {
        $this->_codFiscale = strtoupper($codFiscale);
    }

    /**
     * Metodo che permette di modificare la via del medico.
     * 
     * @access public
     * @param string $via La nuova via del medico
     */
    public function setViaMedico($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare il numero civico del medico.
     * 
     * @access public
     * @param int $numCiv Il nuovo numero civico del medico
     */
    public function setNumCivicoMedico($numCiv) {
        $this->_numeroCivico = $numCiv;
    }

    /**
     * Metodo che permette di modificare il CAP del medico.
     * 
     * @access public
     * @param int $cap Il nuovo CAP del medico
     */
    public function setCAPMedico($cap) {
        $this->_CAP = $cap;
    }


    /**
     * Metodo che permette di modificare la validità del medico. 
     * 
     * @access public
     * @param boolean $validato TRUE se il medico è stato validato, FALSE altrimenti
     */
    public function setValidatoMedico($validato) {
        $this->_validato = $validato;
    }

    /**
     * Metodo che permette di modificare il numero d'iscrizione del medico all'albo.
     * 
     * @access public
     * @param string $numIscrizione Il numero d'iscrizione del medico all'albo
     */
    public function setNumIscrizioneMedico($numIscrizione) {
        
        $this->_numIscrizione = $numIscrizione;
    }

    /**
     * Metodo che permette di modificare la provincia dell'albo a cui è iscritto il medico.
     * 
     * @access public
     * @param string $provinciaAlbo La provincia dell'albo a cui è iscritto il medico
     */
    public function setProvinciaAlboMedico($provinciaAlbo) {
        $this->_provinciaAlbo = $provinciaAlbo;
    }
    
    
    /**
     * Metodo che permette di trovare tutti i pazienti del medico.
     * 
     * @access public
     * @return array Tutti i pazienti del medico se ci sono, altrimenti lancia un'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPazienti() 
    {
        $fMedico = USingleton::getInstance("FMedico");
        $pazienti = $fMedico->cercaPazienti(parent::getUsernameUser());
        return $pazienti;                     
        
    }
    
   /**
     * Permette di trovare tutti i referti dei pazienti del medico.
     * 
     * @access public
     * @return array Tutti i referti dei oazienti del medico se ci sono
     * @throws XDBException Se la query per recuperare i referti non è stata eseguita con successo
     */
    public function cercaReferti() {
        
        $fReferto = USingleton::getInstance("FReferto");
        return $fReferto->cercaRefertiPazientiMedico($this->_codFiscale);
        
    }
    
    /**
     * Metodo che consente di cercare tutte le prenotazioni che il medico ha prenotato per i suoi pazienti.
     * 
     * @access public
     * @return array Un array contenente tutte le prenotazioni prenotate dal medico
     * @throws XDBException Se la query per la ricerca delle prenotazioni prenotate dal medico non è stata eseguita con successo
     */
    public function cercaPrenotazioni() 
    {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        return $fPrenotazioni->cercaPrenotazioniMedico($this->_codFiscale);
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EMedico nel DB.
     * 
     * @access public
     * @return string Il codice di conferma se il medico è stato inserito correttamente, altrimenti FALSE (il medico non è stato inserito correttamente nel DB) Lancia un'eccezione.
     * @throws XDBException Se la query non viene eseguita con successo.
     */
    public function inserisciMedicoDB() {
        //crea un oggetto fMedico se non è esistente, si collega al DB e lo inserisce
        $fMedico = USingleton::getInstance('FMedico');; 
        $fMedico->inserisci($this);
        return parent::getCodiceConfermaUser();
        
    }
    
    /**
     * Metodo che permette di modificare l'indirizzo, numero civico e CAP (la modifica avviene anche nel DB).
     * 
     * @access public
     * @param array $datiIndirizzoValidi Array contenente i valori di indirizzo, numero civico e CAP validi
     * @return boolean TRUE modifica effettuata, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non viene eseguita con successo
     */
    public function modificaIndirizzoCAP($datiIndirizzoValidi) 
    {
        $this->setViaMedico($datiIndirizzoValidi['Via']);
        $this->setNumCivicoMedico($datiIndirizzoValidi['NumCivico']);
        $this->setCAPMedico($datiIndirizzoValidi['CAP']);
        $fMedico = USingleton::getInstance('FMedico');
        $daModificare['Via']=$datiIndirizzoValidi['Via'];
        $daModificare['NumCivico']=$datiIndirizzoValidi['NumCivico'];
        $daModificare['CAP']=$datiIndirizzoValidi['CAP'];
        return $fMedico->update($this->getCodFiscaleMedico(), $daModificare); //modificaIndirizzoCAP
    }

    /**
     * Metodo che permette di modificare la provincia dell'albo in cui è 
     * iscritto il medico e il numero d'iscrizione all'albo nel DB. 
     * 
     * @access public
     * @param string $provincia La nuova provincia
     * @param string $numIscrizione  Il nuovo numero d'iscrizione 
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaProvAlboENumIscrizione($provincia, $numIscrizione) 
    {
        $this->setProvinciaAlboMedico($provincia);
        $this->setnumIscrizioneMedico($numIscrizione);
        $fMedico = USingleton::getInstance('FMedico');
        $daModificare['ProvinciaAlbo'] = $provincia;
        $daModificare['NumIscrizione'] = $numIscrizione;
        return $fMedico->update($this->getCodFiscaleMedico(), $daModificare); //modificaProvAlboENumIscrizione 
    }
    
    /**
     * Metodo che consente di modificare i dati del medico.
     * 
     * @access public
     * @param array $datiDaModificare I dati del medico da modificare
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaMedico($datiDaModificare) {
        foreach ($datiDaModificare as $key => $value) {
            switch ($key) {
                case 'username':
                    $this->setUsername($value);
                    break;
                case 'codiceConferma':
                    $this->setCodiceConfermaUser($value);
                    break;
                case 'confermato':
                    if($value === 'true')
                    {
                        $this->setConfermato(TRUE);
                    }
                    else 
                    {
                        $this->setConfermato('FALSE');
                    }
                    break;
                case 'validato':
                    if($value === 'true' )
                    {
                        $this->setValidatoMedico(TRUE);
                    }
                    else 
                    {
                        $this->setValidatoMedico('FALSE');
                    }
                    break;
                case 'bloccato':
                    if($value === 'true')
                        
                    {
                       $this->setBloccato(TRUE);
                    }
                    else
                    {
                        $this->setBloccato('FALSE');
                    }
                    break;
                case 'email':
                    $this->setEmail($value);
                    break;
                case 'codiceFiscale':
                    $this->setCodiceFiscaleMedico($value);
                    break;
                case 'nome':
                    $this->setNomeMedico($value);
                    break;
                case 'cognome':
                    $this->setCognomeMedico($value);
                    break;
                case 'via':
                    $this->setViaMedico($value);
                    break;
                case 'numeroCivico':
                    $this->setNumCivicoMedico($value);
                    break;
                case 'CAP':
                    $this->setCAPMedico($value);
                    break;
                case 'PEC':
                    $this->setPEC($value);
                    break;
                case 'provinciaAlbo':
                    $this->setProvinciaAlboMedico($value);
                    break;
                case 'numeroIscrizioneAlbo':
                    $this->setNumIscrizioneMedico($value);
                    break;
                case 'passwordMedico':
                    if(!empty($value))
                    {
                        $this->modificaPassword($value);
                    }
                    break;
                default:
                    break;
            }
        }
        $fMedico = USingleton::getInstance('FMedico');
        return $fMedico->modificaMedico($this);
    }
}
