<?php

/**
 * La classe EAmministratore si occupa della gestione in ram dell'amministratore.
 *
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EAmministratore extends EUser{
    /**
     * @var int $_id contiente l'id dell'amministratore
     */
    private $_id;
    
    /**
     * @var string $_telefono contiene il numero dell'amministratore
     */
    private $_telefono;
    
    /**
     * @var string $_nome, variabile di tipo string,  che contiente il nome dell'amministratore
     */
    private $_nome;

    /**
     * @var string $_cognome, variabile di tipo string,  che contiente il cognome dell'amministratore
     */
    private $_cognome;
    
    /**
     * Costruttore della classe EAmministratore.
     * 
     * @access public
     * @param string $username Username dell'amministratore
     * @param string $password La password dell'amministratore
     * @param string $email L'email dell'amministratore
     * @param string $PEC La PEC dell'amministratore
     * @param int $telefono Il telefono dell'amministratore
     * @param string $nome Il nome dell'amministratore
     * @param string $cognome Il cognome dell'amministratore
     * @throws XAmministratoreException Se l'amministratore relativo al codice fiscale immesso non esiste
     */
    public function __construct($username=NULL, $password=NULL, $email=NULL, $PEC=NULL, $telefono=NULL, $nome=NULL, $cognome= NULL){
        if($password!==NULL && $email!==NULL && $PEC!==NULL)
        {
            parent::__construct($username, $password, $email);
            parent::setTipoUser('amministratore');
            parent::setPEC($PEC);
            $this->_id = NULL; // nel db è autoincrement
            $this->_telefono = $telefono;
            $this->_nome = $nome;
            $this->_cognome = $cognome;
        }
        else
        {
            $fAmministratore = USingleton::getInstance('FAmministratore');
            $attributiAmministratore = $fAmministratore->cercaAmministratore($username);
            if (is_array($attributiAmministratore) && count($attributiAmministratore)===1) 
            {
                parent::setUsername($attributiAmministratore[0]['Username']);
                parent::setPassword($attributiAmministratore[0]['Password']);
                parent::setEmail($attributiAmministratore[0]['Email']);
                parent::setPEC($attributiAmministratore[0]['PEC']);
                parent::setBloccato($attributiAmministratore[0]['Bloccato']);
                parent::setConfermato($attributiAmministratore[0]['Confermato']);
                parent::setCodiceConfermaUser($attributiAmministratore[0]['CodiceConferma']);
                parent::setTipoUser($attributiAmministratore[0]['TipoUser']);
                $this->_id = $attributiAmministratore[0]['IdAmministratore']; // nel db è autoincrement
                $this->_telefono = $attributiAmministratore[0]['Telefono'];
                $this->_nome = $attributiAmministratore[0]['Nome'];
                $this->_cognome = $attributiAmministratore[0]['Cognome'];   
            }
            else
            {
                throw new XAmministratoreException('Amministratore inesistente.');
            }
        }
        
    }
    
    /**
     * Metodo che consente di ottenere l'id dell'amministratore.
     * 
     * @access public
     * @return string L'id dell'amministratore
     */
    public function getIdAmministratoreAmministratore() 
    {
        return $this->_id;
    }
    
    /**
     * Metodo che consente di ottenere l'username dell'amministratore.
     * 
     * @access public
     * @return string L'username dell'amministratore
     */
    public function getUsernameAmministratore() 
    {
        return parent::getUsernameUser();
    }
    
    /**
     * Metodo che consente di ottenere il telefono dell'amministratore.
     * 
     * @access public
     * @return string Il telefono dell'amministratore
     */
    public function getTelefonoAmministratore() 
    {
        return $this->_telefono;
    }
    
    /**
     * Metodo per conoscere il nome dell'amministratore.
     * 
     * @access public
     * @return string Il nome dell'amministratore
     */
    public function getNomeAmministratore() {
        return ucwords($this->_nome);
    }

    /**
     * Metodo per conoscere il cognome dell'amministratore.
     * 
     * @access public
     * @return string Il cognome dell'amministratore
     */
    public function getCognomeAmministratore() {
        return ucwords($this->_cognome);
    }
    
    /**
     * Metodo che permette di modificare il nome dell'amministratore.
     * 
     * @access public
     * @param string $nome Il nome dell'amministratore
     */
    public function setNome($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome dell'amministratore.
     * 
     * @access public
     * @param string $cognome Il cognome dell'amministratore
     */
    public function setCognome($cognome) {
        $this->_cognome = $cognome;
    }
    
    /**
     * Metodo che consente di trovare tutti gli user dell'applicazione che non sono amministratori.
     * 
     * @access public
     * @return array Tutti gli user non amministratori dell'applicazione
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserNonAmministratori()
    {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->cercaAppUserNonAmministratori();  
    }
    
    /**
     * Metodo che consente di trovare tutti gli user dell'applicazione che sono stati bloccati.
     * 
     * @access public
     * @return array User bloccati
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserBloccati() 
    {
       $fAmministratore = USingleton::getInstance('FAmministratore');
       return $fAmministratore->cercaAppUserBloccati(); 
    }
    
    /**
     * Metodo che consente di trovare tutti gli user dell'applicazione che sono da validare
     * 
     * @access public
     * @return array User da validare
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUserDaValidare(){
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->cercaAppUserDaValidare(); 
    }
    
    /**
     * Metodo che consente di cercare uno specifico user dell'applicazione.
     * 
     * @access public
     * @param string $idUser Username dell'user
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function cercaAppUser($idUser) {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->cercaAppUser($idUser); 
    }
    
    /**
     * Metodo che consente all'amministratore di bloccare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da bloccare
     * @return boolean TRUE se è andato a buon fine il blocco dell'user, lancia un XDBException altrimenti
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function bloccaUser($idUser) {
        $fUser = USingleton::getInstance('FUser');
        $daModificare['Bloccato'] = TRUE; 
        return $fUser->update($idUser, $daModificare);// bloccaUser
    }
    
    /**
     * Metodo che consente all'amministratore di sbloccare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da sbloccare
     * @return boolean TRUE se è andato a buon fine lo sblocco dell'user, lancia un XDBException altrimenti
     * @throws XDBException Nel caso in cui una query non abbia successo
     */
    public function sbloccaUser($idUser) {
        $fUser = USingleton::getInstance('FUser');
        $daModificare['Bloccato'] = FALSE; 
        return $fUser->update($idUser, $daModificare); //sbloccaUser
    }
    
    /**
     * Metodo che consente all'amministratore di validare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da validare
     * @return boolean TRUE se la validazione è andata a buon fine, lancia un XDBException altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function validaUser($idUser) {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        $ris = $fAmministratore->validaUser($idUser);
        return $ris ;
    }
    
    /**
     * Metodo che consente all'amministratore di confermare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da confermare
     * @return boolean TRUE se la conferma è andata a buon fine, lancia un XDBException altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function confermaUser($idUser) {
        $fUser = USingleton::getInstance('FUser');
        $daModificare['Confermato'] = TRUE;
        return $fUser->update($idUser, $daModificare);//amministratoreConfermaUser
    }
    
    /**
     * Metodo che consente all'amministratore di eliminare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da eliminare
     * @return boolean TRUE se l'eliminazione è andata a buon fine, lancia un XDBException altrimenti
     * @throws XDBException Se la query non è stata eseguita con successo
     * 
     */
    public function eliminaUser($idUser) {;
        $fUser = USingleton::getInstance('FUser');
        return $fUser->elimina($idUser); //eliminaUser
    }
    
    /**
     * Metodo che consente all'amministratore di cercare tutte le categorie degli esami dell'applicazione.
     * 
     * @access public
     * @return array Le categorie dell'applicazione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaCategorie() {
        $fCategorie = USingleton::getInstance('FCategoria');
        return $fCategorie->cerca(); //cercaCategorie
    }
    
    
}
