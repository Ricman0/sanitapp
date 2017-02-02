<?php

/**
 * La classe EPrenotazione si occupa della gestione in ram delle prenotazioni. 
 *
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EPrenotazione {
    
    /*
     * Attributi della classe EPrenotazione
     */
    
    /**
     * @var string $_idPrenotazione Identificativo della prenotazione
     */
    private $_idPrenotazione;
    
    /**
     * @var string $_idEsame Identificativo dell'esame di cui si vuole effettuare la prenotazione
     */
    private $_idEsame;
    
    /**
     * @var string $_partitaIVA Partita IVA della clinica in cui si vuole effettuare la prenotazione
     */
    private $_partitaIVA;
    
    /**
     * @var string $_tipo Il tipo di utente che effettua la prenotazione (M medico, U utente) 
     */
    private $_tipo;
    
    /**
     * @var boolean $_confermata La conferma della prenotazione 
     */
    private $_confermata;
    
    /**
     * @var boolean $_eseguita La prenotazione è stata eseguita
     */
    private $_eseguita;
    
    /**
     * @var string $_codFisUtenteEffettuaEsame Il codice fiscale dell'utente che effettua l'esame
     */
    private $_codFisUtenteEffettuaEsame;
    
    /**
     * @var string $_codFisUtentePrenotaEsame Il codice fiscale dell'utente che prenota l'esame
     */
    private $_codFisUtentePrenotaEsame;
    
    /**
     * @var string $_codFisMedicoPrenotaEsame Il codice fiscale del medico che prenota l'esame
     */
    private $_codFisMedicoPrenotaEsame;
    
    /**
     * @var string $_dataEOra La data e l'ora della prenotazione
     */
    private $_dataEOra;
    
    /**
     * Costruttore della classe EPrenotazione
     * 
     * @access public
     * @param string $id L'id della prenotazione
     * @param string $idEsame L'id dell'esame
     * @param string $partitaIVAClinica La partita IVA della clinica dove si effettua la prenotazione
     * @param string $tipo Il tipo di prenotazione 'U' per utente, 'M'per medico
     * @param string $codFiscaleUtenteEffettuaEsame Il codice fiscale dell'utente che deve effettuare la prenotazione
     * @param string $codFiscalePrenotaEsame Il codice fiscale del medico o utente che ha prenotato la prenotazione
     * @param string $dataEOra La data e l'ora della prenotazione in formato YYYY-MM-DD hh:mm
     * @throws XPrenotazioneException Se la prenotazione è inesistente
     */
    public function __construct($id=NULL,$idEsame="",$partitaIVAClinica="", $tipo="", $codFiscaleUtenteEffettuaEsame=NULL,$codFiscalePrenotaEsame=NULL, $dataEOra="" ) 
    {
        if(isset($id))
        {
            $fPrenotazione = USingleton::getInstance('FPrenotazione');
//            $attributiPrenotazione = $fPrenotazione->cercaPrenotazioneById($id);
            $daCercare['IdPrenotazione'] = $id;
            $attributiPrenotazione = $fPrenotazione->cerca($daCercare);
            if(is_array($attributiPrenotazione) && count($attributiPrenotazione)==1)
            {
                
                $this->_idPrenotazione = $id;
                $this->_idEsame = $attributiPrenotazione[0]["IDEsame"];
                $this->_partitaIVA = $attributiPrenotazione[0]["PartitaIVAClinica"];
                $this->_tipo = $attributiPrenotazione[0]["Tipo"];  
                $this->_confermata = $attributiPrenotazione[0]["Confermata"];
                $this->_eseguita = $attributiPrenotazione[0]["Eseguita"];
                $this->_codFisUtenteEffettuaEsame = $attributiPrenotazione[0]["CodFiscaleUtenteEffettuaEsame"];
                $this->_codFisUtentePrenotaEsame = $attributiPrenotazione[0]["CodFiscaleUtentePrenotaEsame"];
                $this->_codFisMedicoPrenotaEsame= $attributiPrenotazione[0]["CodFiscaleMedicoPrenotaEsame"]; 
                // Creo un array dividendo la data e l'ora sulla base dello spazio
                $partiDataOra = explode(" ", $attributiPrenotazione[0]["DataEOra"]);
                // Creo un array dividendo la data YYYY-MM-DD sulla base del trattino
                $partiData = explode("-", $partiDataOra[0]); 
                // Riorganizzo gli elementi in stile DD-MM-YYYY hh:mm
                $this->_dataEOra = $partiData[2] . "-" . $partiData[1] . "-" . $partiData[0] . " " . substr($partiDataOra[1], 0, 5); 
            }
            else
            {
                
                throw new XPrenotazioneException('Prenotazione non trovata');
                // lancia un errore perchè non ha trovato una prenotazione con quell'id 
            }
        }
        else
        {
            $this->_idPrenotazione = uniqid();
            $this->_idEsame = $idEsame;
            $this->_partitaIVA = $partitaIVAClinica;
            if($tipo === "medico")
            {
                $this->_tipo ="M";
                $this->_codFisUtentePrenotaEsame = NULL;
                $this->_codFisMedicoPrenotaEsame = $codFiscalePrenotaEsame; 
                
                $this->_confermata = 'FALSE';
            }
            else
            {
                $this->_tipo = "U";
                $this->_codFisUtentePrenotaEsame = $codFiscalePrenotaEsame;
                $this->_codFisMedicoPrenotaEsame = NULL;
                $this->_confermata = TRUE;
            }           
            
            $this->_eseguita = 'FALSE';
            $this->_codFisUtenteEffettuaEsame = $codFiscaleUtenteEffettuaEsame;
            $this->setDataEOra($dataEOra);
            
        }
    }
    
    /*
     * Metodi get
     */
    
    /**
     * Metodo che permette di conoscere l'identificativo della prenotazione.
     * 
     * @access public
     * @return string L'id della prenotazione
     */
    public function getIDPrenotazionePrenotazione() 
    {
        return $this->_idPrenotazione;
    }
    
    /**
     * Metodo che permette di conoscere l'identificativo dell'esame della prenotazione.
     * 
     * @access public
     * @return string L'id dell'esame della prenotazione
     */
    public function getIDEsamePrenotazione() 
    {
        return $this->_idEsame;
    }
    
    /**
     * Metodo che permette di conoscere la partita IVA della clinica in cui si effettua la prenotazione.
     * 
     * @access public
     * @return string La partita IVA della clinica in cui si effettua la prenotazione
     */
    public function getPartitaIVAClinicaPrenotazione()  
    {
        return $this->_partitaIVA;
    }
    
    /**
     * Metodo che permette di conoscere il tipo di utente che effettua la prenotazione.
     * 
     * @access public
     * @return string Il tipo di utente che effettua la prenotazione
     */
    public function getTipoPrenotazione() 
    {
        return $this->_tipo;
    }
    
    /**
     * Metodo che permette di conoscere se la prenotazione è stata confermata.
     * 
     * @access public
     * @return boolean TRUE è stata confermata, FALSE altrimenti
     */
    public function getConfermataPrenotazione() 
    {
        return $this->_confermata;
    }
    
    /**
     * Metodo che permette di conoscere se la prenotazione è stata eseguita.
     * 
     * @access public
     * @return boolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function getEseguitaPrenotazione() 
    {
        return $this->_eseguita;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale dell'utente che effettua l'esame
     * 
     * @access public
     * @return string $_codFisUtenteEffettuaEsame Il codice fiscale dell'utente che effettua l'esame
     */
    public function getCodFiscaleUtenteEffettuaEsamePrenotazione()  
    {
        return $this->_codFisUtenteEffettuaEsame;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale dell'utente che prenota l'esame.
     * 
     * @access public
     * @return string $_codFisUtentePrenotaEsame Il codice fiscale dell'utente che prenota l'esame
     */
    public function getCodFiscaleUtentePrenotaEsamePrenotazione() 
    {
        return $this->_codFisUtentePrenotaEsame;
    }
    
    /**
     * Metodo che permette di conoscere il codice fiscale del medico che prenota l'esame.
     * 
     * @access public
     * @return string $_codFisMedicoPrenotaEsame Il codice fiscale del medico che prenota l'esame
     */
    public function getCodFiscaleMedicoPrenotaEsamePrenotazione() 
    {
        return $this->_codFisMedicoPrenotaEsame;
    }
    
    
    /**
     * Metodo che permette di conoscere la data e l'ora della prenotazione nel formato dd-mm-yyyy hh:mm.
     * 
     * @access public
     * @return string La data e l'orario della prenotazione 
     */
    public function getDataEOraPrenotazione() 
    {
        return $this->_dataEOra;
    }
    
    /**
     * Metodo che permette di conoscere la data  della prenotazione nel formato yyyy-mm-dd.
     * 
     * @access public
     * @return string La data della prenotazione 
     */
    public function getData() 
    {
        return substr($this->_dataEOra, 0, 10);
    }    
       
    /**
     * Metodo che consente di ottenere in forma di stringa tutti i valori degli attributi.
     * 
     * @access public
     * @return string $valoriAttributi Una stringa contennete tutti i valori degli attributi
     */
    public function getValoriAttributi()
    {
        $c = $this->getCodFiscaleMedicoPrenotaEsamePrenotazione();
        $valoriAttributi = "'" . $this->getIDPrenotazionePrenotazione() . "', '" .  $this->getIDEsamePrenotazione() . "', '"
                . $this->getPartitaIVAClinicaPrenotazione() . "', '" . $this->getTipoPrenotazione() . "', '"
                . $this->getConfermataPrenotazione() . "', '" . $this->getEseguitaPrenotazione() . "', '"
                . $this->getCodFiscaleUtenteEffettuaEsamePrenotazione()  . "', ";
        if ($this->getCodFiscaleUtentePrenotaEsamePrenotazione()=== NULL)
        {
            $valoriAttributi =$valoriAttributi .  "'" . $this->getCodFiscaleMedicoPrenotaEsamePrenotazione() . "', NULL ,  '";
        }
        else 
        {
            $valoriAttributi = $valoriAttributi . "NULL , '". $this->getCodFiscaleUtentePrenotaEsamePrenotazione() . "', '";
        }
        $valoriAttributi =$valoriAttributi . $this->getDataEOraPrenotazione() . "'";
        return $valoriAttributi;
    }
    /*
     * Metodi set
     */
    
    /**
     * Metodo che consente di impostare l'identificativo della prenotazione.
     * 
     * @access public
     * @param string $idPrenotazione L'id da impostare
     */
    public function setIdPrenotazione($idPrenotazione) 
    {
        $this->_idPrenotazione = $idPrenotazione;
    }
   
    /**
     * Metodo che consente di impostare l'identificativo dell'esame della prenotazione.
     * 
     * @access public
     * @param string $id L'id dell'esame da impostare
     */
    public function setIdEsamePrenotazione($id) 
    {
        $this->_idEsame = $id;
    }
    
    /**
     * Metodo che consente di impostare la partita IVA della clinica in cui si effettua la prenotazione.
     * 
     * @access public
     * @param string $partitaIVA La partita IVA della clinica in cui si effettua la prenotazione
     */
    public function setPartitaIVAPrenotazione($partitaIVA) 
    {
        $this->_partitaIVA = $partitaIVA;
    }
    
    /**
     * Metodo che permette di impostare il tipo di utente che effettua la prenotazione.
     * 
     * @access public
     * @param string $tipo Il tipo di utente che effettua la prenotazione
     */
    public function setTipoPrenotazione($tipo) 
    {
        $this->_tipo = $tipo;
    }
    
    /**
     * Metodo che permette di impostare la conferma della prenotazione.
     * 
     * @access public
     * @param boolean $confermata TRUE se è stata confermata, FALSE altrimenti
     */
    public function setConfermataPrenotazione($confermata) 
    {
        $this->_confermata = $confermata;
    }
    
    /**
     * Metodo che permette di impostare ad eseguita la prenotazione.
     * 
     * @access public
     * @param boolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function setEseguitaPrenotazione($eseguita) 
    {
        $this->_eseguita = $eseguita;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale dell'utente che effettua l'esame.
     * 
     * @access public
     * @param string $codFis Il codice fiscale dell'utente che effettua l'esameboolean $eseguita TRUE se è stata eseguita, FALSE altrimenti
     */
    public function setUtenteEffettuaEsamePrenotazione($codFis) 
    {
        $this->_codFisUtenteEffettuaEsame = $codFis;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale dell'utente che prenota l'esame.
     * 
     * @access public
     * @param string $codFis Il codice fiscale dell'utente che prenota l'esame
     */
    public function setUtentePrenotaEsamePrenotazione($codFis) 
    {
        $this->_codFisUtentePrenotaEsame = $codFis;
    }
    
    /**
     * Metodo che permette di impostare il codice fiscale del medico che prenota l'esame.
     * 
     * @access public
     * @param string $codFis Il codice fiscale del medico che prenota l'esame
     */
    public function setMedicoPrenotaEsamePrenotazione($codFis ) 
    {
        $this->_codFisMedicoPrenotaEsame = $codFis ;
    }
    
    /**
     * Metodo che permette di impostare la data e l'ora della prenotazione.
     * 
     * @access public
     * @param string La data e l'orario della prenotazione in formato dd-mm-yyyy hh:ii
     */
    public function setDataEOra($dataEOra) 
    {
        $giorno = substr($dataEOra, 0, 2);
        $anno = substr($dataEOra, 6, 4);
        $dataEOra = $anno . substr(str_replace($anno, $giorno, $dataEOra), 2);      
        $this->_dataEOra = $dataEOra;
    }
    
    
    
    /**
     * Aggiunge la prenotazione nel DB.
     * 
     * @access public
     * @return boolean TRUE se la prenotazione è stata aggiunta con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function aggiungiPrenotazioneDB() 
    {
        $fPrenotazione = USingleton::getInstance('FPrenotazione');
//        return $fPrenotazione->aggiungiPrenotazione($this);
        return $fPrenotazione->inserisci($this);
    }
    
    /**
     * Metodo che consente di confermare la prenotazione.
     * 
     * @access public
     * @return boolean TRUE se la conferma è andata a buon fine
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function confermaPrenotazione() 
    {
        $this->setConfermataPrenotazione(TRUE);
        $fPrenotazione = USingleton::getInstance('FPrenotazione');
//        if ($fPrenotazione->confermaPrenotazione($this->_idPrenotazione) === TRUE) 
        $daModificare['Confermata'] = TRUE;
        $confermato = $fPrenotazione->update($this->_idPrenotazione, $daModificare);
        return TRUE;
//        if ($confermato===TRUE)
//        {
//            return TRUE;
//        } 
//        else 
//        {
//            return FALSE;
//        }
    }
    
    /**
     * Permette di capise se alla prenotazione è già associato il referto.
     * 
     * @access public
     * @return boolean true se alla prenotazione è già associato il referto
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function esisteReferto() {
        
        $fReferto = USingleton::getInstance('FReferto');
//        if($fReferto->cercaReferto($this->_idPrenotazione))
        $daCercare['IDPrenotazione'] = $this->getIDPrenotazionePrenotazione();
        $fReferto->cerca($daCercare);
        return TRUE;
//        if($fReferto->cerca($daCercare))
//        {
//            return TRUE;
//        }
//        else
//        {
//            return FAlSE;
//        }
        
    }
    
    /**
     * Metodo che consente di eliminare la prenotazione.
     * 
     * @access public
     * @return boolean TRUE eliminazione avvenuta con successo, FALSE altrimenti
     * @throws XPrenotazioneException Se la prenotazione è già eseguita
     * @throws XDBException Se la query per eliminare la prenotazione specificata non è stata eseguita con successo
     */
    public function eliminaPrenotazione() 
    {
        if($this->_eseguita==FALSE) // se la prenotazione non è stata eseguita allora si può cancellare, altrimenti no.  
        {
            $fPrenotazione = USingleton::getInstance('FPrenotazione');
//            return $fPrenotazione->eliminaPrenotazione($this->getIDPrenotazionePrenotazione());
            return $fPrenotazione->elimina($this->getIDPrenotazionePrenotazione());
        }
        else
        {
            throw new XPrenotazioneException('Prenotazione già eseguita');
        }
    }
    
    /**
     * Metodo che consente di modificare la data e l'orario della prenotazione nel DB.
     * 
     * @access public
     * @param string $data La data nel formato dd-mm-yyyy
     * @param string $ora L'orario della prenotazione in formato hh:mm
     * @return boolean TRUE se la query è stata eseguita con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaPrenotazione($data, $ora) 
    {
        $dataEOra= $data . " " . $ora;
        $this->setDataEOra($dataEOra);
        $daModificare['DataEOra'] = $this->getDataEOraPrenotazione();
        
        $fPrenotazione = USingleton::getInstance('FPrenotazione');
        return $fPrenotazione->update($this->getIDPrenotazionePrenotazione(), $daModificare);
    }
    
    /**
     * Confronta la data della prenotazione con quella odierna.
     * 
     * @access public
     * @return boolean TRUE se la data di ieri è precedente alla data di prenotazione esame
     */
    public function controllaData()
    {
        $dataPrenotazione = $this->getData(); // recupero la stringa data in formato Y-m-d
        $dataPrenotazione =  substr($dataPrenotazione, 6, 4). '-' . substr($dataPrenotazione, 3,2) . '-' . substr($dataPrenotazione, 0,2);
       
        $dataPrenotazione = strtotime($dataPrenotazione); // timestamp della data di prenotazione che era string
        
//        $dataPrenotazione = strtotime($dataPrenotazione); // la converto in un timestamp
//        // devo usare il timestamp altrimenti potrebbero esserci problemi nel caso di mesi/ anni diversi 
//        // ad esempio data di prenotazione 16-03-2013 e la data odierna 11-04-2013
        
//        $dataOdierna = strtotime(date('Y-m-d')); // prendo la data odierna in questo modo posso effettuare il confronto
       
        
        $dataOdierna = date('Y-m-d'); // data odierna
        
        $dataOdierna = date_parse_from_format("Y-m-d",  $dataOdierna); // rendo array la data odierna
        // osservazione: dal momento che uso il formato Y-m-d non c'è bisogno di effettuare la conversione in timestamp
        $ieri = mktime ( 0, 0 , 0, $dataOdierna['month'] , $dataOdierna['day']-1, $dataOdierna['year']); // sottraggo un giorno (quindi ) e ottengo ieri in timestamp
        
        if($ieri < $dataPrenotazione)
        { // se la data di ieri è precedente a quella di prenotazione
            return TRUE;
        }
        else
        { // codice da eseguire se la data di ieri è successiva alla data di prenotazione
            return FALSE;
        }
         
        
        
    }
    
    /**
     * Metodo che consente di modificare lo stato di esecuzione di una prenotazione nel DB.
     * 
     * @access public
     * @param boolean $eseguita Indica se la prenotazione è stata modificata
     * @return boolean TRUE se la query è stata eseguita con successo
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function modificaEseguitaPrenotazione($eseguita)
    {
        $prenotazioneEseguita = $this->getEseguitaPrenotazione();
        $dataPrenotazione = $this->getData(); // recupero la stringa data in formato Y-m-d
        
//        // devo usare il timestamp altrimenti potrebbero esserci problemi nel caso di mesi/ anni diversi 
//        // ad esempio data di prenotazione 16-03-2013 e la data odierna 11-04-2013
        $dataOdierna = strtotime(date('Y-m-d')); // prendo la data odierna in questo modo posso effettuare il confronto
       
       // osservazione: dal momento che uso il formato Y-m-d non c'è bisogno di effettuare la conversione in timestamp
//        $data = date_parse_from_format("Y-m-d",  $dataPrenotazione);
//        $data = mktime ( 0, 0 , 0, $data['month'] , $data['day']-1, $data['year']); //ora, minuti, secondi, mesi, giorno, anno
        $data = strtotime($dataPrenotazione);
        if( $eseguita==='true') // se la dataOdierna è succesiva o uguale a $data 
        {
            if($dataOdierna >= $data)
            {
                $this->setEseguitaPrenotazione(TRUE);
                $prenotazioneEseguita = TRUE; 
            }
              
        }
        else
        {
            if($dataOdierna >= $data)
            {
                $this->setEseguitaPrenotazione(FALSE);
                $prenotazioneEseguita = FALSE;  
            }
             
        }
        $this->setEseguitaPrenotazione($prenotazioneEseguita);
        $fPrenotazione = USingleton::getInstance('FPrenotazione');
//        return $fPrenotazione->modificaPrenotazioneEseguita($this->getIDPrenotazionePrenotazione(), $eseguita);
        $daModificare['Eseguita'] = $prenotazioneEseguita;
        return $fPrenotazione->update($this->getIDPrenotazionePrenotazione(), $daModificare);
    }
}
