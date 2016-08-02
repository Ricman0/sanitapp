<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EEsame
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EEsame 
{
    /*
     * Attributi della classe EEsame
     */
    
    /**
     * @var string $_idEsame Identificativo dell'esame
     */
    private $_idEsame;
    
    /**
     * @var string $_nomeEsame Il nome dell'esame
     */
    private $_nomeEsame; 
    
    /**
     * @var string $_descrizione La descrizione dell'esame
     */
    private $_descrizione; 
    
    /**
     * @var float $_prezzo Il prezzo in euro dell'esame
     */
    private $_prezzo; 
    
    /**
     * @var int $_durata Il tempo (in minuti) impiegato per effettuare l'esame
     */
    private $_durata; 
    
    /**
     * @var string $_medicoEsame Il medico (o il nome dei medici)che 
     * effettua l'esame
     */
    private $_medicoEsame; 
    
    /**
     * @var int $_numeroPrestazioniSimultanee Il numero di esami che possono 
     * essere effettuati contemporaneamente
     */
    private $_numeroPrestazioniSimultanee; 
    
    /**
     * @var string $_nomeCategoria Il nome della categoria a cui appartiene 
     * tale esame
     */
    private $_nomeCategoria; 
    
    /**
     * Costruttore di EEsame
     * 
     * @param string $id
     * @param string $nomeEsame
     * @param float $prezzo
     * @param int $durata
     * @param string $medico
     * @param string $nomeCategoria
     * 
     */
    public function __construct($id, $nomeEsame, $prezzo, $durata, $medico, $nomeCategoria) 
    {
        $this->_nomeEsame = $nomeEsame;
        $this->_descrizione = '';
        $this->_prezzo = $prezzo;
        $this->_durata = $durata;
        $this->_medicoEsame = $medico;
        $this->_numeroPrestazioniSimultanee = 1;
        $this->_nomeCategoria = $nomeCategoria;  
    }
    
    /**
     * Costruttore di EEsame
     * 
     * @param string $nomeEsame
     * @param string $descrizione
     * @param float $prezzo
     * @param int $durata
     * @param string $medico
     * @param string $nomeCategoria
     * 
     */
    public function __construct($nomeEsame, $descrizione, $prezzo, $durata, $medico, $nomeCategoria) 
    {
        $this->_nomeEsame = $nomeEsame;
        $this->_descrizione = $descrizione;
        $this->_prezzo = $prezzo;
        $this->_durata = $durata;
        $this->_medicoEsame = $medico;
        $this->_numeroPrestazioniSimultanee = 1;
        $this->_nomeCategoria = $nomeCategoria;  
    }
    
    /**
     * Costruttore di EEsame
     * 
     * @param string $nomeEsame
     * @param string $descrizione
     * @param float $prezzo
     * @param int $durata
     * @param string $medico
     * @param int $numPrestazioni
     * @param string $nomeCategoria
     * 
     */
    public function __construct($nomeEsame, $descrizione, $prezzo, $durata,
            $medico,$numPrestazioni,  $nomeCategoria) 
    {
        $this->_nomeEsame = $nomeEsame;
        $this->_descrizione = $descrizione;
        $this->_prezzo = $prezzo;
        $this->_durata = $durata;
        $this->_medicoEsame = $medico;
        $this->_numeroPrestazioniSimultanee = $numPrestazioni;
        $this->_nomeCategoria = $nomeCategoria;  
    }
    
    /**
     * Metodo che restituisce il nome dell'esame
     * 
     * @return string Il nome dell'esame
     */
    public function getNomeEsame()
    {
        return $this->_nomeEsame;
    }
    
    
    /**
     * Metodo che restituisce la descrizione dell'esame
     * 
     * @return string La descrizione dell'esame
     */
    public function getDescrizioneEsame()
    {
        return $this->_descrizione;
    }
    
    /**
     * Metodo che restituisce il prezzo in euro dell'esame
     * 
     * @return float Il prezzo dell'esame
     */
    public function getPrezzoEsame()
    {
        return $this->_prezzo;
    }
    
    /**
     * Metodo che restituisce il tempo (in minuti)impiegato per effettuare l'esame
     * 
     * @return int La durata dell'esame
     */
    public function getDurataEsame()
    {
        return $this->_durata;
    }
    
    /**
     * Metodo che restituisce il nominativo del medico che effetua l'esame
     * 
     * @return string Il medico dell'esame
     */
    public function getMedicoEsame()
    {
        return $this->_medicoEsame;
    }
    
    /**
     * Metodo che restituisce il numero di prestazioni che possono avvenire
     * simultaneamente
     * 
     * @return int Numero prestazioni simultanee dell'esame
     */
    public function getNumeroPrestazioniSimultaneeEsame()
    {
        return $this->_numeroPrestazioniSimultanee;
    }
    
    /**
     * Metodo che restituisce il nome della categoria a cui appartiene l'esame
     * 
     * @return string Categoria dell'esame
     */
    public function getNomeCategoriaEsame()
    {
        return $this->_nomeCategoria;
    }
    
    /**
     * Metodo che permette la modifica del nome dell'esame
     * 
     * @param string $nome Nome dell'esame
     */
    public function setNomeEsame( $nome)
    {
        $this->_nomeEsamee= $nome;
    }
    
    /**
     * Metodo che permette la modifica della descrizione dell'esame
     * 
     * @param string $descrizione La descrizione dell'esame
     */
    public function setDescrizioneEsame( $descrizione)
    {
        $this->_descrizione= $descrizione;
    }
    
    /**
     * Metodo che permette di modificare il prezzo in euro dell'esame
     * 
     * @param  float $prezzo Il prezzo dell'esame
     */
    public function setPrezzoEsame($prezzo)
    {
        $this->_prezzo = $prezzo;
    }
    
    /**
     * Metodo che permette di modificare il tempo (in minuti)impiegato 
     * per effettuare l'esame
     * 
     * @return int $durata La durata dell'esame
     */
    public function setDurataEsame($durata)
    {
        $this->_durata =$durata;
    }
    
    /**
     * Metodo che permette di modificare il nominativo del medico che effetua l'esame
     * 
     * @param string $medicoEsame Il medico dell'esame
     */
    public function setMedicoEsame($medicoEsame)
    {
        $this->_medicoEsame = $medicoEsame;
    }
    
    /**
     * Metodo che permette di modificare il numero di prestazioni che possono 
     * avvenire simultaneamente
     * 
     * @param  int $num Numero prestazioni simultanee dell'esame
     */
    public function setNumeroPrestazioniSimultaneeEsame($num)
    {
        $this->_numeroPrestazioniSimultanee = $num;
    }
    
    /**
     * Metodo che permette di modificare il nome della categoria a cui appartiene l'esame
     * 
     * @param string $nomeCategoria
     */
    public function setNomeCategoriaEsame($nomeCategoria)
    {
        $this->_nomeCategoria= $nomeCategoria;
    }
}
