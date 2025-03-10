<?php

/**
 * La classe EUtente si occupa della gestione in ram dell'utente.
 *
 * @category Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EUtente extends EUser {

    /**
     * @var string $_nome, variabile di tipo string, che contiene il nome dell'utente
     */
    private $_nome;

    /**
     * @var string $_cognome, variabile di tipo string, che contiene il cognome dell'utente
     */
    private $_cognome;

    /**
     * @var string $_codFiscale, variabile di tipo string, che contiene il 
     *             codice fiscale dell'utente
     */
    private $_codFiscale;

    /**
     * @var string $_via, variabile di tipo string, che contiene l'indirizzo 
     *             in cui risiede l'utente
     */
    private $_via;

    /**
     * @var int $_numeroCivico, variabile di tipo intero, che contiene il numero
     *          civico in cui risiede l'utente
     */
    private $_numeroCivico;

    /**
     * @var string $_CAP, variabile che contiene il CAP in cui risiede l'utente
     */
    private $_CAP;

    /**
     * @var array $_prenotazioni array(EPrenotazione) che contiene le 
     * prenotazioni a nome dell'utente.Realizza l'aggregazione con la classe EPrenotazione.
     */
    private $_prenotazioni;
    
    /**
     * @var string $_medicoCurante, variabile che contiene il codice fiscale del medico curante dell'utente.
     * Realizza l'associazione 'cura' con la classe EMedico.
     */
    private $_medicoCurante;
    
    /**
     * @var array $_prenotazioniEffettuate array(EPrenotazione) che contiene le 
     * prenotazioni che l'utente ha prenotato. Realizza l'aggregazione con la classe EPrenotazione.
     */
    private $_prenotazioniEffettuate;
    
    /**
     * @var array $_referti array(EReferto) che contiene i referti dell'utente. 
     * Realizza l'aggregazione con la classe EReferto.
     */
    private $_referti;
	

    /**
     * Costruttore della classe EUtente.
     * 
     * @access public
     * @param string $cf Il codice fiscale dell'utente
     * @param string $username L'username dell'utente
     * @param string $password La password dell'utente
     * @param string $email L'email dell'utente
     * @param string $nome Il nome dell'utente
     * @param string $cognome Il cognome dell'utente
     * @param string $via La via in cui risiede l'utente
     * @param int $numeroCivico Il numero civico dell'utente
     * @param string $cap Il cap del paese in cui risiede l'utente
     * @param string $medico Il codice fiscale del medico curente dell'utente
     * @throws XUtenteException Se l'utente non esiste
     */
    public function __construct($cf = NULL, $username = NULL, $password = "", $email = "", $nome = "", $cognome = "", $via = "", $numeroCivico = "", $cap = "", $medico = NULL) {

        if ($cf === NULL || $username === NULL) 
        {
            $fUtente = USingleton::getInstance('FUtente');

            if ($cf === NULL && $username !== NULL) {
                //caso in cui possiedo l'username ma non il codice fiscale
                $attributiUtente = $fUtente->cercaUtente($username);
            } elseif ($cf !== NULL && $username === NULL) {
                $cf = strtoupper($cf);
                //caso in cui possiedo l'username ma non il codice fiscale
                $attributiUtente = $fUtente->cercaUtenteByCF($cf);
            }
            if (is_array($attributiUtente) && count($attributiUtente)===1) {
                // esiste quell'utente
                parent::setUsername($attributiUtente[0]['Username']);
                parent::setPassword($attributiUtente[0]['Password']);
                parent::setEmail($attributiUtente[0]['Email']);
                parent::setPEC($attributiUtente[0]['PEC']);
                parent::setBloccato($attributiUtente[0]['Bloccato']);
                parent::setConfermato($attributiUtente[0]['Confermato']);
                parent::setCodiceConfermaUser($attributiUtente[0]['CodiceConferma']);
                parent::setTipoUser($attributiUtente[0]['TipoUser']);
                $this->setNomeUtente($attributiUtente[0]['Nome']);
                $this->setCognomeUtente($attributiUtente[0]['Cognome']);
                $this->setCodiceFiscaleUtente($attributiUtente[0]['CodFiscale']);
                $this->setViaUtente($attributiUtente[0]['Via']);
                $this->setNumCivicoUtente($attributiUtente[0]['NumCivico']);
                $this->setCAPUtente($attributiUtente[0]['CAP']);
                $this->setMedicoCurante($attributiUtente[0]['CodFiscaleMedico']);
                $this->_prenotazioniEffettuate = Array();
                $this->_prenotazioni = Array();
                $this->_referti= Array();
            } 
            else 
            {
                // l'utente cercato non esiste 
                throw new XUtenteException('Utente non esistente');
            }
        } else 
            {
            // caso in cui gli passo tutti i parametri
            // richiamo il costruttore padre
            parent::__construct($username, $password, $email);
            
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
            $this->_prenotazioni = new ArrayObject(); 
            $this->_medicoCurante = $medico;
            parent::setTipoUser('utente');
            $this->_prenotazioniEffettuate = Array();
            $this->_prenotazioni = Array();
            $this->_referti= Array();
        }
    }

    //metodi get
    
    /**
     * Metodo per conoscere il nome dell'utente.
     * 
     * @access public
     * @return string Il nome dell'utente
     */
    public function getNomeUtente() {
        return ucwords($this->_nome);
    }

    /**
     * Metodo per conoscere il cognome dell'utente.
     * 
     * @access public
     * @return string Il cognome dell'utente
     */
    public function getCognomeUtente() {
        return ucwords($this->_cognome);
    }

    /**
     * Metodo per conoscere il codice fiscale dell'utente.
     * 
     * @access public
     * @return string Il codice fiscale dell'utente
     */
    public function getCodFiscaleUtente() {
        return $this->_codFiscale;
    }

    /**
     * Metodo per conoscere la via in cui risiede l'utente.
     * 
     * @access public
     * @return string Il nome della via in cui risiede l'utente
     */
    public function getViaUtente() {
        return ucwords($this->_via);
    }

    /**
     * Metodo per conoscere il numero civico della via in cui risiede l'utente
     * 
     * @access public
     * @return int Il numero civico della via in cui risiede l'utente
     */
    public function getNumCivicoUtente() {
        return $this->_numeroCivico;
    }

    /**
     * Metodo per conoscere il cap del paese in cui risiede l'utente.
     * 
     * @access public
     * @return string Il cap del paese in cui risiede l'utente
     */
    public function getCAPUtente() {
        return $this->_CAP;
    }

    /**
     * Metodo per conoscere l'username dell'utente.
     * 
     * @access public
     * @return string L'username dell'utente
     */
    public function getUsernameUtente() {
        return parent::getUsernameUser();
    }
    
    /**
     * Metodo per conoscere il codice fiscale del medico curante dell'utente.
     * 
     * @access public
     * @return string Il codice fiscale del medico curante dell'utente
     */
    public function getCodFiscaleMedicoUtente() {
        return $this->_medicoCurante;
    }

    /**
     * Metodo per conoscere le prenotazioni dell'utente.
     * 
     * @access public
     * @return array Le prenotazioni dell'utente
     */
    public function getPrenotazioniUtente() {
        return $this->_prenotazioni;
    }
    
    /**
     * Metodo per conoscere le prenotazioni prenotate dall'utente.
     * 
     * @access public
     * @return array Le prenotazioni prenotate dall'utente
     */
    public function getPrenotazioniEffettuateUtente() {
        return $this->_prenotazioniEffettuate;
    }

    //metodi set

    /**
     * Metodo che permette di modificare il nome dell'utente.
     * 
     * @access public
     * @param string $nome Il nome dell'utente
     */
    public function setNomeUtente($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome dell'utente.
     * 
     * @access public
     * @param string $cognome Il cognome dell'utente
     */
    public function setCognomeUtente($cognome) {
        $this->_cognome = $cognome;
    }

    /**
     * Metodo che permette di modificare il codice fiscale dell'utente.
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale dell'utente
     */
    public function setCodiceFiscaleUtente($codFiscale) {
        $this->_codFiscale = strtoupper($codFiscale);
    }

    /**
     * Metodo che permette di modificare l'email dell'utente.
     * 
     * @access public
     * @param string $email L'email dell'utente
     */
    public function setEmail($email) {
        parent::setEmail($email);
    }

    /**
     * Metodo che permette di modificare la via dell'utente.
     * 
     * @access public
     * @param string $via La nuova via dell'utente
     */
    public function setViaUtente($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare il numero civico dell'utente.
     * 
     * @access public
     * @param int $numCiv Il nuovo numero civico dell'utente
     */
    public function setNumCivicoUtente($numCiv) {
        $this->_numeroCivico = $numCiv;
    }

    /**
     * Metodo che permette di modificare il CAP dell'utente.
     * 
     * @access public
     * @param string $cap Il nuovo CAP dell'utente
     */
    public function setCAPUtente($cap) {
        $this->_CAP = $cap;
    }

    /**
     * Metodo che permette di modificare il codice fiscale del medico curante dell'utente.
     * 
     * @access public
     * @param string $medico Il codice fiscale del medico curante dell'utente
     */
    public function setMedicoCurante($medico) {
        $this->_medicoCurante = $medico;
    }
    
    /**
     * Metodo che permette di impostare le prenotazioni prenotate dall'utente.
     * 
     * @access public
     * @param array $prenotazioni Prenotazioni prenotate dall'utente
     */
    public function setPrenotazioniEffettuateUtente($prenotazioni ) {
        $this->_prenotazioniEffettuate = $prenotazioni ;
    }

    /**
     * Metodo che permette di impostare le prenotazioni dell'utente.
     * 
     * @access public
     * @param array $prenotazioni Prenotazioni dell'utente
     */
    public function setPrenotazioniUtente($prenotazioni ) {
        $this->_prenotazioni = $prenotazioni ;
    }
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EUtente nel DB.
     * 
     * @access public
     * @return string Il codice di conferma se l'utente è stato inserito correttamente, altrimenti lancia un'eccezione(l'utente  non è stato inserito correttamente nel DB)
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function inserisciUtenteDB() {
        //crea un oggetto fUtente se non è esistente, si collega al DB e lo inserisce
        $fUtente = USingleton::getInstance('FUtente');
        $fUtente->inserisci($this);
        return parent::getCodiceConfermaUser();  
    }

    /**
     * Metodo che consente di cercare tutte le prenotazioni dell'utente.
     * 
     * @access public
     * @return array Un array contenente tutte le prenotazione di un utente, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaPrenotazioni() {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $this->_prenotazioni = $fPrenotazioni->cercaPrenotazioni($this->_codFiscale);
        return $this->_prenotazioni;
    }

    /**
     * Metodo che consente di cercare tutti i referti di un utente.
     * 
     * @access public
     * @return array Un array contenente tutti i referti di un utente,  altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaReferti() 
    {
        $fReferti = USingleton::getInstance('FReferto');
        return $fReferti->cercaRefertiUtente($this->_codFiscale);
    }

    
    /**
     * Metodo che permette di modificare l'indirizzo, numero civico e CAP (la modifica avviene anche nel DB).
     * 
     * @access public
     * @param array $datiValidi Array contenente i valori di indirizzo, numero civico e CAP
     * @return boolean TRUE modifica effettuata, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function modificaIndirizzoCAP($datiValidi) 
    {
        $this->_via = $datiValidi['Via'];
        $this->_numeroCivico = $datiValidi['NumCivico'];
        $this->_CAP = $datiValidi['CAP'];
        $fUtente = USingleton::getInstance('FUtente');
        $daModificare['Via'] = $datiValidi['Via'];
        $daModificare['NumCivico'] = $datiValidi['NumCivico'];
        $daModificare['CAP'] = $datiValidi['CAP'];
        return $fUtente->update($this->_codFiscale, $daModificare); //modificaIndirizzoCAP
    }
    
    /**
     * 
     * Metodo che permette di modificare il medico curante (la modifica avviene anche nel DB).
     * 
     * @access public
     * @param string $cf Codice fiscale del nuovo medico
     * @return boolean TRUE modifica effettuata, altrimenti lancia un'ecezione
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function modificaMedicoCurante($cf) 
    {
        $this->_medicoCurante = $cf;
        $daModificare['CodFiscaleMedico'] = $cf;
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->update($this->_codFiscale, $daModificare); //modificaMedicoCurante
    }
    
    /**
     * Metodo che consente di controllare se un utente può effettuare una prenotazione.
     * L'applicazione non permette ad un utente di prenotarsi per uno stesso esame lo stesso giorno nella stessa clinica 
     * e di prenotarsi per qualsiasi esame in una qualsiasi clinica durante l'orario di un esame già prenotato da lui.
     * 
     * @access public
     * @param string $idEsame L'id dell'esame di cui l'utente vuole effettuare la prenotazione
     * @param string $partitaIVA La partita IVA della clinica in cui intende prenotarsi l'utente
     * @param string $data La data della prenotazione(dd-mm-yyyy)
     * @param string $ora L'orario della prenotazione (mm:ss)
     * @param string $durata La durata della prenotazione(hh:mm:ss)
     * @param boolean $modifica true se si vuole effettuare la modifica di un esame, false altrimenti
     * @return boolean TRUE se l'utente può effettuare la prenotazione, altrimenti FALSE
     * @throws XDBException Se c'è un errore durante l'esecuzione della query
     */
    public function checkIfCan($idEsame, $partitaIVA, $data, $ora, $durata, $modifica) 
    {
        $canBook = TRUE;
        if($modifica!=="true")
        {
            $fPrenotazioni = USingleton::getInstance('FPrenotazione');
            $prenotazioni = $fPrenotazioni->cercaTraPrenotazioni($this->_codFiscale, $idEsame, $partitaIVA, $data, $ora, $durata);
            if(is_array($prenotazioni) && count($prenotazioni)>0)// se ci sono prenotazioni
            {
                $canBook = FALSE; // non si può prenotare
            }
        } 
        return $canBook;    
    }
    
    /**
     * Metodo che controlla se un utente deve essere bloccato ovvero e l'utente 3 o più prenotazioni non effettuate.
     * 
     * @access public
     * @param string $dataOdierna La data in formato "Y-m-d"
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function controllaSeBloccare($dataOdierna) 
    {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $prenotazioniNonEffettuate = $fPrenotazioni->cercaPrenotazioniNonEffettuate($this->getCodFiscaleUtente(), $dataOdierna);
        if(count($prenotazioniNonEffettuate)>=3)
        {
            $this->setBloccato(TRUE);
            $id = $this->getUsernameUtente();
            $daModificare['Bloccato'] = TRUE;
            $fUser = USingleton::getInstance('FUser');
            $fUser = update($id, $daModificare);
        }
    }
    
    /**
     * Metodo che consente di modificare i dati dell'utente.
     * 
     * @access public
     * @param array $datiDaModificare I dati dell'utente da modificare
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaUtente($datiDaModificare) {
        foreach ($datiDaModificare as $key => $value) {
            switch ($key) {
                case 'username':
                    $this->setUsername($value);
                    break;
                case 'codiceConferma':
                    $this->setCodiceConfermaUser($value);
                    break;
                case 'confermato':
                    if($value === true || $value === TRUE ||  $value === 'SI' || $value === 'true')
                    {
                        $this->setConfermato(TRUE);
                    }
                    else 
                    {
                        $this->setConfermato('FALSE');
                    }
                    
                    break;
                case 'bloccato':
                    if($value === 'SI' || $value === TRUE   || $value === true || $value === 'true')
                        
                    {
//                        $dataOdierna = date ("Y/m/d");
                        $this->setBloccato(TRUE);
//                        $this->controllaSeBloccare($dataOdierna);
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
                    $this->setCodiceFiscaleUtente($value);
                    break;
                case 'nome':
                    $this->setNomeUtente($value);
                    break;
                case 'cognome':
                    $this->setCognomeUtente($value);
                    break;
                case 'via':
                    $this->setViaUtente($value);
                    break;
                case 'numeroCivico':
                    $this->setNumCivicoUtente($value);
                    break;
                case 'CAP':
                    $this->setCAPUtente($value);
                    break;
                case 'passwordUtente':
                    if(!empty($value))
                    {
                        $this->modificaPassword($value);
                    }
                    break;
                default:
                    break;
            }
        }
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->modificaUtente($this);
    }
    
    /**
     * Metodo che consente di cercare tutti i medici dell'applicazione.
     * 
     * @access public
     * @return array I medici dell'applicazione
     * @throws XDBException In caso di insuccesso della query
     */
    public function cercaMedici() {
        $fMedici = USingleton::getInstance('FMedico');
        $medici = $fMedici->cerca();
        return $medici;
    }
    
    /**
     * Metodo che aggiunge il medico curante dell'utente anche nel DB.
     * 
     * @access public
     * @param string $codiceMedico Il codice fiscale del medico curante dell'utente
     * @return boolean TRUE se la query viene eseguito con successo altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function aggiungiMedicoCurante($codiceMedico) {
        $this->setMedicoCurante($codiceMedico);
        $daModificare['CodFiscaleMedico'] = $codiceMedico;
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->update($this->getCodFiscaleUtente(), $daModificare );
    }
}
