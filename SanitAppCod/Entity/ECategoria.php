<?php

/**
 * La classe ECategoria si occupa della gestione in ram delle categorie.
 *
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class ECategoria {
    
    /**
     * @var string Il nome della categoria 
     */
    private $_nome;
    
    /**
     * Costruttore della classe ECategoria.
     * 
     * @access public
     * @param string nome il nome della categoria
     */
    public function __construct($nome) {
        $this->_nome = $nome;    
    }
    
    /**
     * Metodo che ritorna il nome della categoria.
     * 
     * @access public
     * @return string Il nome della categoria
     */
    public function getNomeCategoria() {
        return $this->_nome;
    }
    
    /**
     * Metodo che consente di aggiungere una categoria.
     * 
     * @access public
     * @return boolean TRUE se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione.
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function aggiungiCategoria() {
        $fCategorie = USingleton::getInstance('FCategoria');
        return $fCategorie->inserisci($this); //aggiungiCategoria
    }
    
    /**
     * Metodo che consente una categoria se non ci sono esami che rientrano in quella categoria.
     * 
     * @access public
     * @return string|boolean string nel caso non sia possibile eliminare la categoria, TRUE se la query è eseguito con successo, altrimenti lancia eccezione
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function eliminaCategoria() {
        if($this->checkIfCanDelete()===TRUE)
        {
            $fCategorie = USingleton::getInstance('FCategoria');
            return $fCategorie->elimina($this->getNomeCategoria()); //eliminaCategoria
        }
        else
        {
            $messaggio = 'Non è possibile eliminare la categoria poichè ci sono esami con quella categoria';
            return $messaggo;
        }
        
    }
    
    /**
     * Metodo che consente di controllare se una categoria può essere cancellata.
     * 
     * @access public
     * @return boolean FALSE se la categoria non può essere cancellata poichè 
     *          esiste un esame appartenente a quella categoria, TRUE se può essere cancellata, altrimenti lancia un'eccezione
     * @throws XDBException Se la query non è eseguita con successo
     */
    public function checkIfCanDelete() {
        $fEsami = USingleton::getInstance('FEsame');
        $daCercare['NomeCategoria'] = $this->getNomeCategoria(); 
        $esami = $fEsami->cerca($daCercare); //cercaEsamiByCategoria
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
