<?php

/**
 * La classe EUser si occupa della gestione in ram dell'user.
 *
 * @package Entity
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
     * Costruttore della classe EUser.
     * 
     * @access public
     * @param string $username L'username dello user
     * @param string $password La password dello user
     * @param string $email L'email dello user
     * @param string $PEC La pec dell'user@throws XUserException Quando lo user da istanziare non esiste
     * @throws XDBException Se la query non è stata eseguita con successo
     * @throws XUserException Se l'user è inesistente
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
                $daCercare['Email'] = $email;
                $attributiUser = $fUser->cerca($daCercare);
//                $attributiUser = $fUser->cercaUserByEmail($email);
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
                $daCercare['Username'] = $username;
                $attributiUser = $fUser->cerca($daCercare); //cercaUserByUsername
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
            }elseif($username ===NULL && $password===NULL && $email===NULL && $PEC !==NULL){
                $fUser = USingleton::getInstance('FUser');
                $daCercare['PEC'] = $PEC;
                $attributiUser = $fUser->cerca($daCercare);
                if(is_array($attributiUser) && count($attributiUser)==1)
                {
                    $this->_username = $attributiUser[0]['Username'];
                    $this->_password = $attributiUser[0]['Password'];
                    $this->_email = $attributiUser[0]['Email'];
                    $this->_codiceConferma = $attributiUser[0]['CodiceConferma'];
                    $this->_confermato = $attributiUser[0]['Confermato'];
                    $this->_bloccato = $attributiUser[0]['Bloccato'];
                    $this->_tipoUser=$attributiUser[0]['TipoUser'];
                    $this->_PEC=$attributiUser[0]['PEC'];
                }
            }

        }
    }

    //metodi get

    /**
     * Metodo per conoscere lo username dell'user.
     * 
     * @access public
     * @return string Lo username dell'user
     */
    public function getUsernameUser() {
        return $this->_username;
    }

    /**
     * Metodo per conoscere la password dell'user.
     * 
     * @access public
     * @return string La password dell'user
     */
    public function getPasswordUser() {
        return $this->_password;
    }
    
    /**
     * Metodo per conoscere l'email dell'user.
     * 
     * @access public
     * @return string L'email dell'user
     */
    public function getEmailUser() {
        return $this->_email;
    }
    
    /**
     * Metodo per conoscere la PEC dell'user.
     * 
     * @access public
     * @return string La PEC dell'user
     */
    public function getPECUser() {
        return $this->_PEC;
    }
    
    /**
     * Metodo per conoscere il codice di conferma dell'user.
     * 
     * @access public
     * @return string Il codice dell'user 
     */
    public function getCodiceConfermaUser() {
        return $this->_codiceConferma;
    }

    /**
     * Metodo che permette di capire se l'account è stato confermato o meno.
     * 
     * @access public
     * @return boolean TRUE se l'account è stato confermato, FALSE altrimenti
     */
    public function getConfermatoUser() 
    {
        return $this->_confermato;
    }
    
    /**
     * Metodo che permette di capire se l'account è stato bloccato o meno.
     * 
     * @access public
     * @return boolean TRUE se l'account è stato bloccato, FALSE altrimenti
     */
    public function getBloccatoUser() 
    {
        return $this->_bloccato;
    }
    
    /**
     * Metodo per conoscere il tipo di user.
     * 
     * @access public
     * @return string il tipo di user
     */
    public function getTipoUserUser() 
    {
        return $this->_tipoUser;
    }

    //metodi set

    /**
     * Metodo che permette di modificare lo username dell'user.
     * 
     * @access public
     * @param string $un Il nuovo username dell'user
     */
    public function setUsername($un) 
    {
        $this->_username = $un;
    }

    /**
     * Metodo che permette di modificare la password dell'user.
     * 
     * @access public
     * @param string $pw La nuova password dell'user
     */
    public function setPassword($pw) 
    {
        $this->_password = $pw;
    }

    /**
     * Metodo che permette di modificare l'email dell'user.
     * 
     * @access public
     * @param string $email L'email dell'user
     */
    public function setEmail($email) 
    {
        return $this->_email = $email;
    }
    
    /**
     * Metodo che permette di modificare la PEC dell'user.
     * 
     * @access public
     * @param string $PEC La PEC dell'user
     */
    public function setPEC($PEC) 
    {
        return $this->_PEC = $PEC;
    }

   
    /**
     * Metodo che permette di modificare il codice di conferma dell'user.
     * 
     * @access public
     * @param string $cod Il nuovo codice per la conferma dell'user
     */
    public function setCodiceConfermaUser($cod) 
    {
        $this->_codiceConferma = $cod;
    }

    /**
     * Metodo che permette di impostare la conferma dell'account. 
     * 
     * @access public
     * @param boolean $confermato Imposta la conferma dell'account 
     */
    public function setConfermato($confermato) 
    {
        $this->_confermato = $confermato;
    }
    
    /**
     * Metodo che permette di impostare il blocco dell'account. 
     * 
     * @access public
     * @param boolean $bloccato Imposta il blocco dell'account 
     */
    public function setBloccato($bloccato) 
    {
        $this->_bloccato = $bloccato;
    }
    
    /**
     * Metodo per impostare il tipo di user.
     * 
     * @access public
     * @param string $tipo Il tipo di user
     */
    public function setTipoUser($tipo) 
    {
        $this->_tipoUser = trim($tipo);
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EUser nel DB.
     * 
     * @access public
     * @return string Il codice di conferma se l'utente è stato inserito correttamente nel DB.
     */
//    public function inserisciUserDB() {
//        //crea un oggetto fUser se non è esistente, si collega al DB e lo inserisce
//        $fUser = USingleton::getInstance('FUser');
//        $fUser->inserisciUser($this);
//        return $this->getCodiceConfermaUser();
//    }
    
    
    /**
     * Metodo che consente di cercare se un username è già esistente.
     * 
     * @access public
     * @return boolean TRUE username esistente
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function esisteUsername() 
    {
        $fUser = USingleton::getInstance('FUser');
        return $fUser->esisteUsernameDB($this->_username); 
    }
    
    /**
     * Metodo che controlla che uno user cercato esiste. Se esiste lo restituisce attraverso un array.
     * 
     * @access public
     * @return array|boolean Un array contenente Username,TipoUser e Confermato, FALSE se non esiste un user.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function esisteUser() 
    {
        $fUser = USingleton::getInstance('FUser');
        return $fUser->esisteUserDB($this->_username, $this->_password);
    }
    
    /**
     * Metodo che consente di impostare le variabili di sessione dello user.
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
     * Metodo che consente di confermare l'account di un user.  
     * 
     * @access public
     * @param string $idConferma Il codice di conferma per effettuare la conferma di un account
     * @return boolean TRUE User confermato, FALSE altrimenti.
     * @throws XDBException Se la query non Ã¨ stata eseguita con successo
     */
    public function confermaUser($idConferma) 
    {
        if($this->getConfermatoUser()==TRUE)
        {
            return TRUE;
        }
        else
        {
            $username = $this->getUsernameUser();
            $fUser = USingleton::getInstance('FUser');
            $daCercare['Username'] = $username;
            $daCercare['CodiceConferma'] = $idConferma;
            $user = $fUser->cerca($daCercare);//cercaUserByUsernameCodiceConferma 
            if(is_array($user) && count($user)===1)
            {
                $daModificare['Confermato'] = TRUE;
                return $fUser->update($username, $daModificare); //confermaUser
            }              
        }
        
    }
    
    /**
     * Metodo che permette di modificare la password (la modifica avviene anche nel DB).
     * 
     * @access public
     * @param string $password password da modificare, se non fornito crea una password automaticamente
     * @return boolean TRUE modifica effettuata
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function modificaPassword($password = NULL) 
    {
        $username = $this->getUsernameUser();
        if ($password===NULL)
        {
            $password = $this->generatePassword();
        }
        $password = password_hash($password.$username, PASSWORD_BCRYPT);
        $this->setPassword($password);
        $fUser = USingleton::getInstance('FUser');
        $daModificare['Password']= $this->getPasswordUser();
        return $fUser->update($this->getUsernameUser(), $daModificare); //modificaPassword
    }
    
    /**
     * Genera una password casuale in conformità dalle regole imposte.
     * 
     * @access public
     * @param int $length lunghezza della password
     * @return string la password generata automaticamente
     */
    public function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charsLow = 'abcdefghijklmnopqrstuvwxyz';
        $charsUp = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '0123456789';
        $count= mb_strlen($chars);
        $countCharsUp = mb_strlen($charsUp);
        $countCharsLow = mb_strlen($charsLow);
        $countNum = mb_strlen($num);

        for ($i = 0, $result = ''; $i < $length-3; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        $index = rand(0, $countCharsUp - 1);
        $result .= mb_substr($charsUp, $index, 1);
        $index = rand(0, $countNum - 1);
        $result .= mb_substr($num, $index, 1);
        $index = rand(0, $countCharsLow - 1);
        $result .= mb_substr($charsLow, $index, 1);
        return $result;
    }
}