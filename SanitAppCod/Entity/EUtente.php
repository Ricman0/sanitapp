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
class EUtente extends EUser{

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
     * @param string $nome Il nome dell'utente
     * @param string $cognome Il cognome dell'utente
     * @param string $cf Il codice fiscale dell'utente
     * @param string $via La via in cui risiede l'utente
     * @param int $numeroCivico Ilnumero civico dell'utente
     * @param string $cap Il cap del paese in cui risiede l'utente
     */
    public function __construct($cf = NULL, $username = NULL,$password = "", $email = "", $nome = "", $cognome = "", $via = "", $numeroCivico = "", $cap = "", $medico = "") 
    {
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
        if (isset($medico)) 
        {
            $this->_medicoCurante = $medico;
        } 
        else 
        {
            $this->_medicoCurante = NULL;
        }
        
//        if ($cf === NULL && $username !== NULL) 
//        {
//            
//            $sessione = USingleton::getInstance('USession');
//            $username = $sessione->leggiVariabileSessione('usernameLogIn');
//            $fUtente = USingleton::getInstance('FUtente');
//            $risultato = $fUtente->cercaUtente($username);
////            echo "Utente trovato";
//            if (!is_bool($risultato)) 
//            {
////                print_r($risultato);
//                // esiste quell'utente
//                $this->setNomeUtente($risultato[0]['Nome']);
//                $this->setCognomeUtente($risultato[0]['Cognome']);
//                $this->_codFiscale = $risultato[0]['CodFiscale'];
//                $this->setViaUtente($risultato[0]['Via']);
//                if (isset($risultato[0]['NumCivico'])) {
//                    $this->setNumCivicoUtente($risultato[0]['NumCivico']);
//                }
//                $this->setCAPUtente($risultato[0]['CAP']);
//                $this->setEmailUtente($risultato[0]['Email']);
//                $this->setUsernameUtente($risultato[0]['Username']);
//                $this->setPasswordUtente($risultato[0]['Password']);
//                $this->setConfermatoUtente($risultato[0]['Confermato']);
//                $this->setCodiceConfermaUtente($risultato[0]['CodiceConferma']);
//                $this->_medicoCurante = $risultato[0]['CodFiscaleMedico'];
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
//            $risultato = $fUtente->cercaUtenteByCF($cf);
////            echo "Utente trovato";
//            if (!is_bool($risultato)) {
////                print_r($risultato);
//                // esiste quell'utente
//                $this->setNomeUtente($risultato[0]['Nome']);
//                $this->setCognomeUtente($risultato[0]['Cognome']);
//                $this->_codFiscale = $risultato[0]['CodFiscale'];
//                $this->setViaUtente($risultato[0]['Via']);
//                if (isset($risultato[0]['NumCivico'])) {
//                    $this->setNumCivicoUtente($risultato[0]['NumCivico']);
//                }
//                $this->setCAPUtente($risultato[0]['CAP']);
//                $this->setEmailUtente($risultato[0]['Email']);
//                $this->setUsernameUtente($risultato[0]['Username']);
//                $this->setPasswordUtente($risultato[0]['Password']);
//                $this->setConfermatoUtente($risultato[0]['Confermato']);
//                $this->setCodiceConfermaUtente($risultato[0]['CodiceConferma']);
//                $this->_medicoCurante = $risultato[0]['CodFiscaleMedico'];
//            }
//    
//            }
//        }
    }

    //metodi get
    /**
     * Metodo per conoscere il nome dell'utente
     * 
     * @return string Il nome dell'utente
     */
    public function getNomeUtente() {
        return $this->_nome;
    }

    /**
     * Metodo per conoscere il codice fiscale del medico curante dell'utente
     * 
     * @return string Il cf del medico dell'utente
     */
    public function getMedicoUtente() {
        return $this->_medicoCurante;
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
     * @return string Il codice fiscale dell'utente
     */
    public function getCodiceFiscaleUtente() {
        return $this->_codFiscale;
    }
    
   

    /**
     * Metodo per conoscere la via in cui risiede l'utente
     * 
     * @return string Il nome della via in cui risiede l'utente
     */
    public function getViaUtente() {
        return $this->_via;
    }

    /**
     * Metodo per conoscere il numero civico della via in cui risiede l'utente
     * 
     * @return int Il numero civico della via in cui risiede l'utente
     */
    public function getNumCivicoUtente() {
        return $this->_numeroCivico;
    }

    /**
     * Metodo per conoscere il cap del paese in cui risiede l'utente
     * 
     * @return string Il cap del paese in cui risiede l'utente
     */
    public function getCAPUtente() {
        return $this->_CAP;
    }

    

    /**
     * Metodo per conoscere le prenotazioni dell'utente
     * 
     * @return Array(EPrenotazione) Le prenotazioni dell'utente
     */
    public function getPrenotazioniUtente() {
        return $this->_prenotazioni;
    }

    //metodi set

    /**
     * Metodo che permette di modificare il nome dell'utente
     * 
     * @param string $nome Il nome dell'utente
     */
    public function setNomeUtente($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome dell'utente
     * 
     * @param string $cognome Il cognome dell'utente
     */
    public function setCognomeUtente($cognome) {
        $this->_cognome = $cognome;
    }

    /**
     * Metodo che permette di modificare il codice fiscale dell'utente
     * 
     * @param string $codFiscale Il codice fiscale dell'utente
     */
    public function setCodiceFiscaleUtente($codFiscale) {
        $this->_codFiscale = $codFiscale;
    }

    /**
     * Metodo che permette di modificare l'email dell'utente
     * 
     * @param string $email L'email dell'utente
     */
    public function setEmailUtente($email) {
        return $this->_email = $email;
    }

    /**
     * Metodo che permette di modificare la via dell'utente
     * 
     * @param string $via La nuova via dell'utente
     */
    public function setViaUtente($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare il numero civico dell'utente
     * 
     * @param int $numCiv Il nuovo numero civico dell'utente
     */
    public function setNumCivicoUtente($numCiv) {
        $this->_numeroCivico = $numCiv;
    }

    /**
     * Metodo che permette di modificare il CAP dell'utente
     * 
     * @param string $cap Il nuovo CAP dell'utente
     */
    public function setCAPUtente($cap) {
        $this->_CAP = $cap;
    }


    /**
     * Metodo che permette di aggiungere una prenotazione nell'array di 
     * prenotazioni dell'utente
     * 
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
     * @return Boolean TRUE se l'utente è stato inserito correttamente, altrimenti FALSE (l'utente  non è stato inserito correttamente nel DB)
     */
    public function inserisciUtenteDB() {
        //crea un oggetto fUtente se non è esistente, si collega al DB e lo inserisce
        $fUtente = USingleton::getInstance('FUtente');
//        return $fUtente->inserisciUtente($eUtente);
        if ($fUtente->inserisciUtente($this) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
