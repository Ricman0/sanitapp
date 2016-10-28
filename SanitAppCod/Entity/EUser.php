<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EUser
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EUser {

    /**
     * @var string $_email, variabile di tipo string, che contiente l'indirizzo 
     *             di posta elettronica dell'utente. é valido come username per 
     *             l'accesso al sistema
     */
    private $_email;

    /**
     * @var string $_password, variabile di tipo string, che contiente la
     *             password che l'utente inserisce per accedere al sistema
     */
    private $_password;

    /**
     * @var string $_username, variabile di tipo string, che contiene lo
     *              username che l'utente inserisce per registrarsi
     */
    private $_username;

    /**
     * @var string $_codiceConferma, variabile che contiente il codice per confermare 
     * l'account dell'utente
     */
    private $_codiceConferma;

    /**
     * @var string $_confermato permette di capire se l'account dell'utente è 
     * stato confermato(TRUE) o meno         
     */
    private $_confermato;
    
    /**
     * Costruttore della classe EUser
     * 
     * @param string $email L'email dell'utente
     * @param type $name Description
     * @param string $password La password dell'utente
     * @param string $cod Il codice per confermare l'account
     */
    public function __construct($username, $password = "", $email = "") 
    {
        
        $this->_email = $email;
        $this->_username = $username;
        $this->_password = $password;
        $this->_codiceConferma = md5($username.$email.date('mY'));
        $this->_confermato = FALSE;
        
//        if ($username !== NULL) 
//        {
//            $sessione = USingleton::getInstance('USession');
//            $username = $sessione->leggiVariabileSessione('usernameLogIn');
//            $fUtente = USingleton::getInstance('FUser');
//            $risultato = $fUser->cercaUtente($username);
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
     * Metodo per conoscere lo username dell'user
     * 
     * @return string lo username dell'user
     */
    public function getUsername() {
        return $this->_username;
    }

    /**
     * Metodo per conoscere la password dell'user
     * 
     * @return string La password dell'user
     */
    public function getPassword() {
        return $this->_password;
    }
    
    /**
     * Metodo per conoscere l'email dell'user
     * 
     * @return string L'email dell'user
     */
    public function getEmail() {
        return $this->_email;
    }
    
    /**
     * Metodo per conoscere il codice di conferma dell'user
     * 
     * @return string Il codice dell'user 
     */
    public function getCodiceConferma() {
        return $this->_codiceConferma;
    }

    /**
     * Metodo che permette di capire se l'account è stato confermato o meno
     * 
     * @return boolean TRUE se l'account è stato confermato, FALSE altrimenti
     */
    public function getConfermato() 
    {
        return $this->_confermato;
    }

    //metodi set

    /**
     * Metodo che permette di modificare lo username dell'user
     * 
     * @param string $un Il nuovo username dell'user
     */
    public function setUsername($un) 
    {
        $this->_username = $un;
    }

    /**
     * Metodo che permette di modificare la password dell'user
     * 
     * @param string $pw La nuova password dell'user
     */
    public function setPassword($pw) 
    {
        $this->_password = $pw;
    }

    /**
     * Metodo che permette di modificare l'email dell'user
     * 
     * @param string $email L'email dell'user
     */
    public function setEmail($email) 
    {
        return $this->_email = $email;
    }

   
    /**
     * Metodo che permette di modificare il codice di conferma dell'user
     * 
     * @param string $cod Il nuovo codice per la conferma dell'user
     */
    public function setCodiceConfermaUtente($cod) 
    {
        $this->_codiceConferma = $cod;
    }

    

    /**
     * Metodo che permette di impostare la conferma dell'account 
     * 
     * @param boolean $confermato Imposta la conferma dell'account 
     */
    public function setConfermato($confermato) 
    {
        $this->_confermato = $confermato;
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EUser nel DB
     * 
     * @access public
     * @return string|Boolean Il codice di conferma se l'utente è stato inserito correttamente, altrimenti FALSE (l'utente  non è stato inserito correttamente nel DB)
     */
    public function inserisciUserDB() {
        //crea un oggetto fUser se non è esistente, si collega al DB e lo inserisce
        $fUser = USingleton::getInstance('FUser');
//        return $fUtente->inserisciUtente($eUtente);
        if ($fUser->inserisciUser($this) === TRUE) 
        {
            //forse ne ho bisogno nella mail di conferma????
            return $this->getCodiceConferma();
        } 
        else 
        {
            return FALSE;
        }
    }
    
    
    /**
     * Metodo che consente di cercare se un username è già esistente
     * 
     * @access public
     * @return boolean TRUE username esistente, FALSE altrimenti
     */
    public function esisteUsername() 
    {
        $fUser = USingleton::getInstance('FUser');
        return $fUser->esisteUsernameDB($this->_username); 
    }

}