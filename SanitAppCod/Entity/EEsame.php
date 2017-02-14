<?php

/**
 * La classe EEsame si occupa della gestione in ram degli esami.
 *
 * @package Entity
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
     * @var string $_durata Il tempo impiegato per effettuare l'esame hh:mm
     */
    private $_durata; 
    
    /**
     * @var string $_medicoEsame Il medico che effettua l'esame
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
     * @var string $_partitaIVAClinica La partita IVA della clinica a cui appartiene 
     * tale esame
     */
    private $_partitaIVAClinica; 
    
    /**
     * @var boolean $_eliminato Indica se l'esame p stato eliminato dalla clinica o no. 
     */
    private $_eliminato;
    
    /**
     * @var array $_prenotazioni array(EPrenotazione) che contiente le 
     * prenotazioni relativa all'esame. Realizza l'associazione con la classe EPrenotazione.
     */
    private $_prenotazioni = Array();
    
    
    /**
     * Costruttore di EEsame
     * 
     * @access public
     * @param string $id ID dell'esame
     * @param string $nomeEsame Il nome dell'esame
     * @param string $medico Il nome e cognome del medico che effettua l'esame
     * @param string $nomeCategoria La categoria a cui appartiene l'esame
     * @param float $prezzo Il prezzo dell'esame
     * @param string $durata La durata dell'esame 
     * @param int $numPrestazioniSimultanee Il numero di prestazioni simultanee dell'esame
     * @param string $descrizione Breve descrizione dell'esame
     * @param string $partitaIVAClinica La partita IVA della clinica
     * @throws XEsameException Se l'esame non esiste
     */
  
    public function __construct($id=NULL, $nomeEsame="", $medico="", $nomeCategoria="", $prezzo="", $durata="", $numPrestazioniSimultanee=1, $descrizione='', $partitaIVAClinica="") 
    {
        if(isset($id))
        {
            $fEsame = USingleton::getInstance('FEsame');
            $daCercare['IDEsame'] = $id;
            $attributiEsame = $fEsame->cerca($daCercare); // cerco l'esame by ID
            if(is_array($attributiEsame) && count($attributiEsame)==1)
            { 
                $this->_idEsame = $id;
                $this->_nomeEsame = $attributiEsame[0]["NomeEsame"];
                $this->_medicoEsame = $attributiEsame[0]["MedicoEsame"];
                $this->_nomeCategoria = $attributiEsame[0]["NomeCategoria"];  
                $this->_prezzo = $attributiEsame[0]["Prezzo"];
                $this->_durata = substr($attributiEsame[0]["Durata"],0,5);
                $this->_numeroPrestazioniSimultanee = $attributiEsame[0]["NumPrestazioniSimultanee"];
                $this->_descrizione = $attributiEsame[0]["Descrizione"];
                $this->_partitaIVAClinica= $attributiEsame[0]["PartitaIVAClinica"];
                $this->_eliminato= $attributiEsame[0]["Eliminato"];
                $this->_prenotazioni = Array();
            }
            else
            {
                throw new XEsameException('Esame non esistente');
            }
        }
        else
        {
            $this->_idEsame = uniqid($partitaIVAClinica);
            $this->_nomeEsame = $nomeEsame;
            $this->_medicoEsame = $medico;
            $this->_nomeCategoria = $nomeCategoria;  
            $this->_prezzo = $prezzo;
            $this->_durata = $durata;
            $this->_numeroPrestazioniSimultanee = $numPrestazioniSimultanee;
            $this->_descrizione = $descrizione;
            $this->_partitaIVAClinica = $partitaIVAClinica;
            $this->_eliminato ='FALSE';
            $this->_prenotazioni = Array();
            
        }
    }
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EEsame nel DB.
     * 
     * @access public
     * @return Boolean TRUE se l'esame è stato inserito correttamente
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function inserisciEsameDB() 
    {
        //crea un oggetto fEsame se non è esistente, si collega al DB e lo inserisce
        $fEsame = USingleton::getInstance('FEsame');
        return $fEsame->inserisci($this);   //inserisciEsame
    }
    
    /**
     * Metodo che restituisce l'id dell'esame.
     * 
     * @access public
     * @return string l'id dell'esame
     */
    public function getIDEsameEsame()
    {
        return $this->_idEsame;
    }
    
    /**
     * Metodo che restituisce se l'esame è stato eliminato oppure no.
     * 
     * @access public
     * @return boolean TRUE l'esame è stato eliminato, FALSE altrimenti
     */
    public function getEliminatoEsame() {
        return $this->_eliminato;
    }
    
    /**
     * Metodo che restituisce il nome dell'esame.
     * 
     * @access public
     * @return string Il nome dell'esame
     */
    public function getNomeEsameEsame()
    {
        return $this->_nomeEsame;
    }
    
    /**
     * Metodo che restituisce la partita IVA della clinica.
     * 
     * @access public
     * @return string La partita IVA della clinica 
     */
    public function getPartitaIVAClinicaEsame()
    {
        return $this->_partitaIVAClinica;
    }
    
    /**
     * Metodo che restituisce la descrizione dell'esame.
     * 
     * @access public
     * @return string La descrizione dell'esame
     */
    public function getDescrizioneEsame()
    {
        return $this->_descrizione;
    }
    
    /**
     * Metodo che restituisce il prezzo in euro dell'esame.
     * 
     * @access public
     * @return float Il prezzo dell'esame
     */
    public function getPrezzoEsame()
    {
        return $this->_prezzo;
    }
    
    /**
     * Metodo che restituisce il tempo impiegato per effettuare l'esame.
     * 
     * @access public
     * @return string La durata dell'esame
     */
    public function getDurataEsame()
    {
        return $this->_durata;
    }
    
    /**
     * Metodo che restituisce il nominativo del medico che effettua l'esame.
     * 
     * @access public
     * @return string Il medico dell'esame
     */
    public function getMedicoEsameEsame()
    {
        return $this->_medicoEsame;
    }
    
    /**
     * Metodo che restituisce il numero di prestazioni che possono avvenire
     * simultaneamente.
     * 
     * @access public
     * @return int Numero prestazioni simultanee dell'esame
     */
    public function getNumPrestazioniSimultaneeEsame()
    {
        return $this->_numeroPrestazioniSimultanee;
    }
    
    /**
     * Metodo che restituisce il nome della categoria a cui appartiene l'esame.
     * 
     * @access public
     * @return string Categoria dell'esame
     */
    public function getNomeCategoriaEsame()
    {
        return $this->_nomeCategoria;
    }
    
    /**
     * Metodo per conoscere le prenotazioni associate all'esame.
     * 
     * @access public
     * @return array Le prenotazioni relative l'esame
     */
    public function getPrenotazioniEsame() {
        return $this->_prenotazioni;
    }
    
    /**
     * Metodo che permette la modifica del nome dell'esame.
     * 
     * @access public
     * @param string $nome Nome dell'esame
     */
    public function setNomeEsame( $nome)
    {
        $this->_nomeEsame= $nome;
    }
    
    /**
     * Metodo che permette la modifica della descrizione dell'esame.
     * 
     * @access public
     * @param string $descrizione La descrizione dell'esame
     */
    public function setDescrizioneEsame( $descrizione)
    {
        $this->_descrizione= $descrizione;
    }
    
    /**
     * Metodo che permette la modifica della descrizione dell'esame.
     * 
     * @access public
     * @param boolean $eliminato TRUE se l'esame deve essere, FALSE altrimenti. 
     */
    public function setEliminato($eliminato)
    {
        $this->_eliminato= $eliminato;
    }
    
    /**
     * Metodo che permette di modificare il prezzo in euro dell'esame.
     * 
     * @access public
     * @param  float $prezzo Il prezzo dell'esame
     */
    public function setPrezzoEsame($prezzo)
    {
        $this->_prezzo = $prezzo;
    }
    
    /**
     * Metodo che permette di modificare il tempo impiegato 
     * per effettuare l'esame.
     * 
     * @access public
     * @return string $durata La durata dell'esame
     */
    public function setDurataEsame($durata)
    {
        $this->_durata =$durata;
    }
    
    /**
     * Metodo che permette di modificare il nominativo del medico che effetua l'esame.
     * 
     * @access public
     * @param string $medicoEsame Il medico dell'esame
     */
    public function setMedicoEsame($medicoEsame)
    {
        $this->_medicoEsame = $medicoEsame;
    }
    
    /**
     * Metodo che permette di modificare il numero di prestazioni che possono 
     * avvenire simultaneamente.
     * 
     * @access public
     * @param  int $num Numero prestazioni simultanee dell'esame
     */
    public function setNumeroPrestazioniSimultaneeEsame($num)
    {
        $this->_numeroPrestazioniSimultanee = $num;
    }
    
    /**
     * Metodo che permette di modificare il nome della categoria a cui appartiene l'esame.
     * 
     * @access public
     * @param string $nomeCategoria
     */
    public function setNomeCategoriaEsame($nomeCategoria)
    {
        $this->_nomeCategoria= $nomeCategoria;
    }
    
    /**
     * Metodo che permette di impostare le prenotazioni relative all'esame.
     * 
     * @access public
     * @param array $prenotazioni Prenotazioni relative all'esame
     */
    public function setPrenotazioniEsame($prenotazioni ) {
        $this->_prenotazioni = $prenotazioni ;
    }
    
    /**
     * Metodo che consente di modificare i dati dell'esame.
     * 
     * @access public
     * @param array $datiEsame I dati dell'esame da modificare
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaEsame($datiEsame) {
        $daModificare;
        foreach ($datiEsame as $key => $value) {
            switch ($key) {
                case 'nome':
                    $this->setNomeEsame($value);
                    $daModificare['NomeEsame'] = $value;
                    break;
                case 'medicoResponsabile':
                    $this->setMedicoEsame($value);
                    $daModificare['MedicoEsame'] = $value;
                    break;
                case 'categoria':
                    $this->setNomeCategoriaEsame($value);
                    $daModificare['NomeCategoria'] = $value;
                    break;
                case 'prezzo':
                    $this->setPrezzoEsame($value);
                    $daModificare['Prezzo'] = $value;
                    break;
                case 'durataEsame':
                    $this->setDurataEsame($value);
                    $daModificare['Durata'] = $value;
                    break;
                case 'descrizione':
                    $this->setDescrizioneEsame($value);
                    $daModificare['Descrizione'] = $value;
                    break;
                
                default:
                    break;
            }
        }
        $fEsame = USingleton::getInstance('FEsame');
        return $fEsame->update($this->getIDEsameEsame(), $daModificare); //modificaEsame
    }
    
    /**
     * Metodo che consente di eliminare l'esame (In realtà dal db non viene eliminato, viene solo settato come eliminato).
     * 
     * @access public
     * @return boolean TRUE se la query è eseguito con successo, altrimenti lancia eccezione
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function eliminaEsame() {
        $this->setEliminato(TRUE);
        $fEsame = USingleton::getInstance('FEsame');
        return $fEsame->elimina($this->getIDEsameEsame()); //eliminaEsame
    }
}
