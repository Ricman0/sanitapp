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
     * @var int $_fax contiene il numero di fax
     */
    private $_fax;
    
    
    public function __construct($username, $password=NULL, $email=NULL, $pec=NULL, $telefono=NULL, $fax=NULL){
        if($password!==NULL && $email!==NULL && $pec!==NULL)
        {
            parent::__construct($username, $password, $email);
            parent::setTipoUser('amministratore');
            parent::setPEC($PEC);
            $this->_id = NULL; // nel db è autoincrement
            $this->_telefono = $telefono;
            $this->_fax = $fax;
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
                $this->_fax = $attributiAmministratore[0]['Fax'];
                
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
    
    public function getFax() 
    {
        return $this->_fax;
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
    
    
}
