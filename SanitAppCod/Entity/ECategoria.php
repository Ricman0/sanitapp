<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ECategoria
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class ECategoria {
    
    
    private $_nome;
    
    /*
     * Costruttore della classe Categoria
     * 
     * @param string nome il nome della categoria
     */
    public function __construct($nome) {
        
        $this->_nome = $nome;
        
    }
    
    /*
     * Metodo che ritorna il nome della categoria
     * 
     * @return type string  nome della categoria
     */
    public function getNome() {
        return $this->_nome;
    }
    
    /**
     * Metodo che consente di aggiungere una categoria.
     * 
     * @access public
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     */
    public function aggiungiCategoria() {
        $fCategorie = USingleton::getInstance('FCategoria');
        return $fCategorie->aggiungiCategoria($this); 
    }
    
    /**
     * Metodo che consente una categoria se non ci sono esami che rientrano in quella categoria.
     * 
     * @access public
     */
    public function eliminaCategoria() {
        if($this->checkIfCanDelete()===TRUE)
        {
            $fCategorie = USingleton::getInstance('FCategoria');
            return $fCategorie->eliminaCategoria($this->getNome()); 
        }
        else
        {
            $messaggio = 'Non è possibile eliminare la categoria poichè ci sono esami con quella categoria';
            return $messaggio;
        }
        
    }
    
    /**
     * Metodo che consente di controllare se una categoria può essere cancellata.
     * 
     * @access public
     */
    public function checkIfCanDelete() {
        $fEsami = USingleton::getInstance('FEsame');
        $esami = $fEsami->cercaEsamiByCategoria($this->getNome());
        if(count($esami)>0)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
            
        }
    }
    
    
}
