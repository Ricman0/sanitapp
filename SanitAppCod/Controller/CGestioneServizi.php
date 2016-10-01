<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CGestioneServizi
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CGestioneServizi {
    
    
    public function gestisciServizi() 
    {
        $sessione = USingleton::getInstance('USession');
        $nomeClinica = $sessione->leggiVariabileSessione('nomeClinica');
        echo "nome clinica: " . $nomeClinica;
        $vServizi = USingleton::getInstance('VGestioneServizi');
        $task = $vServizi->getTask();
        $this->gestisciAzione($vServizi, $task, $nomeClinica);
        
    }
    public function gestisciServiziPost() 
    {
        $sessione = USingleton::getInstance('USession');
        $nomeClinica = $sessione->leggiVariabileSessione('nomeClinica');
        echo " nome clinica: " . $nomeClinica;
        $vServizi = USingleton::getInstance('VGestioneServizi');
        $task = $vServizi->getTask();
        if($task==="aggiungi")
        {
            //valido dati immessi attraverso UValidazione
            if ($this->recuperaDatiECreaEsame()) {
                echo "esame inserito";
            } else {
                echo "esame non inserito";
            }

            // l'oggetto di tipo EEsame richiama una funzione per aggiungere
            //l'esame nel db ovvero crea un FESame e poi inserisce l'esame
        }
        
    }
    
    /**
     * Metodo che consente di gestire l'azione richiesta dalla clinica
     * 
     * 
     */
    private function gestisciAzione($vServizi, $azione, $nomeClinica)
    {
        switch ($azione)
        {
            case 'aggiungi':
                $vServizi->restituisciFormAggiungiServizi();
                break;
       
            case 'modifica':
                break;
            
            case 'disabilita':
                break;
            
            case 'cancella':
                break;
            
            default:
                // caso in cui si vogliono solo visualizzare i servizi
//                $esami = USingleton::getInstance('CRicercaEsami');
//                $esami->
                $esami = USingleton::getInstance('FEsame');
                //cerco tutti gli esami della clinica di cui passo il nome
                $risultato = $esami->cercaEsame("",$nomeClinica,"");
                $vServizi->visualizzaEsami($risultato);
                
                break;
        }
        
    }
    public function inserisciServizio()
    {
        $vGestioneServizi= USingleton::getInstance('VGestioneServizi');
        $task= $vGestioneServizi->getTask();
        echo ($task);
        switch ($task) 
        {
            
            case '':
                $inserito = $this->recuperaDatiECreaClinica();
//                return $vRegistrazione->restituisciFormClinica();
                if(is_string($inserito) === TRUE)
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneClinica($inserito) === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione = USingleton::getInstance('VRegistrazione');
                           $vRegistrazione->confermaInserimento();
                       }                    
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        
                        echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                        return $vRegistrazione->restituisciFormClinica($inserito);
                    }
                break;
            
            case 'medico':
                $inserito = $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();
                 if(is_string($inserito) === TRUE)
                    {
                       //invia mail riscontro dell’avvenuta registrazione 
                       //contenente informazioni riepilogative
                       // e con link di conferma
                       $mail = USingleton::getInstance('UMail');
                       if ($mail->inviaMailRegistrazioneMedico($inserito)  === TRUE)
                       {
                           // visualizzo che un'email è stata inviata sulla propria mail
                           $vRegistrazione = USingleton::getInstance('VRegistrazione');
                           $vRegistrazione->confermaInserimento();
                       }
                    }
                else
                    {
                        // dati corretti ma errore nel database
                        echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                        return $vRegistrazione->restituisciFormMedico($inserito);
                    }
                break;

            default:
                //recupera dati dal form e crea un nuovo utente
                $inserito = $this->recuperaDatiECreaUtente();
                 if(is_string($inserito) === TRUE)
                {
                    //accedo al DB per ottenere le informazioni sull'utente inserito o è sufficiente $POST?
                    //messaggio di conferma

                   //invia mail riscontro dell’avvenuta registrazione 
                   //contenente informazioni riepilogative
                   // e con link di conferma
                   $mail = USingleton::getInstance('UMail'); 
                   if($mail->inviaMailRegistrazioneUtente($inserito) === TRUE)
                   {
                       // visualizzo che un'email è stata inviata sulla propria mail
                       $vRegistrazione = USingleton::getInstance('VRegistrazione');
                       $vRegistrazione->confermaInserimento();
                   }   
                }
                else
                {
                    // dati corretti ma errore nel database

                    echo " errore durante l'inserimento nel db, per favore reinserisci i dati";
                    return $vRegistrazione->restituisciFormUtente($inserito);
                }
                    
                    //visualizza errori
    //                    return $VRegistrazione->set_errori($Eutente->data_err,$caricamento,'registrazione');
                break;
        }
    }
    
    /**
     * Metodo che recupera i tutti i dati di un esame dalla form 
     * per poter inserire un nuovo easme. I dati vengono memorizzati
     *  nell'array $datiEsame
     * 
     * @access private
     * @return Array I dati per memorizzare l'esame
     */
    private function recuperaDatiEsame()
    {
        //creo un array in cui inserirsco i valori recuperati
        //pb: secondo te è una stupidaggine fare così e poi aggiungo del tempo  inutile
       $datiEsame = Array();
       $datiEsame['nome'] = $this->recuperaValore('nomeEsame');
       $datiEsame['medico'] = $this->recuperaValore('medicoEsame'); 
       $datiEsame['categoria'] = $this->recuperaValore('categoriaEsame');
       $datiEsame['prezzo'] =$this->recuperaValore('prezzoEsame');
       $datiEsame['durata'] = $this->recuperaValore('durataEsame')."00";
       $datiEsame['numPrestazioniSimultanee'] = $this->recuperaValore('numPrestazioniSimultanee');
       $datiEsame['descrizione'] = $this->recuperaValore('descrizioneEsame');
       
       return $datiEsame;
    }
    
    private function recuperaDatiECreaEsame() 
    {
       //recupero i dati 
       $datiEsame = $this->recuperaDatiEsame();
       print_r($datiEsame);
       //ho recuperato tutti i dati inseriti nella form di inserimento dell'esame
       //ora è necessario che vengano validati prima della creazione di un nuovo esame
//       $uValidazione = USingleton::getInstance('UValidazione');
//       $validi = $uValidazione->validaDatiUtente($datiUtente);
       // se i dati sono validi
//       if($validi)
//       {
           
           
           $eEsame = new EEsame($datiEsame['nome'], $datiEsame['medico'],
                   $datiEsame['categoria'], $datiEsame['prezzo'], 
                   $datiEsame['durata'], $datiEsame['numPrestazioniSimultanee'], 
                   $datiEsame['descrizione']);
           
        //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
           $inserito = $eEsame->inserisciEsameDB($eEsame);
//       }
//       else
//       {
//           // i dati errati
//          $uValidazione->getDatiErrati(); 
//          // i dati validi
//          $inserito = $uValidazione->getDatiValidi();
//          
//       }
       return $inserito;
    }
    
    /**
     * Metodo che permette di recuperare dall'array POST il valore inserito dall'utente
     * in un campo della form. Il campo è individuato dall'indice.
     * 
     * @access private
     * @param string $indice Il nome dell'indice che deve essere recuperato dall'array POST
     * @return string Il valore recuperato
     */
    private function  recuperaValore($indice) 
    {
        if(isset($_POST[$indice]))
       {
            $parametro = $_POST[$indice];
       }
       return $parametro;
    }
}
