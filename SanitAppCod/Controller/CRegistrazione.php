<?php

/**
 * Description of CRegistrazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRegistrazione {
    
    /**
     * Metodo che imposta la pagina di registrazione
     * 
     * @access public
     * @return type Description
     */
    public function  impostaPaginaRegistrazione() 
    { 
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        $task= $vRegistrazione->getTask();
        switch ($task) 
        {
            
            case 'clinica':
                return $vRegistrazione->restituisciFormClinica();
            
            case 'medico':
                return $vRegistrazione->restituisciFormMedico();

            default:
                //prova
//                switch ($_SERVER['REQUEST_METHOD'])  
//                {
//                    case 'GET':
//                        return $vRegistrazione->restituisciFormUtente();     
//                        break;
//                    case 'POST': echo "ciao post nel get";
//
//                        ;
//                        break;
//                    case 'PUT':
//                        ;
//                        break;
//                    case 'DELETE':
//                        ;
//                        break;
//                    default:;
//                }
                //fine prova    
                return $vRegistrazione->restituisciFormUtente();     
        }    
    }
    
    /**
     * Metodo che permette l'inserimento di un utente, medico o clinica nel db
     * se la richiesta effettuata è di tipo POST
     * 
     * @access public
     */
    public function inserisciRegistrazione()
    {
        $vRegistrazione= USingleton::getInstance('VRegistrazione');
        $task= $vRegistrazione->getTask();
        echo ($task);
        switch ($task) 
        {
            
            case 'clinica':
                $this->recuperaDatiECreaClinica();
//                return $vRegistrazione->restituisciFormClinica();
            
            case 'medico':
                $this->recuperaDatiECreaMedico();
//                return $vRegistrazione->restituisciFormMedico();

            default:
                //recupera dati dal form e crea un nuovo utente
                $inserito = $this->recuperaDatiECreaUtente();
                if(is_bool($inserito))
                {
                    if($inserito === TRUE)
                    {
                       //invia mail  
                    }
                    else
                    {
                        // dati corretti ma errore nel database
                    }
                    
                }
                    else
                {
                    //visualizza errori
//                    return $VRegistrazione->set_errori($Eutente->data_err,$caricamento,'registrazione');
                    return $vRegistrazione->restituisciFormUtente();
                }
                break;
        }
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire una nuova clinica nel database
     * 
     * @access private
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaClinica() 
    {
        //recupero i dati 
       $datiClinica = $this->recuperaDatiClinica();
       //ho recuperato tutti i dati inseriti nella form di registrazione della clinica
       //ora è necessario che vengano validati prima della creazione di una nuova clinica
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiClinica($datiClinica);
       // se i dati sono validi
       if($validi)
       {           
            $eClinica = new EClinica($datiClinica['partitaIVA'], $datiClinica['nomeClinica'],
                   $datiClinica['titolareClinica'], $datiClinica['via'], $datiClinica['numeroCivico'],
                   $datiClinica['cap'], $datiClinica['email'], $datiClinica['PEC'], $datiClinica['username'],
                   $datiClinica['password'], $datiClinica['telefono'],
                   $datiClinica['capitaleSociale'],$datiClinica['orarioAperturaAM'],
                   $datiClinica['orarioChiusuraAM'], $datiClinica['orarioAperturaPM'],
                   $datiClinica['orarioChiusuraPM'],$datiClinica['orarioContinuato']);
            //eClinica richiama il metodo per creare FClinica poi FClinica aggiunge l'utente nel DB
            $inserito = $eClinica->inserisciClinicaDB($eClinica); 
       }
       else
       {
          $uValidazione->getDatiErrati(); 
       }
       return $inserito; 
    }
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo medico nel database
     * 
     * @access private
     * @return boolean TRUE se il medico è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaMedico() 
    {
       //recupero i dati 
       $datiMedico = $this->recuperaDatiMedico();
       //ho recuperato tutti i dati inseriti nella form di registrazione del medico
       //ora è necessario che vengano validati prima della creazione di un nuovo medico
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiMedico($datiMedico);
       // se i dati sono validi
       if($validi)
       {           
           $eMedico = new EMedico($datiMedico['nome'], $datiMedico['cognome'],
                   $datiMedico['codiceFiscale'], $datiMedico['via'], 
                   $datiMedico['cap'], $datiMedico['email'], $datiMedico['username'],
                   $datiMedico['password'], $datiMedico['PEC'],
                   $datiMedico['provinciaAlbo'],$datiMedico['numeroIscrizione']);
           //eMedico richiama il metodo per creare FMedico poi FMedico aggiunge l'utente nel DB
           $inserito = $eMedico->inserisciMedicoDB($eMedico);
       }
       else
       {
          $uValidazione->getDatiErrati(); 
       }
       return $inserito;  
    }
    
    
    
    /**
     * Metodo che permette di recuperare i dati dall'array $_POST e utilizza
     * tali dati per creare e inserire un nuovo utente nel database
     * 
     * @access private
     * @return boolean TRUE se l'utente è stato inserito nel DB, FALSE altrimenti
     */
    private function recuperaDatiECreaUtente() 
    {
       //recupero i dati 
       $datiUtente = $this->recuperaDatiUtente();
       //ho recuperato tutti i dati inseriti nella form di registrazione dell'utente
       //ora è necessario che vengano validati prima della creazione di un nuovo utente
       $uValidazione = USingleton::getInstance('UValidazione');
       $validi = $uValidazione->validaDatiUtente($datiUtente);
       // se i dati sono validi
       if($validi)
       {
           $eUtente = new EUtente($datiUtente['nome'], $datiUtente['cognome'],
                   $datiUtente['codiceFiscale'], $datiUtente['indirizzo'], 
                   $datiUtente['numeroCivico'], $datiUtente['CAP'], 
                   $datiUtente['email'], $datiUtente['username'], $datiUtente['passwordUtente']);
           //eUtente richiama il metodo per creare FUtente poi Futente aggiunge l'utente nel DB
           $inserito = $eUtente->inserisciUtenteDB($eUtente);
       }
       else
       {
          $uValidazione->getDatiErrati(); 
       }
       return $inserito;
    }
    
    /**
     * Metodo che recupera i tutti i dati della clinica dalla form 
     * per poter inserire una nuova clinica. I dati vengono memorizzati
     *  nell'array $datiClinica
     * 
     * @access private
     * @return Array I dati per memorizzare la clinica
     */
    private function recuperaDatiClinica()
    {
        $datiClinica = Array();
        $datiClinica['nomeClinica'] = $this->recuperaValore('nomeClinica');
        $datiClinica['titolareClinica'] = $this->recuperaValore('titolareClinica'); 
        $datiClinica['partitaIVA'] = $this->recuperaValore('partitaIVA');
        $datiClinica['via'] = $this->recuperaValore('via');
        if(isset($_POST['numeroCivico']))
        {
            $datiClinica['numeroCivico'] = $this->recuperaValore('numeroCivico');
        }
        $datiClinica['cap'] = $this->recuperaValore('cap');
        $datiClinica['localitàClinica'] = $this->recuperaValore('localitàClinica');
        $datiClinica['provinciaClinica'] = $this->recuperaValore('provinciaClinica');
        $datiClinica['email'] = $this->recuperaValore('email');
        $datiClinica['username'] = $this->recuperaValore('username');
        $datiClinica['password'] = $this->recuperaValore('password');
        $datiClinica['PEC'] = $this->recuperaValore('PEC');
        $datiClinica['telefono'] = $this->recuperaValore('telefono');
        $datiClinica['capitaleSociale'] = $this->recuperaValore('capitaleSociale');
        $datiClinica['orarioAperturaAM'] = $this->recuperaValore('orarioAperturaAM');
        $datiClinica['orarioAperturaPM'] = $this->recuperaValore('orarioAperturaPM');
        $datiClinica['orarioChiusuraAM'] = $this->recuperaValore('orarioChiusuraAM');
        $datiClinica['orarioChiusuraPM'] = $this->recuperaValore('orarioChiusuraPM');
        $datiClinica['orarioContinuato'] = $this->recuperaValore('orarioContinuato'); 
        return $datiClinica;
    }
    
    /**
     * Metodo che recupera i tutti i dati del medico dalla form 
     * per poter inserire un nuovo medico. I dati vengono memorizzati
     *  nell'array $datiMedico
     * 
     * @access private
     * @return Array I dati per memorizzare il medico
     */
    private function recuperaDatiMedico()
    {
        $datiMedico = Array();
        $datiMedico['nome'] = $this->recuperaValore('nome');
        $datiMedico['cognome'] = $this->recuperaValore('cognome'); 
        $datiMedico['codiceFiscale'] = $this->recuperaValore('codiceFiscale');
        $datiMedico['via'] = $this->recuperaValore('via');
        $datiMedico['cap'] = $this->recuperaValore('cap');
        $datiMedico['email'] = $this->recuperaValore('email');
        $datiMedico['username'] = $this->recuperaValore('username');
        $datiMedico['password'] = $this->recuperaValore('password');
        $datiMedico['PEC'] = $this->recuperaValore('PEC');
        $datiMedico['provinciaAlbo'] = $this->recuperaValore('provinciaAlbo');
        $datiMedico['numIscrizione'] = $this->recuperaValore('numeroIscrizione'); 
        return $datiMedico;
    }


    /**
     * Metodo che recupera i tutti i dati di un utente dalla form 
     * per poter inserire un nuovo utente. I dati vengono memorizzati
     *  nell'array $datiUtente
     * 
     * @access private
     * @return Array I dati per memorizzare l'utente
     */
    private function recuperaDatiUtente()
    {
        //creo un array in cui inserirsco i valori recuperati
        //pb: secondo te è una stupidaggine fare così e poi aggiungo del tempo  inutile
       $datiUtente = Array();
//       $nome = $this->recuperaValore('nome');    
       $datiUtente['nome'] = $this->recuperaValore('nome');
       $datiUtente['cognome'] = $this->recuperaValore('cognome'); 
       $datiUtente['codiceFiscale'] = $this->recuperaValore('codiceFiscale');
       $datiUtente['indirizzo'] =$this->recuperaValore('indirizzo');
       if(isset($_POST['numeroCivico']))
       {
           $datiUtente['numeroCivico'] = $this->recuperaValore('numeroCivico');  
       }
       $datiUtente['CAP'] = $this->recuperaValore('CAP');
       $datiUtente['email'] = $this->recuperaValore('email');
       $datiUtente['username'] =$this->recuperaValore('username');
       $datiUtente['passwordUtente'] = $this->recuperaValore('passwordUtente');
       return $datiUtente;
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
