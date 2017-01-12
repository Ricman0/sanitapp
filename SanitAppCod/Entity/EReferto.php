<?php
/**
 * Description of EReferto
 * 
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EReferto {
    /*
     * Attributi della classe EReferto
     */

    /**
     * @var string $_IDReferto Identificativo del referto 
     * Suppongo di mettere "R+IDPrenotazione"
     */
    private $_IDReferto;

    /**
     *
     * @var string id della prenotazione realtiva all referto
     */
    private $_idPrenotazione;

    /**
     *
     * @var string $_idEsame identificativo dell'esame relativo al referto
     */
    private $_idEsame;

    /**
     * @var string $_medicoReferto Cognome e nome del medico che scrive il referto 
     */
    private $_medicoReferto;

    /**
     * @var string $_contenuto Il file referto
     */
    private $_contenuto;

    /**
     * @var string $_fileName Il nome del file referto
     */
    private $_fileName;
    
    
    /**
     * @var date $_dataReferto la data di inserimento del referto
     */
    private $_dataReferto;

    /**
     *
     * @var string $_partitaIVAClinica partita iva della clinica che emette il referto
     */
    private $_partitaIVAClinica;
    
    /**
     * @var string $_condivisoConUtente Gli user con i quali il referto è stato condiviso 
     */
    private $_condivisoConUtente;
    
    /**
     * @var boolean $_condivisoConMedico Indica se il referto è stato condiviso con il medico
     */
    private $_condivisoConMedico;


    /**
     * Costruttore di EReferto
     * 
     * @param string $medico
     * @param blob $contenuto
     * @throws XRefertoException 
     */
    public function __construct($idPrenotazione, $partitaIvaClinica = NULL, $idEsame = NULL, $medico = NULL, $contenuto = NULL, $fileName= NULL) {
        if ($medico !== NULL) { //caso nuovo referto
            $this->_IDReferto = uniqid();
            $this->_idPrenotazione = $idPrenotazione;
            $this->_idEsame = $idEsame;
            $this->_partitaIVAClinica = $partitaIvaClinica;
            $this->_medicoReferto = $medico;
            $this->_contenuto = $contenuto;
            $this->_fileName = $fileName;
            $this->_dataReferto = date('Y-m-d', time());
            $this->_condivisoConMedico= 'FALSE';
            $this->_condivisoConUtente = NULL;
        } else { //caso referto recuperato dal db
            $fReferto = USingleton::getInstance('FReferto');
            $risultato = $fReferto->cercaReferto($idPrenotazione);
            if (is_array($risultato) && count($risultato) === 1) {
                $this->_IDReferto = $risultato[0]['IDReferto'];
                $this->_idPrenotazione = $risultato[0]['IDPrenotazione'];
                $this->_idEsame = $risultato[0]['IDEsame'];
                $this->_partitaIVAClinica = $risultato[0]['PartitaIVAClinica'];
                $this->_medicoReferto = $risultato[0]['MedicoReferto'];
                $this->_contenuto = $risultato[0]['Contenuto'];
                $this->_fileName = $risultato[0]['FileName'];
                $this->_dataReferto = $risultato[0]['DataReferto'];
                $this->_condivisoConMedico = $risultato[0]['CondivisoConMedico'];
                $this->_condivisoConUtente = $risultato[0]['CondivisoConUtente'];
            } else { //nessun risultato relativo a quella prenotazione
                throw new XRefertoException('Referto inesistente');
            }
        }
    }

    //metodi get
    /**
     * Metodo che restituisce l'identificativo del referto
     * 
     * @return string L'id del referto
     */
    public function getIDReferto() {
        return $this->_IDReferto;
    }

    /**
     * Metodo per conoscere gli user con i quali il referto è stato condiviso  in formato JSON
     * 
     * @return string Gli user con i quali il referto è stato condiviso 
     */
    public function getCondivisoConUtenteReferto() {
        return $this->_condivisoConUtente;
    }
    
    /**
     * Metodo per conoscere se il referto è stato condiviso con il medico curante
     * 
     * @return boolean TRUE il referto è stato condiviso con il medico curante, FALSE altrimenti.
     */
    public function getCondivisoConMedicoReferto() {
        return $this->_condivisoConMedico;
    }
    
    
    /**
     * Metodo che restituisce l'identificativo della prenotazione
     * 
     * @return string L'id della prenotazione
     */
    public function getIDPrenotazione() {
        return $this->_idPrenotazione;
    }

    /**
     * Metodo che restituisce l'identificativo dell'esame
     * 
     * @return string L'id dell'esame
     */
    public function getIDEsame() {
        return $this->_idEsame;
    }

    /**
     * Metodo che restituisce la partita iva della clinica
     * 
     * @return string la partita iva della clinica
     */
    public function getPartitaIvaClinica() {
        return $this->_partitaIVAClinica;
    }

    /**
     * Metodo che restituisce il nome del medico che ha scritto il referto
     * 
     * @return string Il medico che ha scritto il referto
     */
    public function getMedicoReferto() {
        return $this->_medicoReferto;
    }
    
    /**
     * Metodo che restituisce il path del referto
     * 
     * @return string Il path del referto
     */
    public function getFileNameReferto() {
        return $this->_fileName;
    }

    /**
     * Metodo che restituisce il referto
     * 
     * @return referto
     */
    public function getContenutoReferto() {
        return $this->_contenuto;
    }

    /**
     * Metodo che restituisce la data del referto
     * 
     * @return date la data del referto
     */
    public function getDataReferto() {
        return $this->_dataReferto;
    }

    /**
     * Metodo che imposta gli user con i quali il referto è stato condiviso 
     * 
     * @param string Gli user con i quali il referto è stato condiviso 
     */
    public function setCondivisoConUtenteReferto($condivisoConUtente) {
        $this->_condivisoCon = $condivisoConUtente;
    }
    
    /**
     * Metodo che imposta se il referto è condiviso con il medico o meno.
     * 
     * @param boolean TRUE il referto è condiviso con il medico, FALSE altrimenti.
     */
    public function setCondivisoConMedicoReferto($condivisoConMedico) {
        $this->_condivisoConMedico = $condivisoConMedico;
    }
    
    /**
     * NON IN USO Controlla se il referto esiste 
     * @throws XFileException Lancia l'eccezione se il file non esiste
     * @return bool TRUE se il file esiste, FALSE altrimenti
     */
    public function checkEsistenzaReferto() {

        $fReferto = USingleton::getInstance('FReferto');
        if ($fReferto->checkEsistenzaReferto($this->_contenuto)) {
            return TRUE;
        } else {
            throw new XFileException('Attenzione, problema imprevisto, il file non esiste. ');
        }
    }

    /**
     * Memorizza le proprietà del file referto
     * @throws XDBException Se l'inserimento non è avvenuto con successo
     * @return bool TRUE se l'iserimento è avvenuto con successo
     */
    public function inserisciReferto() {

        $fReferto = USingleton::getInstance('FReferto');
        return $fReferto->inserisciReferto($this);
    }

    /**
     * Sposta il file del referto dalla cartella temporanea nella cartella dei referti
     * @param string $tmpName il nome temporane del file
     */
    public function spostaReferto($tmpName) {

        return move_uploaded_file($tmpName, self::cartellaReferti . $this->_contenuto);
    }
    
    
    /**
     * Metodo che consente di condividere un referto passato come parametro con il proprio medico curante 
     * se $medico è impostato oppure di condivedere con un altro utente se $utente è impostato
     * 
     * @access public
     * @param type $utente
     * @param type $medico
     * @param boolean $valoreCondividi TRUE se vuole essere condiviso con il medico, FALSE altrimenti (MANCA LA PARTE PER L'UtENTE)
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    
    public function condividi($utente = NULL, $medico=NULL, $valoreCondividi) {
        if(isset($medico))
        {
            $this->setCondivisoConMedicoReferto($valoreCondividi);
            $fReferto = USingleton::getInstance('FReferto');
            return $fReferto->condividiConMedico($this->getIDReferto(), $this->getCondivisoConMedicoReferto() );
        }
        
//        $condivisoConMedico = $this->getCondivisoConMedicoReferto();
//        if(isset($condivisoCon))// se in precedenza è stato impostato user con cui condividere il referto
//        {
//            $condivisoCon = json_decode($condivisoCon);
////            print_r($condivisoCon);
//        }
//        if(isset($medico))
//        {
//            // se già l'ha condiviso con il medico??????
//            $condivisoCon['Medico'] = $medico;                        
//        }
//        else
//        {
//            
//        }
//        $condivisoCon = json_encode($condivisoCon);
////        print_r($condivisoCon);
//        $this->setCondivisoConReferto($condivisoCon);
//        $fReferto = USingleton::getInstance('FReferto');
//        return $fReferto->condividiCon($this->getIDReferto(), $condivisoCon );
    }
    
}
