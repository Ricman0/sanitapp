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
     *             di posta elettronica dell'user. Ã© valido come username per 
     *             l'accesso al sistema
     */
    private $_email;

    /**
     * @var string $_PEC, variabile di tipo string, che contiente l'indirizzo 
     *             di posta elettronica certificata dell'user. Ã© valido come username per 
     *             l'accesso al sistema
     */
    private $_PEC;
    
    /**
     * @var string $_password, variabile di tipo string, che contiente la
     *             password che l'user inserisce per accedere al sistema
     */
    private $_password;

    /**
     * @var string $_username, variabile di tipo string, che contiene lo
     *              username che l'user inserisce per registrarsi
     */
    private $_username;

    /**
     * @var string $_codiceConferma, variabile che contiente il codice per confermare 
     * l'account dell'user
     */
    private $_codiceConferma;

    /**
     * @var boolean $_confermato permette di capire se l'account dell'user Ã¨ 
     * stato confermato(TRUE) o meno         
     */
    private $_confermato;
    
    /**
     * @var boolean $_bloccato permette di capire se l'account dell'user Ã¨ 
     * stato bloccato(TRUE) o meno         
     */
    private $_bloccato;
    
    /**
     * @var string $_tipoUser, variabile di tipo string, che contiene la tipologia di user (ad esempio medico)
     */
    private $_tipoUser;
    
    /**
     * Costruttore della classe EUser
     * 
     * @param string $email L'email dell'utente
     * @param type $name Description
     * @param string $password La password dell'utente
     * @param string $cod Il codice per confermare l'account
     * @param string $PEC La pec dell'user
     * @throws XUserException Quando lo user da creare non esiste
     */
    public function __construct($username, $password = NULL, $email = NULL, $PEC=NULL) 
    {
        if($username !==NULL && $password !== NULL && $email!==NULL)
        {
            $this->_email = $email;
            $this->_username = $username;
            $this->_password = password_hash($password.$username, PASSWORD_BCRYPT);
            $this->_codiceConferma = md5($username.$email.date('mY'));
            $this->_confermato = FALSE;
            $this->_bloccato = FALSE;
            $this->_tipoUser="";
            $this->_PEC = $PEC;
        }
        else
        {
            if($username !==NULL && $password==NULL && $email==NULL)
            {
                $fUser = USingleton::getInstance('FUser');
                $attributiUser = $fUser->cercaUser($username);
                if(is_array($attributiUser) && count($attributiUser)==1)
                {
                    $this->_username = $attributiUser[0]['Username'];
                    $this->_password = $attributiUser[0]['Password'];
                    $this->_email = $attributiUser[0]['Email'];
                    $this->_PEC=$attributiUser[0]['PEC'];
                    $this->_codiceConferma = $attributiUser[0]['CodiceConferma'];
                    $this->_confermato = $attributiUser[0]['Confermato'];
                    $this->_bloccato = $attributiUser[0]['Bloccato'];
                    $this->_tipoUser=$attributiUser[0]['TipoUser'];   
                }
                else
                {
                    throw new XUserException("User inesistente");
                }
            }
            elseif($username ==NULL && $password==NULL && $email!==NULL)
            {
                $fUser = USingleton::getInstance('FUser');
                $attributiUser = $fUser->cercaUserByEmail($email);
                if(is_array($attributiUser) && count($attributiUser)==1)
                {
                    $this->_username = $attributiUser[0]['Username'];
                    $this->_password = $attributiUser[0]['Password'];
                    $this->_email = $attributiUser[0]['Email'];
                    $this->_codiceConferma = $attributiUser[0]['CodiceConferma'];
                    $this->_confermato = $attributiUser[0]['Confermato'];
                    $this->_bloccato = $attributiUser[0]['Bloccato'];
                    $this->_tipoUser=$attributiUser[0]['TipoUser'];
                }
            }
            elseif($username !==NULL && $password!==NULL && $email===NULL)
            {
                $fUser = USingleton::getInstance('FUser');
                $attributiUser = $fUser->cercaUserByUsername($username);
                if(is_array($attributiUser) && count($attributiUser)==1 && password_verify($password.$username, $attributiUser[0]['Password']))
                {
                    $this->_username = $attributiUser[0]['Username'];
                    $this->_password = $attributiUser[0]['Password'];
                    $this->_email = $attributiUser[0]['Email'];
                    $this->_codiceConferma = $attributiUser[0]['CodiceConferma'];
                    $this->_confermato = $attributiUser[0]['Confermato'];
                    $this->_bloccato = $attributiUser[0]['Bloccato'];
                    $this->_tipoUser=$attributiUser[0]['TipoUser'];
                }
                else // utente non  esistente
                { 
                    //errore da gestire con exception
                    throw new XUserException("User inesistente");
                }
            }

        }
        
        
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
//                $this->setCodiceConfermaUser($risultato[0]['CodiceConferma']);
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
//                $this->setCodiceConfermaUser($risultato[0]['CodiceConferma']);
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
     * Metodo per conoscere la PEC dell'user
     * 
     * @return string La PEC dell'user
     */
    public function getPEC() {
        return $this->_PEC;
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
     * Metodo che permette di capire se l'account Ã¨ stato confermato o meno
     * 
     * @return boolean TRUE se l'account Ã¨ stato confermato, FALSE altrimenti
     */
    public function getConfermato() 
    {
        return $this->_confermato;
    }
    
    /**
     * Metodo che permette di capire se l'account Ã¨ stato bloccato o meno
     * 
     * @return boolean TRUE se l'account Ã¨ stato bloccato, FALSE altrimenti
     */
    public function getBloccato() 
    {
        return $this->_bloccato;
    }
    
    /**
     * Metodo per conoscere il tipo di user
     * 
     * @return string il tipo di user
     */
    public function getTipoUser() 
    {
        return $this->_tipoUser;
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
     * Metodo che permette di modificare la PEC dell'user
     * 
     * @param string $PEC La PEC dell'user
     */
    public function setPEC($PEC) 
    {
        return $this->_PEC = $PEC;
    }

   
    /**
     * Metodo che permette di modificare il codice di conferma dell'user
     * 
     * @param string $cod Il nuovo codice per la conferma dell'user
     */
    public function setCodiceConfermaUser($cod) 
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
     * Metodo che permette di impostare il blocco dell'account 
     * 
     * @param boolean $bloccato Imposta il blocco dell'account 
     */
    public function setBloccato($bloccato) 
    {
        $this->_bloccato = $bloccato;
    }
    
    /**
     * Metodo per impostare il tipo di user
     * 
     *  @param string $tipo Il tipo di user
     */
    public function setTipoUser($tipo) 
    {
        $this->_tipoUser = trim($tipo);
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EUser nel DB
     * 
     * @access public
     * @return string|Boolean Il codice di conferma se l'utente Ã¨ stato inserito correttamente, altrimenti FALSE (l'utente  non Ã¨ stato inserito correttamente nel DB)
     */
    public function inserisciUserDB() {
        //crea un oggetto fUser se non Ã¨ esistente, si collega al DB e lo inserisce
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
     * Metodo che consente di cercare se un username Ã¨ giÃ  esistente
     * 
     * @access public
     * @return boolean TRUE username esistente, FALSE altrimenti
     */
    public function esisteUsername() 
    {
        $fUser = USingleton::getInstance('FUser');
        return $fUser->esisteUsernameDB($this->_username); 
    }
    
    /**
     * Metodo che controlla che uno user cercato esiste. Se esiste lo restituisce atraverso un array
     * 
     * @access public
     * @return Array|boolean Un array contenente Username,TipoUser e Confermato, FALSE se non esiste un utente.
     */
    public function esisteUser() 
    {
        $fUser = USingleton::getInstance('FUser');
        return $fUser->esisteUserDB($this->_username, $this->_password);
    }
    
    
    /**
     * Metodo che consente di impostare le variabili di sessione dello user
     * 
     * @access public
     * @param string $username L'username dell'user
     * @param string $tipo Il tipo dell'user
     */
    public function attivaSessioneUser($username, $tipo) 
    {
        $sessione = USingleton::getInstance('USession');
        $sessione->impostaVariabileSessione('usernameLogIn', $username);
        $sessione->impostaVariabileSessione('loggedIn', TRUE);
        $sessione->impostaVariabileSessione('tipoUser', $tipo);

    }
    
    
    /**
     * Metodo che consente di confermare l'account di un user  
     * 
     * @access public
     * @param string $idConferma Il codice di conferma per effettuare la conferma di un account
     * @throws XDBException Se la query non Ã¨ stata eseguita con successo
     * @return boolean TRUE User confermato, FALSE altrimenti.
     */
    public function confermaUser($idConferma) 
    {
        if($this->getConfermato()==TRUE)
        {
            return TRUE;
        }
        else
        {
            $username = $this->getUsername();
            $fUser = USingleton::getInstance('FUser');
            $user = $fUser->cercaUserByUsernameCodiceConferma ($username,$idConferma);
            if(is_array($user) && count($user)===1)
            {
                return $fUser->confermaUser($username);
            }              
        }
        
    }
    
    /**
     * Metodo che permette di modificare la password (la modifica avviene anche nel DB)
     * 
     * @access public
     * @param string $password password da modificare, se non fornito crea una password automaticamente
     * @return boolean TRUE modifica effettuata, FALSE altrimenti
     */
    public function modificaPassword($password = NULL) 
    {
        if ($password===NULL)
        {
            $password = $this->generatePassword();
        }
        $this->setPassword($password);
        $fUser = USingleton::getInstance('FUser');
        return $fUser->modificaPassword($this->getUsername(), $this->getPassword());
    }
    
    /**
     * Genera una password casuale in conformità dalle regole imposte 
     * 
     * @access private 
     * @param int $length lunghezza della password
     * @return string la password generata automaticamente
     */
    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charsUp = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '0123456789';
        $count= mb_strlen($chars);
        $countCharsUp = mb_strlen($charsUp);
        $countNum = mb_strlen($num);

        for ($i = 0, $result = ''; $i < $length-2; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        $index = rand(0, $countCharsUp - 1);
        $result .= mb_substr($charsUp, $index, 1);
        $index = rand(0, $countNum - 1);
        $result .= mb_substr($num, $index, 1);
        return $result;
    }



}