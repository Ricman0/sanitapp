<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EUtente
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EUtente extends EUser {

    /**
     * @var string $_nome, variabile di tipo string,  che contiente il nome dell'utente
     */
    private $_nome;

    /**
     * @var string $_cognome, variabile di tipo string,  che contiente il cognome dell'utente
     */
    private $_cognome;

    /**
     * @var string $_codFiscale, variabile di tipo string,  che contiente il 
     *             codice fiscale dell'utente
     */
    private $_codFiscale;

    /**
     * @var string $_via, variabile di tipo string, che contiente l'indirizzo 
     *             in cui risiede l'utente
     */
    private $_via;

    /**
     * @var int $_numeroCivico, variabile di tipo intero, che contiente il numero
     *          civico in cui risiede l'utente
     */
    private $_numeroCivico;

    /**
     * @var string $_CAP, variabile che contiente il CAP in cui 
     *          risiede l'utente
     */
    private $_CAP;

    /**
     * @var Array(EPrenotazione) $_prenotazioni array che contiente le 
     *                           prenotazioni a nome dell'utente
     */
    private $_prenotazioni;
    // non so se sia giusto inserirlo
    /**
     * @var string $_medicoCurante, variabile che contiente il codice fiscale del medico curante dell'utente
     */
    private $_medicoCurante;

    /**
     * Costruttore della classe EUtente
     * 
     * @access public
     * @param string $nome Il nome dell'utente
     * @param string $cognome Il cognome dell'utente
     * @param string $cf Il codice fiscale dell'utente
     * @param string $via La via in cui risiede l'utente
     * @param int $numeroCivico Ilnumero civico dell'utente
     * @param string $cap Il cap del paese in cui risiede l'utente
     * @param type $medico Description
     * @throws XUtenteException Se l'utente non esiste
     */
    public function __construct($cf = NULL, $username = NULL, $password = "", $email = "", $nome = "", $cognome = "", $via = "", $numeroCivico = "", $cap = "", $medico = NULL) {

        if ($cf === NULL || $username === NULL) 
        {
            $fUtente = USingleton::getInstance('FUtente');

            if ($cf === NULL && $username !== NULL) {
                //caso in cui possiedo l'username ma non il codice fiscale
//            $sessione = USingleton::getInstance('USession');
//            $username = $sessione->leggiVariabileSessione('usernameLogIn');

                $attributiUtente = $fUtente->cercaUtente($username);
            } elseif ($cf !== NULL && $username === NULL) {
                //caso in cui possiedo l'username ma non il codice fiscale
                $attributiUtente = $fUtente->cercaUtenteByCF($cf);
            }
            if (is_array($attributiUtente) && count($attributiUtente)===1) {
                // esiste quell'utente
                parent::setUsername($attributiUtente[0]['Username']);
                parent::setPassword($attributiUtente[0]['Password']);
                parent::setEmail($attributiUtente[0]['Email']);
                parent::setPEC($attributiUtente[0]['PEC']);
                parent::setConfermato($attributiUtente[0]['Confermato']);
                parent::setCodiceConfermaUtente($attributiUtente[0]['CodiceConferma']);
                parent::setTipoUser($attributiUtente[0]['TipoUser']);
                $this->setNomeUtente($attributiUtente[0]['Nome']);
                $this->setCognomeUtente($attributiUtente[0]['Cognome']);
                $this->setCodiceFiscaleUtente($attributiUtente[0]['CodFiscale']);
                $this->setViaUtente($attributiUtente[0]['Via']);
                $this->setNumCivicoUtente($attributiUtente[0]['NumCivico']);
                $this->setCAPUtente($attributiUtente[0]['CAP']);
                $this->setMedicoCurante($attributiUtente[0]['CodFiscaleMedico']);
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
            $this->_codFiscale = $cf;
            $this->_via = $via;
            if (isset($numeroCivico)) {
                $this->_numeroCivico = $numeroCivico;
            } else {
                $this->_numeroCivico = NULL;
            }
            $this->_CAP = $cap;
            $this->_prenotazioni = new ArrayObject(); // da vedere:array di oggetti o bastava semplicemente Array()??
            $this->_medicoCurante = $medico;
        }



//        if ($cf === NULL && $username !== NULL) 
//        {
//            
//            $sessione = USingleton::getInstance('USession');
//            $username = $sessione->leggiVariabileSessione('usernameLogIn');
//            $fUtente = USingleton::getInstance('FUtente');
//            $attributiUtente = $fUtente->cercaUtente($username);
////            echo "Utente trovato";
//            if (!is_bool($attributiUtente)) 
//            {
////                print_r($attributiUtente);
//                // esiste quell'utente
//                $this->setNomeUtente($attributiUtente[0]['Nome']);
//                $this->setCognomeUtente($attributiUtente[0]['Cognome']);
//                $this->_codFiscale = $attributiUtente[0]['CodFiscale'];
//                $this->setViaUtente($attributiUtente[0]['Via']);
//                if (isset($attributiUtente[0]['NumCivico'])) {
//                    $this->setNumCivicoUtente($attributiUtente[0]['NumCivico']);
//                }
//                $this->setCAPUtente($attributiUtente[0]['CAP']);
//                $this->setEmailUtente($attributiUtente[0]['Email']);
//                $this->setUsernameUtente($attributiUtente[0]['Username']);
//                $this->setPasswordUtente($attributiUtente[0]['Password']);
//                $this->setConfermatoUtente($attributiUtente[0]['Confermato']);
//                $this->setCodiceConfermaUtente($attributiUtente[0]['CodiceConferma']);
//                $this->_medicoCurante = $attributiUtente[0]['CodFiscaleMedico'];
//            }
//            
//        } 
//        else 
//        {
//            if ($cf !== NULL && $username !== NULL) 
//            {
//                $this->_nome = $nome;
//                $this->_cognome = $cognome;
//                $this->_codFiscale = $cf;
//                $this->_via = $via;
//                if (isset($numeroCivico)) {
//                    $this->_numeroCivico = $numeroCivico;
//                } else {
//                    $this->_numeroCivico = NULL;
//                }
//
//                $this->_CAP = $cap;
//                $this->_email = $email;
//                $this->_username = $username;
//                $this->_password = $password;
//                $this->_codiceConferma = $cod;
//                $this->_confermato = FALSE;
//                $this->_prenotazioni = new ArrayObject(); // da vedere:array di oggetti o bastava semplicemente Array()??
//                if (isset($medico)) {
//                    $this->_medicoCurante = $medico;
//                } else {
//                    $this->_medicoCurante = NULL;
//                }
//            }
//            else // cf !== null and username === null
//            {
//                
//            $fUtente = USingleton::getInstance('FUtente');
//            $attributiUtente = $fUtente->cercaUtenteByCF($cf);
////            echo "Utente trovato";
//            if (!is_bool($attributiUtente)) {
////                print_r($attributiUtente);
//                // esiste quell'utente
//                $this->setNomeUtente($attributiUtente[0]['Nome']);
//                $this->setCognomeUtente($attributiUtente[0]['Cognome']);
//                $this->_codFiscale = $attributiUtente[0]['CodFiscale'];
//                $this->setViaUtente($attributiUtente[0]['Via']);
//                if (isset($attributiUtente[0]['NumCivico'])) {
//                    $this->setNumCivicoUtente($attributiUtente[0]['NumCivico']);
//                }
//                $this->setCAPUtente($attributiUtente[0]['CAP']);
//                $this->setEmailUtente($attributiUtente[0]['Email']);
//                $this->setUsernameUtente($attributiUtente[0]['Username']);
//                $this->setPasswordUtente($attributiUtente[0]['Password']);
//                $this->setConfermatoUtente($attributiUtente[0]['Confermato']);
//                $this->setCodiceConfermaUtente($attributiUtente[0]['CodiceConferma']);
//                $this->_medicoCurante = $attributiUtente[0]['CodFiscaleMedico'];
//            }
//    
//            }
//        }
    }

    //metodi get
    /**
     * Metodo per conoscere il nome dell'utente
     * 
     * @access public
     * @return string Il nome dell'utente
     */
    public function getNomeUtente() {
        return $this->_nome;
    }

    /**
     * Metodo per conoscere il cognome dell'utente
     * 
     * @return string Il cognome dell'utente
     */
    public function getCognomeUtente() {
        return $this->_cognome;
    }

    /**
     * Metodo per conoscere il codice fiscale dell'utente
     * 
     * @access public
     * @return string Il codice fiscale dell'utente
     */
    public function getCodiceFiscaleUtente() {
        return $this->_codFiscale;
    }

    /**
     * Metodo per conoscere la via in cui risiede l'utente
     * 
     * @access public
     * @return string Il nome della via in cui risiede l'utente
     */
    public function getViaUtente() {
        return $this->_via;
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
     * Metodo per conoscere il cap del paese in cui risiede l'utente
     * 
     * @access public
     * @return string Il cap del paese in cui risiede l'utente
     */
    public function getCAPUtente() {
        return $this->_CAP;
    }

    /**
     * Metodo per conoscere il codice fiscale del medico curante dell'utente
     * 
     * @access public
     * @return string Il codice fiscale del medico curante dell'utente
     */
    public function getMedicoCurante() {
        return $this->_medicoCurante;
    }

    /**
     * Metodo per conoscere le prenotazioni dell'utente
     * 
     * @access public
     * @return Array(EPrenotazione) Le prenotazioni dell'utente
     */
    public function getPrenotazioniUtente() {
        return $this->_prenotazioni;
    }

    //metodi set

    /**
     * Metodo che permette di modificare il nome dell'utente
     * 
     * @access public
     * @param string $nome Il nome dell'utente
     */
    public function setNomeUtente($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome dell'utente
     * 
     * @access public
     * @param string $cognome Il cognome dell'utente
     */
    public function setCognomeUtente($cognome) {
        $this->_cognome = $cognome;
    }

    /**
     * Metodo che permette di modificare il codice fiscale dell'utente
     * 
     * @access public
     * @param string $codFiscale Il codice fiscale dell'utente
     */
    public function setCodiceFiscaleUtente($codFiscale) {
        $this->_codFiscale = $codFiscale;
    }
    
    

    /**
     * Metodo che permette di modificare l'email dell'utente
     * 
     * @access public
     * @param string $email L'email dell'utente
     */
    public function setEmail($email) {
        parent::setEmail($email);
    }

    /**
     * Metodo che permette di modificare la via dell'utente
     * 
     * @access public
     * @param string $via La nuova via dell'utente
     */
    public function setViaUtente($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare il numero civico dell'utente
     * 
     * @access public
     * @param int $numCiv Il nuovo numero civico dell'utente
     */
    public function setNumCivicoUtente($numCiv) {
        $this->_numeroCivico = $numCiv;
    }

    /**
     * Metodo che permette di modificare il CAP dell'utente
     * 
     * @access public
     * @param string $cap Il nuovo CAP dell'utente
     */
    public function setCAPUtente($cap) {
        $this->_CAP = $cap;
    }

    /**
     * Metodo che permette di modificare il codice fiscale del medico curante dell'utente
     * 
     * @access public
     * @param string $medico Il codice fiscale del medico curante dell'utente
     */
    public function setMedicoCurante($medico) {
        $this->_medicoCurante = $medico;
    }

    /**
     * Metodo che permette di aggiungere una prenotazione nell'array di 
     * prenotazioni dell'utente
     * 
     * @access public
     * @param Entity.EPrenotazione $prenotazione Una nuova prenotazione effettuata a 
     *                      nome dell'utente.
     */
    public function aggiungiPrenotazioneUtente($prenotazione) {
        $this->_prenotazioni->append($prenotazione); // non so se sia giusto o se debba usare offsetSet() 
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EUtente nel DB
     * 
     * @access public
     * @return string|Boolean Il codice di conferma se l'utente è stato inserito correttamente, altrimenti FALSE (l'utente  non è stato inserito correttamente nel DB)
     */
    public function inserisciUtenteDB() {
        
        //crea un oggetto fUtente se non è esistente, si collega al DB e lo inserisce
        $fUtente = USingleton::getInstance('FUtente');
//        return $fUtente->inserisciUtente($eUtente);
        if ($fUtente->inserisciUtente($this) === TRUE) {
            return parent::getCodiceConferma();
        } else {
            return FALSE;
        }
    }

    /**
     * Metodo che consente di cercare tutte le prenotazioni dell'utente
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return Array Un array contenente tutte le prenotazione di un utente
     */
    public function cercaPrenotazioni() {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $this->_prenotazioni = $fPrenotazioni->cercaPrenotazioni($this->_codFiscale);
        return $this->_prenotazioni;
    }

    /**
     * Metodo che consente di cercare tutti i referti di un utente
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return Array Un array contenente tutti i referti di un utente
     */
    public function cercaReferti() 
    {
        $fReferti = USingleton::getInstance('FReferto');
        return $fReferti->cercaRefertiUtente($this->_codFiscale);
    }

    
    /**
     * Metodo che permette di modificare l'indirizzo, numero civico e CAP (la modifica avviene anche nel DB)
     * 
     * @access public
     * @param Array $datiValidi Array contenente i valori di indirizzo, numero civico e CAP
     * @return boolean TRUE modifica effettuata, FALSE altrimenti
     */
    public function modificaIndirizzoCAP($datiValidi) 
    {
        $this->_via = $datiValidi['Via'];
        $this->_numeroCivico = $datiValidi['NumCivico'];
        $this->_CAP = $datiValidi['CAP'];
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->modificaIndirizzoCAP($this->_codFiscale, $this->_via, $this->_numeroCivico,  $this->_CAP);
    }

    /**
     * Metodo che permette di modificare la password (la modifica avviene anche nel DB)
     * 
     * @access public
     * @param string $password password da modificare
     * @return boolean TRUE modifica effettuata, FALSE altrimenti
     */
    public function modificaPassword($password) 
    {
        parent::setPassword($password);
        $fUser = USingleton::getInstance('FUser');
        return $fUser->modificaPassword(parent::getUsername(), parent::getPassword());
    }
    
    /**
     * 
     * Metodo che permette di modificare il medico curante (la modifica avviene anche nel DB)
     * 
     * @access public
     * @param string $cf Codice fiscale del nuovo medico
     * @return boolean TRUE modifica effettuata, FALSE altrimenti
     */
    public function modificaMedicoCurante($cf) 
    {
        $this->_medicoCurante = $cf;
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->modificaMedicoCurante($this->_codFiscale, $cf);
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
     * @param boolean $modifica true se si vuole effettuare la modifica di un esame, false altrimenti.
     * @throws XDBException Se c'è un errore durante l'esecuzione della query
     * @return boolean TRUE se l'utente può effettuare la prenotazione, FALSE altrimenti
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

}
