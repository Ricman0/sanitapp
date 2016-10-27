<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * descrizione di Eclinica
 * 
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EClinica extends EUser
{
    /*
     * Attributi della classe EClinica
     */
    
    /**
     * @var string $_partitaIVA PartitaIVA della clinica
     */
    private $_partitaIVA;
    /**
     * @var string $_nomeClinica Nome della clinica
     */
    private $_nomeClinica;
    /**
     * @var string $_titolareClinica Titolare della clinica
     */
    private $_titolareClinica;
    /**
     * @var string $_via La via in cui è collocata la clinica
     */
    private $_via;
    /**
     * @var  int $_numeroCivico Numero civico della clinica
     */
    private $_numeroCivico;
    /**
     * @var  string $_CAP CAP della città o paese in cui si trova la clinica
     */
    private $_CAP;
    /**
     * @var  string $_località Città o paese in cui si trova la clinica
     */
    private $_località;
    /**
     * @var  string $_provincia Provincia della città o paese in cui si trova la clinica
     */
    private $_provincia;
    /**
     * @var  string $_regione regione della città o paese in cui si trova la clinica
     */
    private $_regione;
    /**
     * @var string $_PEC L'indizzo email certificato della clinica
     */
    private $_PEC;
    /**
     * @var string $_username Username scelto e usato dalla clinica per accedere al sistema
     */
    private $_telefono;
    /**
     * @var int $_capitaleSoociale Capitale sociale della clinica
     */
    private $_capitaleSociale;
    /**
     * @var string $_workingPlan Il working plan della clinica
     */
    private $_workingPlan;
 
    /**
     * @var Array(EEsame) $_esami array che contiente gli esami/servizi che la clinica fornisce
     */
    private $_esami; 
    
    // costruttore
    
    /**
     * Costruttore della classe EClinica
     * 
     * @param string $nome Il nome del medico
     * @param string $cognome Il cognome del medico
     * @param string $cf Il codice fiscale del medico
     * @param string $via La via in cui risiede il medico
     * @param string $cap Il cap del paese in cui risiede il medico
     * @param string $località Città o paese in cui risiede la clinica
     * @param string $provincia Provincia della città o paese in cui risiede la clinica
     * @param string $regione Regione della città o paese in cui risiede la clinica
     * @param string $email L'email del medico
     * @param string $password La password del medico
     * @param string $PEC La PEC del medico
     * @param string $provinciaAlbo La provincia dell'albo in cui il medico è iscritto
     * @param string o int? $numIscrizione Il numero di iscrizione nell'albo del medico
     * @param int o string? $cod Il codice per confermare l'account
     * @param array $esami Array di esami/servizi che la clinica fornisce
     */
    
    public function __construct($username=NULL, $partitaIVA=NULL, $nomeClinica=NULL, $titolareClinica=NULL, 
            $via=NULL, $numeroCivico=NULL, $cap=NULL,$località=NULL, $provincia=NULL, $regione=NULL, $email=NULL,$PEC=NULL, $password=NULL, 
            $telefono=NULL, $capitaleSociale=NULL, $workingPlan=NULL, $esami=NULL) 
    {
        parent::__construct($username, $password, $email);
        $this->_partitaIVA= $partitaIVA;
            $this->_nomeClinica = $nomeClinica;
            $this->_titolareClinica =$titolareClinica;
            $this->_via = $via;
            if(isset($numeroCivico))
            {
                $this->_numeroCivico = $numeroCivico; 
            }
            else
                {
                    $this->_numeroCivico = NULL; 
                }

            $this->_CAP = $cap;
            $this->_località = $località;
            $this->_provincia = $provincia;
            $this->_regione = $regione;
            $this->_PEC = $PEC;
            $this->_telefono = $telefono;
            if(isset($capitaleSociale))
            {
                $this->_capitaleSociale = $capitaleSociale; 
            }
            else
                {
                    $this->_capitaleSociale= NULL; 
                }
            if(isset($workingPlan))
            {
                $this->_workingPlan = $workingPlan; 
            }
            
            $this->_esami = Array();
            if(isset($esami))
            {
                $this->_esami = $esami; 
            }
        
//        if($partitaIVA!==NULL && $username!==NULL)
//        {
//            $this->_partitaIVA= $partitaIVA;
//            $this->_nomeClinica = $nomeClinica;
//            $this->_titolareClinica =$titolareClinica;
//            $this->_via = $via;
//            if(isset($numeroCivico))
//            {
//                $this->_numeroCivico = $numeroCivico; 
//            }
//            else
//                {
//                    $this->_numeroCivico = NULL; 
//                }
//
//            $this->_CAP = $cap;
//            $this->_località = $località;
//            $this->_provincia = $provincia;
//            $this->_regione = $regione;
//            $this->_email = $email;
//            $this->_PEC = $PEC;
//            $this->_username = $username;
//            $this->_password = $password;
//            $this->_telefono = $telefono;
//            if(isset($capitaleSociale))
//            {
//                $this->_capitaleSociale = $capitaleSociale; 
//            }
//            else
//                {
//                    $this->_capitaleSociale= NULL; 
//                }
//            if(isset($workingPlan))
//            {
//                $this->_workingPlan = $workingPlan; 
//            }
//            
//            $this->_confermato = FALSE;
//            $this->_esami = Array();
//            if(isset($esami))
//            {
//                $this->_esami = $esami; 
//            }
//        }
//        else 
//        {
//            $fClinica = USingleton::getInstance('FClinica');
//            if($username!==NULL)
//            {
//                $attributiClinica = $fClinica->cercaClinicaByUsername($username);
//            }
//            else
//            {
//                 $attributiClinica = $fClinica->cercaClinicaByPartitaIVA($partitaIVA);
//            }
//            if(is_array($attributiClinica) && count($attributiClinica)==1)
//            {
//                $this->_partitaIVA = $attributiClinica[0]["PartitaIVA"];
//                $this->_nomeClinica = $attributiClinica[0]["NomeClinica"];
//                $this->_titolareClinica =$attributiClinica[0]["Titolare"];
//                $this->_via = $attributiClinica[0]["Via"];
//                $this->_numeroCivico = $attributiClinica[0]["NumCivico"];
//                $this->_CAP = $attributiClinica[0]["CAP"];
//                $this->_località = $attributiClinica[0]["Località"];
//                $this->_provincia = $attributiClinica[0]["Provincia"];
//                $this->_regione = $attributiClinica[0]["Regione"];
//                $this->_email =$attributiClinica[0]["Email"];
//                $this->_PEC = $attributiClinica[0]["PEC"];
//                $this->_username = $attributiClinica[0]["Username"];
//                $this->_password = $attributiClinica[0]["Password"];
//                $this->_telefono = $attributiClinica[0]["Telefono"];
//                $this->_capitaleSociale = $attributiClinica[0]["CapitaleSociale"];
//                $this->_workingPlan = $attributiClinica[0]["WorkingPlan"]; 
//                $this->_confermato = $attributiClinica[0]["Confermato"];
//                $this->_codiceConferma = $attributiClinica[0]["CodiceConferma"];
//                $this->_esami = Array();
//            }
//        }
        
    }
    
    // metodi get
    /**
     * Metodo per conoscere il working plan della clinica 
     * 
     * @return string Il working plan della clinica 
     */
    public function getWorkingPlanClinica()
    {
        return $this->_workingPlan;
    }
    
    /**
     * Metodo per conoscere gli esami/servizi che la clinica fornisce
     * 
     * @return Array Gli esami/servizi che la clinica fornisce
     */
    public function getEsamiClinica()
    {
        return $this->_esami;
    }
    
    /**
     * Metodo che restituisce la partita IVA della clinica
     * 
     * @return string La partita IVA della clinica
     */
    public function getPartitaIVAClinica()
    {
        return $this->_partitaIVA;
    }
    
    /**
     * Metodo che restituisce il nome della clinica
     * 
     * @return string Il nome della clinica
     */
    public function getNomeClinica()
    {
        return $this->_nomeClinica;
    }
    /**
     * metodo che ritorna la stringa indirizzo
     * @return string l'indirizzo della clinica
     */
    public function getIndirizzoClinica() {
        
        return $this->_via ." ". $this->_numeroCivico ." ". $this->_località ." ". $this->_provincia;
        
    }
    /**
     * Metodo che restituisce il titolare della clinica
     * 
     * @return string Il titolare della clinica
     */
    public function getTitolareClinica()
    {
        return $this->_titolareClinica;
    }
            
    /**
     * Metodo che restituisce l'indirizzo in cui è collocata la clinica
     * 
     * @return string Il nome della via
     */
    public function getViaClinica()
    {
        return $this->_via;
    }
    
    /**
     * Metodo che restituisce il numero civico in cui è collocata la clinica
     * 
     * @return int Il numero civico della clinica
     */
    public function getNumeroCivicoClinica()
    {
        return $this->_numeroCivico;
    }
    
    /**
     * Metodo che restituisce il CAP della città o paese in cui è collocata la clinica
     * 
     * @return string Il CAP della città o paese della clinica
     */
    public function getCAPClinica()
    {
        return $this->_CAP;
    }
    
    /**
     * Metodo che restituisce la città o paese in cui è collocata la clinica
     * 
     * @return string La città o paese della clinica
     */
    public function getLocalitàClinica()
    {
        return $this->_località;
    }
    
    /**
     * Metodo che restituisce la provincia della città o paese in cui è collocata la clinica
     * 
     * @return string La provincia della città o paese della clinica
     */
    public function getProvinciaClinica()
    {
        return $this->_provincia;
    }
    
    /**
     * Metodo che restituisce la regione della città o paese in cui è collocata la clinica
     * 
     * @return string La regione della città o paese della clinica
     */
    public function getRegioneClinica()
    {
        return $this->_regione;
    }
    
    /**
     * Metodo che restituisce l'indirizzo email certificato PEC della clinica
     * 
     * @return string L'indirizzo PEC della clinica
     */
    public function getPECClinica()
    {
        return $this->_PEC;
    }
    
    /**
     * Metodo che restituisce il numero di telefono dalla clinica
     * 
     * @return string Il numero di telefono della clinica
     */
    public function getTelefonoClinica()
    {
        return $this->_telefono;
    }
    
    /**
     * Metodo che restituisce il capitale sociale della clinica
     * 
     * @return string Capitale sociale della clinica
     */
    public function getCapitaleSocialeClinica()
    {
        return $this->_capitaleSociale;
    }
    
    //metodi set
    
    /**
     * Metodo che imposta il titolare della clinica
     * 
     * @param string Titolare della clinica
     */
    public function setTitolareClinica($titolare)
    {
        $this->_titolareClinica = $titolare;
    }
    
    /**
     * Metodo che imposta il working plan della clinica
     * 
     * @param string Working plan della clinica
     */
    public function setWorkingPlanClinica($workingPlan)
    {
        $this->_workingPlan = $workingPlan;
    }
    
    /**
     * Metodo che imposta la via della clinica
     * 
     * @param string Via della clinica
     */
    public function setViaClinica($via)
    {
        $this->_via = $via;
    }
    
    /**
     * Metodo che imposta il numero civico della clinica
     * 
     * @param int Numero civico della clinica
     */
    public function setNumeroCivicoClinica($numCivico)
    {
        $this->_numeroCivico = $numCivico;
    }
    
    /**
     * Metodo che imposta il CAP della clinica
     * 
     * @param string CAP della clinica
     */
    public function setCAPClinica($cap)
    {
        $this->_CAP = $cap;
    }
    
    /**
     * Metodo che imposta la città o paese della clinica
     * 
     * @param string Località della clinica
     */
    public function setLocalitàClinica($località)
    {
        $this->_località = $località;
    }
    
    /**
     * Metodo che imposta la provincia della città o paese della clinica
     * 
     * @param string Provincia della clinica
     */
    public function setProvinciaClinica($provincia)
    {
        $this->_provincia = $provincia;
    }
    
    /**
     * Metodo che imposta la regione della città o paese della clinica
     * 
     * @param string Regione della clinica
     */
    public function setRegioneClinica($regione)
    {
        $this->_regione = $regione;
    }
    
    /**
     * Metodo che imposta la pec della clinica
     * 
     * @param string PEC della clinica
     */
    public function setPECClinica($pec)
    {
        $this->_PEC = $pec;
    }
    
    /**
     * Metodo che imposta il capitale sociale della clinica
     * 
     * @param string Capitale sociale della clinica
     */
    public function setCapitaleSocialeClinica($cp)
    {
        $this->_capitaleSociale = $cp;
    }
    
    /**
     * Metodo che imposta il telefono della clinica
     * 
     * @param string Telefono della clinica
     */
    public function setTelefonoClinica($tel)
    {
        $this->_telefono = $tel;
    }
    
    /**
     * Metodo che permette di modificare gli esami/servizi che la clinica offre
     * 
     * @param Array $esami Esami/servizi della clinica
     */
    public function setEsamiClinica($esami)
    {
        $this->_esami = $esami; 
    }
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EClinica nel DB
     * 
     * @access public
     * @return string|Boolean Il codice di conferma se la clinica è stata inserita correttamente, altrimenti FALSE (la clinica non è stata inserita correttamente nel DB)
     */
    public function inserisciClinicaDB() 
    {
        //crea un oggetto fClinica se non è esistente, si collega al DB e lo inserisce
        $fClinica = USingleton::getInstance('FClinica');
        ;
        if( $fClinica->inserisciClinica($this) === TRUE)
        {
            return $this->getCodiceConfermaClinica();
        }
        else
        {
            return FALSE;
        }
    }
    
    /**
     * Metodo che consente di salvare nel db il working plan relativo ad una clinica
     * 
     * @access public
     * @param string $workingPlan Il working plan da salvare
     * @return boolean TRUE se il salvataggio è stato effettuato. FALSE altrimenti
     */
    public function salvaWorkingPlanClinica($workingPlan)
    {
        $fClinica = USingleton::getInstance('FClinica');
        return $fClinica->salvaWorkingPlan($workingPlan, $this->getPartitaIVAClinica());
    }
}
?>