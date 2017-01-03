<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EAmministratore
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EAmministratore extends EUser{
    /**
     * @var int $_id contiente l'id dell'amministratore
     */
    private $_id;
    
    /**
     * @var int $_telefono contiene il numero dell'amministratore
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
    
    
    public function __construct($username, $password=NULL, $email=NULL, $PEC=NULL, $telefono=NULL, $nome=NULL, $cognome= NULL){
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
                parent::setCodiceConfermaUtente($attributiAmministratore[0]['CodiceConferma']);
                parent::setTipoUser($attributiAmministratore[0]['TipoUser']);
                $this->_id = $attributiAmministratore[0]['IdAmministratore']; // nel db è autoincrement
                $this->_telefono = $attributiAmministratore[0]['Telefono'];
                $this->_nome = $attributiAmministratore[0]['Nome'];
                $this->_cognome = $attributiAmministratore[0]['Cognome'];
                
            }
        }
        
    }
    
    public function getID() 
    {
        return $this->_id;
    }
    
    public function getTelefono() 
    {
        return $this->_telefono;
    }
    
    
    /**
     * Metodo per conoscere il nome dell'amministratore
     * 
     * @access public
     * @return string Il nome dell'amministratore
     */
    public function getNomeUtente() {
        return ucwords($this->_nome);
    }

    /**
     * Metodo per conoscere il cognome dell'amministratore
     * 
     * @return string Il cognome dell'amministratore
     */
    public function getCognomeUtente() {
        return ucwords($this->_cognome);
    }
    
    /**
     * Metodo che permette di modificare il nome dell'amministratore
     * 
     * @access public
     * @param string $nome Il nome dell'amministratore
     */
    public function setNome($nome) {
        $this->_nome = $nome;
    }

    /**
     * Metodo che permette di modificare il cognome dell'amministratore
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
     * @return Array Tutti gli user non amministratori dell'applicazione
     */
    public function cercaAppUserNonAmministratori()
    {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->cercaAppUserNonAmministratori();
        
    }
    
    /**
     * Metodo che consente di trovare tutti gli user dell'applicazione che sono stati bloccati
     * 
     * @access public
     * @return Array User bloccati
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
     * @return Array User da validare
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
     */
    public function bloccaUser($idUser) {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->bloccaUser($idUser);
    }
    
    /**
     * Metodo che consente all'amministratore di sbloccare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da sbloccare
     * @return boolean TRUE se è andato a buon fine lo sblocco dell'user, lancia un XDBException altrimenti
     */
    public function sbloccaUser($idUser) {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->sbloccaUser($idUser);
    }
    
    /**
     * Metodo che consente all'amministratore di validare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da validare
     * @return boolean TRUE se la validazione è andata a buon fine, lancia un XDBException altrimenti
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
     */
    public function confermaUser($idUser) {
        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->amministratoreConfermaUser($idUser);
    }
    
    /**
     * Metodo che consente all'amministratore di eliminare uno user.
     * 
     * @access public
     * @param string $idUser L'username dello user da eliminare
     * @return boolean TRUE se l'eliminazione è andata a buon fine, lancia un XDBException altrimenti
     */
    public function eliminaUser($idUser) {

        $fAmministratore = USingleton::getInstance('FAmministratore');
        return $fAmministratore->eliminaUser($idUser);
    }
    
    /**
     * Metodo che consente all'amministratore di cercare tutte le categorie degli esami dell'applicazione.
     * 
     * @access public
     * @return Array TLe categorie dell'applicazione
     */
    public function cercaCategorie() {
        $fCategorie = USingleton::getInstance('FCategoria');
        return $fCategorie->cercaCategorie(); 
    }
    
    
}
