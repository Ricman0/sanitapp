<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VReferti
 *
 * @author Claudia Di Marco & Riccardo Mantini 
 */
class VReferti extends View{


    /**
     * Metodo che consente di visualizzare tutti i referti di uno user
     * 
     * @access public
     * @param Array $referti I referti da visualizzare
     * @param string $tipoUser Il tipo di user
     */
    public function restituisciPaginaRisultatoReferti($referti, $tipoUser) 
    {
        if($tipoUser==='clinica')
        {
            $this->assegnaVariabiliTemplate('tastoAggiungi', TRUE);
        }
        else
        {
            $this->assegnaVariabiliTemplate('tastoAggiungi', FALSE);
        }
        $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        $this->assegnaVariabiliTemplate('dati', $referti);
        $this->visualizzaTemplate('tabellaReferti');
    }
    
    /**
     * Restituisce la form di aggiunta del referto
     * 
     * @param string $idPrenotazione Id della prenotazione
     * @param string $idEsame Id dell'esame
     * @param string $partitaIva Partita iva della clinica
     * @param string $medicoEsame Medico che ha eseguito l'esame
     */
    public function restituisciPaginaAggiungiReferto($idPrenotazione, $idEsame, $partitaIva, $medicoEsame) {
        
        $this->assegnaVariabiliTemplate('idPrenotazione', $idPrenotazione);
        $this->assegnaVariabiliTemplate('idEsame', $idEsame);
        $this->assegnaVariabiliTemplate('partitaIva', $partitaIva);
        $this->assegnaVariabiliTemplate('medicoEsame', $medicoEsame);
        return $this->visualizzaTemplate('aggiungiReferto');
        
    }
    
    /**
     * Fornisce le informazioni relative al referto
     * @param EReferto $referto L'entità referto
     * @param EPrenotazione $prenotazione L'entità prenotazione
     * @param EEsame $esame L'entità esame
     * @param EUtente $utente L'entità utente
     * @param EClinica $clinica L'entità clinica
     * @param string $tipoUser Il tipo utente
     */
    public function visualizzaInfoReferto($referto, $prenotazione, $esame, $utente, $clinica, $tipoUser) {
        
        $this->assegnaVariabiliTemplate('esame', $esame);
        $this->assegnaVariabiliTemplate('utente', $utente);
        $this->assegnaVariabiliTemplate('referto', $referto);
        $this->assegnaVariabiliTemplate('prenotazione', $prenotazione);
        $this->assegnaVariabiliTemplate('clinica', $clinica);
        $this->assegnaVariabiliTemplate('tipoUser', $tipoUser);
        $this->visualizzaTemplate('infoReferto');
        
    }
    /**
     * Ritorna i dati relativi al referto
     * @return Array i dati necessari per la creazione del referto
     */
    public function recuperaDatiReferto() {
        
        $datiReferto['idPrenotazione'] = $this->recuperaValore('idPrenotazione');
        $datiReferto['idEsame'] = $this->recuperaValore('idEsame');
        $datiReferto['partitaIVA'] = $this->recuperaValore('partitaIva');
        $datiReferto['medicoEsame'] = $this->recuperaValore('medicoEsame');
        return $datiReferto;

    }
    
    /**
     * Forza il download del file referto
     * 
     * @param string $fileName Il nome del file da scaricare
     * @param type $file Il file da scaricare
     */
    public function downloadReferto($fileName, $file) {

        header("Cache-Control: public");
        header("Content-type:application/pdf");
        header("Content-Description: File Transfer");
        header( 'Content-Disposition: attachment;filename="'.$fileName.'"');
        header("Content-Transfer-Encoding: binary");
        echo $file;
    }
}