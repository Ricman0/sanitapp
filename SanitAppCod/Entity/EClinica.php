<?php

/**
 * La classe EClinica si occupa della gestione in ram delle cliniche. 
 * 
 * @package Entity
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EClinica extends EUser {
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
     * @var  string $_localita Città o paese in cui si trova la clinica
     */
    private $_localita;

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
     * @var array $_esami array che contiene gli esami/servizi che la clinica fornisce. 
     * Realizza l'aggregazione con la classe EEsame.
     */
    private $_esami;
    
    /**
     * @var array $_prenotazioni array che contiene le prenotazioni presso la clinica. 
     * Realizza l'aggregazione con la classe EPrenotazione.
     */
    private $_prenotazioni;
    
    /**
     * @var array $_referti array che contiene i referti della clinica fornisce. 
     * Realizza l'aggregazione con la classe EReferto.
     */
    private $_referti;
    
     /**
     * @var array $_clienti array che contiene i clienti della clinica . 
     * Realizza l'aggregazione con la classe EUtente.
     */
    private $_clienti;
    
    /**
     * @var boolean $_validato Indica se la clinica è stata validata dall'amministratore
     */
    private $_validato;

    /**
     * Costruttore della classe EClinica.
     * 
     * @access public 
     * @param string $username L'username della clinica
     * @param string $partitaIVA La partita IVA della clinica
     * @param string $nomeClinica Il nome della clinica
     * @param string $password La password della clinica
     * @param string $email L'email della clinica
     * @param string $titolareClinica Il nome e cognome del titolare della clinica
     * @param string $via La via in cui si trova la clinica 
     * @param int $numeroCivico Il numero civico in cui si trova la clinica
     * @param string $cap Il CAP della clinica
     * @param string $localita Il paese in cui si trova la lcinica
     * @param string $provincia La provincia della clinica
     * @param string $PEC La PEC della clinica
     * @param string $telefono Il telefono della clinica
     * @param int $capitaleSociale Il capitale sociale della clinica
     * @param string $workingPlan Il working plan della clinica
     * @param array $esami Gli esami della clinica
     * @param boolean $validato TRUE se la clinica è stata validata, FALSE altrimenti
     * @throws XClinicaException Se la clinica  è inesistente
     */
    public function __construct($username = NULL, $partitaIVA = NULL, $nomeClinica = NULL, $password = NULL, $email = NULL, $titolareClinica = NULL, $via = NULL, $numeroCivico = NULL, $cap = NULL, $localita = NULL, $provincia = NULL, $PEC = NULL, $telefono = NULL, $capitaleSociale = NULL, $workingPlan = NULL, $esami = NULL, $validato=FALSE) {

        if ($partitaIVA !== NULL && $username !== NULL) {
            parent::__construct($username, $password, $email, $PEC);
            parent::setTipoUser('clinica');
            $this->_partitaIVA = $partitaIVA;
            $this->_nomeClinica = $nomeClinica;
            $this->_titolareClinica = $titolareClinica;
            $this->_via = $via;
            $this->_numeroCivico = $numeroCivico;
            $this->_CAP = $cap;
            $this->_localita = $localita;
            $this->_provincia = $provincia;
            // trova la regione a cui appartiene la provincia inserita nella form dalla clinica e lo assegno
            $this->_regione = $this->trovaRegione($provincia);
            $this->_telefono = $telefono;
            $this->_capitaleSociale = $capitaleSociale;
                if(!isset($workingPlan))
                {
                    $this->_workingPlan ='{"Lunedi":null,"Martedi":null,"Mercoledi":null,"Giovedi":null,"Venerdi":null,"Sabato":null,"Domenica":null}';
                }
                else
                {
                    $this->_workingPlan = $workingPlan;
                }
            $this->_validato = $validato;
            $this->_esami = Array();
            $this->_prenotazioni = Array();
            $this->_referti = Array();
            $this->_clienti = Array();
        } elseif ($partitaIVA !== NULL || $username !== NULL) {
            $fClinica = USingleton::getInstance('FClinica');
            if ($partitaIVA !== NULL && $username === NULL) {
                $attributiClinica = $fClinica->cercaClinicaByPartitaIVA($partitaIVA);
            }
            else {
                $attributiClinica = $fClinica->cercaClinicaByUsername($username);
            }
            if (is_array($attributiClinica) && count($attributiClinica) === 1) {
                
                $this->_partitaIVA = $attributiClinica[0]["PartitaIVA"];
                $this->_nomeClinica = $attributiClinica[0]["NomeClinica"];
                $this->_titolareClinica = $attributiClinica[0]["Titolare"];
                $this->_via = $attributiClinica[0]["Via"];
                $this->_numeroCivico = $attributiClinica[0]["NumCivico"];
                $this->_CAP = $attributiClinica[0]["CAP"];
                $this->_localita= $attributiClinica[0]["Localita"];
                $this->_provincia = $attributiClinica[0]["Provincia"];
                $this->_regione = $attributiClinica[0]["Regione"];
                parent::setEmail($attributiClinica[0]["Email"]);
                parent::setPEC($attributiClinica[0]["PEC"]);
                parent::setUsername($attributiClinica[0]["Username"]);
                parent::setPassword($attributiClinica[0]["Password"]);
                parent::setTipoUser($attributiClinica[0]['TipoUser']);
                $this->_telefono = $attributiClinica[0]["Telefono"];
                $this->_capitaleSociale = $attributiClinica[0]["CapitaleSociale"];
                $this->_workingPlan = $attributiClinica[0]["WorkingPlan"];
                parent::setBloccato($attributiClinica[0]['Bloccato']);
                parent::setConfermato($attributiClinica[0]["Confermato"]);
                parent::setCodiceConfermaUser($attributiClinica[0]["CodiceConferma"]);
                $this->setValidatoClinica($attributiClinica[0]["Validato"]);
                $this->_esami = Array();
                $this->_prenotazioni = Array();
                $this->_referti = Array();
                $this->_clienti = Array();
            } else {
                throw new XClinicaException('Clinica inesistente. ');
            }
        } else {
            parent::__construct($username, $password, $email);
            $this->_partitaIVA = $partitaIVA;
            $this->_nomeClinica = $nomeClinica;
            $this->_titolareClinica = $titolareClinica;
            $this->_via = $via;
            $this->_numeroCivico = $numeroCivico;
            $this->_CAP = $cap;
            $this->_localita = $localita;
            $this->_provincia = $provincia;
            $this->_regione = $this->trovaRegione($provincia);
            parent::setPEC($PEC);
            $this->_telefono = $telefono;
            $this->_capitaleSociale = $capitaleSociale;
            $this->_workingPlan = $workingPlan;
            $this->_validato = $validato;
            parent::setTipoUser('clinica');
            $this->_esami = Array();
            $this->_prenotazioni = Array();
            $this->_referti = Array();
            $this->_clienti = Array();
        }
    }

    // metodi get
    /**
     * Metodo per conoscere il working plan della clinica in un array. 
     * 
     * @access public
     * @return array|NULL Il working plan della clinica o NULL nel caso in cui il working plan non è impostato
     */
    public function getArrayWorkingPlanClinica() {
        
        $workingPlan = NULL;
        if(isset($this->_workingPlan))
        {
            $workingPlan = json_decode($this->_workingPlan);
            //$workingPlan è un oggetto 
            // ora lo rendo un array
            $workingPlan = get_object_vars($workingPlan);
        }
        
        return $workingPlan;
    }

    
    /**
     * Metodo per conoscere il working plan della clinica in formato JSON.
     * 
     * @access public
     * @return string Il working plan della clinica 
     */
    public function getWorkingPlanClinica() {
        return $this->_workingPlan;
    }

    /**
     * Metodo per conoscere gli esami/servizi che la clinica fornisce.
     * 
     * @access public
     * @return array Gli esami/servizi che la clinica fornisce
     */
    public function getEsamiClinica() {
        return $this->_esami;
    }
    
    /**
     * Metodo per conoscere se la clinica è stata validata.
     * 
     * @access public
     * @return boolean TRUE se la clinica è stata validata, FALSE altrimenti
     */
    public function getValidatoClinica() {
        return $this->_validato;
    }

    /**
     * Metodo che restituisce la partita IVA della clinica.
     * 
     * @access public
     * @return string La partita IVA della clinica
     */
    public function getPartitaIVAClinica() {
        return $this->_partitaIVA;
    }

    /**
     * Metodo che restituisce il nome della clinica.
     * 
     * @access public
     * @return string Il nome della clinica
     */
    public function getNomeClinicaClinica() {
        return $this->_nomeClinica;
    }

    /**
     * Metodo che ritorna l'intero indirizzo della clinica (via, numero civico, localita e provincia).
     * 
     * @access public
     * @return string l'indirizzo della clinica
     */
    public function getIndirizzoClinica() {

        return $this->_via . " " . $this->_numeroCivico . " " . $this->_localita . " " . $this->_provincia;
    }

    /**
     * Metodo che restituisce il titolare della clinica.
     * 
     * @access public
     * @return string Il titolare della clinica
     */
    public function getTitolareClinica() {
        return $this->_titolareClinica;
    }

    /**
     * Metodo che restituisce l'indirizzo in cui è collocata la clinica.
     * 
     * @access public
     * @return string Il nome della via
     */
    public function getViaClinica() {
        return $this->_via;
    }

    /**
     * Metodo che restituisce il numero civico in cui è collocata la clinica.
     * 
     * @access public
     * @return int Il numero civico della clinica
     */
    public function getNumCivicoClinica() {
        return $this->_numeroCivico;
    }

    /**
     * Metodo che restituisce il CAP della città o paese in cui è collocata la clinica.
     * 
     * @access public
     * @return string Il CAP della città o paese della clinica
     */
    public function getCAPClinica() {
        return $this->_CAP;
    }

    /**
     * Metodo che restituisce la città o paese in cui è collocata la clinica.
     * 
     * @access public
     * @return string La città o paese della clinica
     */
    public function getLocalitaClinica() {
        return $this->_localita;
    }

    /**
     * Metodo che restituisce la provincia della città o paese in cui è collocata la clinica.
     * 
     * @access public
     * @return string La provincia della città o paese della clinica
     */
    public function getProvinciaClinica() {
        return $this->_provincia;
    }

    /**
     * Metodo che restituisce la regione della città o paese in cui è collocata la clinica.
     * 
     * @access public
     * @return string La regione della città o paese della clinica
     */
    public function getRegioneClinica() {
        return $this->_regione;
    }

    /**
     * Metodo che restituisce il numero di telefono dalla clinica.
     * 
     * @access public
     * @return string Il numero di telefono della clinica
     */
    public function getTelefonoClinica() {
        return $this->_telefono;
    }
    
    /**
     * Metodo che restituisce l'username della clinica.
     * 
     * @access public
     * @return string L'username della clinica
     */
    public function getUsernameClinica() {
        return parent::getUsernameUser();
    }

    /**
     * Metodo che restituisce il capitale sociale della clinica.
     * 
     * @access public
     * @return string Capitale sociale della clinica
     */
    public function getCapitaleSocialeClinica() {
        return $this->_capitaleSociale;
    }

    //metodi set

    /**
     * Metodo che imposta il titolare della clinica.
     * 
     * @access public
     * @param string Titolare della clinica
     */
    public function setTitolareClinica($titolare) {
        $this->_titolareClinica = $titolare;
    }

    /**
     * Metodo che imposta il working plan della clinica.
     * 
     * @access public
     * @param string Working plan della clinica
     */
    public function setWorkingPlanClinica($workingPlan) {
        $this->_workingPlan = $workingPlan;
    }

    /**
     * Metodo che imposta la via della clinica.
     * 
     * @access public
     * @param string Via della clinica
     */
    public function setViaClinica($via) {
        $this->_via = $via;
    }

    /**
     * Metodo che permette di modificare la validità della clinica.
     * 
     * @access public
     * @param boolean $validato TRUE se la clinica è stata validata, FALSE altrimenti
     */
    public function setValidatoClinica($validato) {
        $this->_validato = $validato;
    }
    
    /**
     * Metodo che imposta il numero civico della clinica.
     * 
     * @access public
     * @param int Numero civico della clinica
     */
    public function setNumeroCivicoClinica($numCivico) {
        $this->_numeroCivico = $numCivico;
    }

    /**
     * Metodo che imposta il CAP della clinica.
     * 
     * @access public
     * @param string CAP della clinica
     */
    public function setCAPClinica($cap) {
        $this->_CAP = $cap;
    }
    
    /**
     * Metodo che imposta il nome della clinica.
     * 
     * @access public
     * @param string nome della clinica
     */
    public function setNomeClinica($nome) {
        $this->_nomeClinica = $nome;
    }
    
    /**
     * Metodo che imposta la città o paese della clinica.
     * 
     * @access public
     * @param string Località della clinica
     */
    public function setLocalitaClinica($localita) {
        $this->_localita= $localita;
    }

    /**
     * Metodo che imposta la provincia della città o paese della clinica.
     * 
     * @access public
     * @param string Provincia della clinica
     */
    public function setProvinciaClinica($provincia) {
        $this->_provincia = $provincia;
    }

    /**
     * Metodo che imposta la regione della città o paese della clinica.
     * 
     * @access public
     * @param string Regione della clinica
     */
    public function setRegioneClinica($regione) {
        $this->_regione = $regione;
    }

    /**
     * Metodo che imposta il capitale sociale della clinica.
     * 
     * @access public
     * @param string Capitale sociale della clinica
     */
    public function setCapitaleSocialeClinica($cp) {
        $this->_capitaleSociale = $cp;
    }

    /**
     * Metodo che imposta il telefono della clinica.
     * 
     * @access public
     * @param string Telefono della clinica
     */
    public function setTelefonoClinica($tel) {
        $this->_telefono = $tel;
    }

    /**
     * Metodo che permette di impostare gli esami/servizi che la clinica offre.
     * 
     * @access public
     * @param array $esami Esami/servizi della clinica
     */
    public function setEsamiClinica($esami) {
        $this->_esami = $esami;
    }

    /**
     * Metodo che permette di inserire un oggetto di tipo EClinica nel DB.
     * 
     * @access public
     * @return string|boolean Il codice di conferma se la clinica è stata inserita correttamente, altrimenti FALSE (la clinica non è stata inserita correttamente nel DB)
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function inserisciClinicaDB() {
        //crea un oggetto fClinica se non è esistente, si collega al DB e lo inserisce
        $fClinica = USingleton::getInstance('FClinica');
        $fClinica->inserisci($this); 
        return parent::getCodiceConfermaUser();
        
    }

    /**
     * Metodo che consente di salvare nel DB il working plan relativo ad una clinica.
     * 
     * @access public
     * @param string $workingPlan Il working plan da salvare
     * @return boolean TRUE se il salvataggio è stato effettuato, altrimenti lancia eccezione
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function salvaWorkingPlanClinica($workingPlan) {
        $fClinica = USingleton::getInstance('FClinica');
        $daModificare['WorkingPlan'] = $workingPlan;
        return $fClinica->update($this->getPartitaIVAClinica(), $daModificare); //salvaWorkingPlan
    }

    /**
     * Permette di trovare tutti i referti dei clienti della clinica.
     * 
     * @access public
     * @return array Tutti i referti della clinica se ci sono
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function cercaReferti() {
        $fReferto = USingleton::getInstance("FReferto");
        return $fReferto->cercaRefertiClinica($this->getPartitaIVAClinica());
    }

    /**
     * Metodo che trova la regione in base alla provincia inserita dall'utente.
     * 
     * @access private
     * @param string $provincia La provincia di cui trovare la regione
     * @return string Il nome della regione cui corrisponde la provincia
     */
    private function trovaRegione($provincia) {
        switch ($provincia) {
            case 'CHIETI':
            case 'PESCARA':
            case "L'AQUILA":
            case 'TERAMO':
                $regione = 'ABRUZZO';
                break;
            case 'MATERA':
            case 'POTENZA':
                $regione = 'BASILICATA';
                break;
            case 'CATANZARO':
            case 'COSENZA':
            case 'CROTONE':
            case 'REGGIO DI CALABRIA':
            case 'VIBO VALENTIA':
                $regione = 'CALABRIA';
                break;
            case 'AVELLINO':
            case 'BENEVENTO':
            case 'CASERTA':
            case 'NAPOLI':
            case 'SALERNO':
                $regione = 'CAMPANIA';
                break;
            case 'BOLOGNA':
            case 'FERRARA':
            case 'FORLI’-CESENA':
            case 'MODENA':
            case 'PARMA':
            case 'PIACENZA':
            case 'RAVENNA':
            case "REGGIO NELL'EMILIA":
            case 'RIMINI':
                $regione = 'EMILIA ROMAGNA';
                break;
            case 'GORIZIA':
            case 'PORDENONE':
            case 'TRIESTE':
            case 'UDINE':
                $regione = 'FRIULI VENEZIA GIULIA';
                break;
            case 'FROSINONE':
            case 'LATINA':
            case 'RIETI':
            case 'ROMA':
            case 'VITERBO':
                $regione = 'LAZIO';
                break;
            case 'GENOVA':
            case 'IMPERIA':
            case 'LA SPEZIA':
            case 'SAVONA':
                $regione = 'LIGURIA';
                break;
            case 'BERGAMO':
            case 'BRESCIA':
            case 'COMO':
            case 'CREMONA':
            case 'LECCO':
            case 'LODI':
            case 'MANTOVA':
            case 'MILANO':
            case 'MONZA E DELLA BRIANZA':
            case 'PAVIA':
            case 'SONDRIO':
            case 'VARESE':
                $regione = 'LOMBARDIA';
                break;
            case 'ANCONA':
            case 'ASCOLI PICENO':
            case 'FERMO':
            case 'MACERATA':
            case 'PESARO E URBINO':
                $regione = 'MARCHE';
                break;
            case 'CAMPOBASSO':
            case 'ISERNIA':
                $regione = 'MOLISE';
                break;
            case 'ALESSANDRIA':
            case 'ASTI':
            case 'BIELLA':
            case 'CUNEO':
            case 'NOVARA':
            case 'TORINO':
            case 'VERBANO-CUSIO-OSSOLA':
            case 'VERCELLI':
                $regione = 'PIEMONTE';
                break;
            case 'BARI':
            case 'BARLETTA-ANDRIA-TRANI':
            case 'BRINDISI':
            case 'FOGGIA':
            case 'LECCE':
            case 'TARANTO':
                $regione = 'PUGLIA';
                break;
            case 'CAGLIARI':
            case 'CARBONIA-IGLESIAS':
            case 'MEDIO CAMPIDANO':
            case 'NUORO':
            case 'OGLIASTRA':
            case 'OLBIA-TEMPIO':
            case 'ORISTANO':
            case 'SASSARI':
                $regione = 'SARDEGNA';
                break;
            case 'AGRIGENTO':
            case 'CALTANISSETTA':
            case 'CATANIA':
            case 'ENNA':
            case 'MESSINA':
            case 'PALERMO':
            case 'RAGUSA':
            case 'SIRACUSA':
            case 'TRAPANI':
                $regione = 'SICILIA';
                break;
            case 'AREZZO':
            case 'FIRENZE':
            case 'GROSSETO':
            case 'LIVORNO':
            case 'LUCCA':
            case 'MASSA-CARRARA':
            case 'PISA':
            case 'PISTOIA':
            case 'PRATO':
            case 'SIENA':
                $regione = 'TOSCANA';
                break;
            case 'BOLZANO':
            case 'TRENTO':
                $regione = 'TRENTINO ALTO ADIGE';
                break;
            case 'PERUGIA':
            case 'TERNI':
                $regione = 'UMBRIA';
                break;
            case 'AOSTA':
                $regione = "VALLE D'AOSTA";
                break;
            case 'BELLUNO':
            case 'PADOVA':
            case 'ROVIGO':
            case 'TREVISO':
            case 'VENEZIA':
            case 'VERONA':
            case 'VICENZA':
                $regione = 'VENETO';
                break;
        }
        return $regione;
    }

    /**
     * Metodo che consente di cercare tutte le prenotazioni della clinica.
     * 
     * @access public
     * @return array Tutte le prenotazioni di una clinica
     * @throws XDBException Se la query non viene eseguita con successo
     */
    public function cercaPrenotazioni() {
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        return $fPrenotazioni->cercaPrenotazioniClinica($this->_partitaIVA);
    }

    /**
     * Metodo che consente di cercare tutti gli esami/servizi della clinica.
     * 
     * @access public
     * @return array Tutti gli esami/servizi che offre la clinica
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function cercaEsami() {
        $fEsami = USingleton::getInstance('FEsame');
        $this->_esami = $fEsami->cercaEsame(NULL, $this->_nomeClinica, NULL);
        return $this->_esami;
    }
    
    /**
     * Metodo che consente di sapere se un esame è presente nella clinica.
     * 
     * @access public
     * @param string $nomeEsame Il nome dell'esame da cercare
     * @param string $nomeClinica Il nome della clinica in cui cercre l'esame
     * @return boolean TRUE Esame esistente, FALSE altrimenti
     * @throws XDBException  Se la query non viene eseguita con successo
     */
    public function esisteEsame($nomeEsame,$nomeClinica ) {
        $esiste = FALSE;
        $fEsami = USingleton::getInstance('FEsame');
        $risultato = $fEsami->cercaEsame($nomeEsame, $nomeClinica); 
        if(is_array($risultato) && count($risultato)>1)
        {
            $esiste = TRUE;
        }
        return $esiste;
    }

    /**
     * Metodo che consente di ottenere i giorni non lavorativi della clinica.
     * 
     * @access public
     * @return array I giorni non lavorativi della clinica
     */
    public function getGiorniNonLavorativi() {
        $giorniNonLavorativi = Array();
        foreach ($this->getArrayWorkingPlanClinica()as $key => $value) {
            if ($value === NULL) {
                $giorniNonLavorativi[] = $key;
            }
        }
        return $giorniNonLavorativi;
    }

    /**
     * Metodo che calcola gli orari disponibili per una prenotazione.
     * 
     * @access public
     * @param EEsame $eEsame 
     * @param array $workingPlanGiorno Il working plan di una giornata
     * @return array Orari disponibili
     */
    public function calcoloOrariDisponibili($eEsame, $workingPlanGiorno) {
        $vPrenotazione = USingleton::getInstance('VPrenotazione');
        $durata = $eEsame->getDurataEsame();
        $ora = substr($durata, 0, 2);
        $minuti = substr($durata, 3, 2);
        // la stringa durata deve essere convertita in un intervallo
        $durata = new DateInterval('PT' . "$ora" . 'H' . "$minuti" . 'M'); //PT sta per period time
        //all'interno di workingPlan ad ogni giorno è associato un oggetto con attributi Start, End, Pausa
        $oraInizio = $workingPlanGiorno->Start;
        $oraFine = $workingPlanGiorno->End;
        $oraInizioPausa = new DateTime($workingPlanGiorno->BreakStart); 
        $oraFinePausa = new DateTime($workingPlanGiorno->BreakEnd);
        $orariPrenotazioni = Array();
        //converto la stringa $oraInizio in un oggetto Time
        $oraInizio = new DateTime($oraInizio);
        //converto la stringa $oraFine in un oggetto Time
        $oraFine = new DateTime($oraFine);
        $oraInizioEsame = $oraInizio;
        while ($oraInizioEsame <= $oraFine) {
            $oraFineEsame = clone $oraInizioEsame; // clono l'oggetto (quindi non ho un passaggio per riferimento)
            $oraFineEsame = $oraFineEsame->add($durata); // l'orario in cui termirebbe l'esame
            if($oraFineEsame <= $oraInizioPausa || $oraInizioEsame >= $oraFinePausa) // se l'orario non ricade all'interno dell'intervallo di pausa della clinica
            {    //aggiungo l'orario disponibile successivo
                $orariPrenotazioni[] = $oraInizioEsame->format("H:i");
            }
            //aggiungo un intervallo pari alla durata dell'esame all'orario disponibile precedente 
            $oraInizioEsame = $oraInizioEsame->add($durata);
        };
        if ($oraInizioEsame > $oraFine) {
            array_pop($orariPrenotazioni);
        }
        // ora che ho tutti gli orari della giornata, cerco gli orari delle prenotazione già effettuate
        $data = $vPrenotazione->recuperaValore('data');
        $fPrenotazioni = USingleton::getInstance('FPrenotazione');
        $prenotazioni = $fPrenotazioni->cercaPrenotazioniEsameClinicaData($eEsame->getIDEsameEsame(), $this->_partitaIVA, $data);
        $orariPrenotati = Array();
        if (is_array($prenotazioni) || !is_bool($prenotazioni)) {
            foreach ($prenotazioni as $prenotazione) {
                foreach ($prenotazione as $key => $value) {
                    if ($key === "DataEOra") {
                        $value = substr($value, 11, 5);
                        $orariPrenotati[] = $value;
                    }
                }
            }
        } else {
            // errore
        }
        $orariDisponibili = array_diff($orariPrenotazioni, $orariPrenotati); //Compares array1 against one or more other arrays and returns the values in array1 that are not present in any of the other arrays. 
        return $orari = Array('orari' => $orariDisponibili);
    }

    /**
     * Metodo che permette di trovare tutti i clienti di una clinica.
     * 
     * @access public
     * @return array Tutti i clienti della clinica se ci sono
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function cercaClienti() {
        $fClinica = USingleton::getInstance('FClinica');
        return $fClinica->cercaClienti(parent::getUsernameUser());
    }

    /**
     * Metodo che consente di recuparare gli appuntamenti della clinica in questo caso giornalieri.
     * 
     * @access public
     * @param string $start Stringa contenente data e ora in formato YYYY-MM-DD hh:mm da cui bisogna inziare il recupero
     * @param string $end Stringa contenente data e ora in formato YYYY-MM-DD hh:mm fino cui bisogna effettuare il recupero
     * @return array Gli appuntamenti 
     * @throws XDBException Se la query non è stata eseguita con successo
     * @throws XClinicaException Se la query ritorna un array
     */
    public function recuperaAppuntamenti($start, $end) {
        $fClinica = USingleton::getInstance('FClinica');
        $risultato = $fClinica->cercaAppuntamenti($this->getPartitaIVAClinica(),$start, $end);

        if(is_array($risultato) && count($risultato)>=0)
        {
            $appuntamenti=Array();
            $i=0;
            $dataOdierna = date('Y-m-d');
            foreach ($risultato as $appuntamento) 
            {
                $title = ""; $start =""; $end=""; $cliente="";
                foreach ($appuntamento as $key => $value) 
                {
                    switch ($key) 
                    {
                        case 'IDPrenotazione':
                            $id = $value;
                            break;
                        
                        case 'NomeEsame':
                            $esame = ucfirst($value);
                            $title = ucfirst($value);
                            break;
                        case 'Nome':
                        case 'Cognome':
                            $cliente = $cliente . " " . ucfirst($value);
                            $title = $title . " " . ucfirst($value);
                            break;
                        case 'Orario':
                            $start = substr($value, 0, 5);
                            break;
                        case 'Data':
                            $data = $value;                            
                            break;
                        case 'Durata':
                            $ore = substr($value, 0, 2);
                            $minuti = substr($value, 3, 2);
                            if ($ore = "00") {
                                $durata = "+" . $minuti . " minutes";
                            } else {
                                $durata = "+" . $ore . " hour +" . $minuti . " minutes";
                            }
                            $end = strtotime($durata, strtotime($start));
                            $intervalEnd = date('H:i', $end); // rendo stringa il timestamp $end nel formato minuti:secondi
                            $end =$dataOdierna . " " . $intervalEnd;
                            break;
                        case 'Eseguita':
                            $eseguita = $value;
                            break;
                         
                    }
                }
                $appuntamenti[$i] = Array('id'=>$id, 'title'=> $title, 'start'=>$data, 'intervalStart'=> $start, 'intervalEnd'=>$intervalEnd, 'end'=>$data, 'esame'=>$esame, 'cliente'=>$cliente, 'eseguito'=>$eseguita );//, 
                $i++;
            }
            return $appuntamenti;
        } else {
            throw new XClinicaException("Errore durante il recupero degli appuntamenti");
        }
    }

    /**
     * Metodo che consente di recuperare appuntamenti e working plan della clinica.
     * 
     * @access public
     * @param string $start Stringa contenente data e ora in formato YYYY-MM-DD hh:mm da cui bisogna inziare il recupero
     * @param string $end Stringa contenente data e ora in formato YYYY-MM-DD hh:mm fino cui bisogna effettuare il recupero
     * @return array Contiene un array di appuntamenti e un array workingPlan
     * @throws XDBException Se la query non è stata eseguita con successo
     * @throws XClinicaException Se la query ritorna un array
     */
    public function recuperaAppuntamentiEWorkingPlan($start, $end) 
    {
        $appuntamenti = $this->recuperaAppuntamenti($start, $end);
        $workingPlan = $this->getArrayWorkingPlanClinica();
        return Array('appuntamenti'=>$appuntamenti, 'workingPlan'=>$workingPlan);
    }
    
    
    /**
     * Metodo che consente di modificare i dati della clinica.
     * 
     * @access public
     * @param array $datiDaModificare I dati della clinica da modificare
     * @throws XDBException Se la query non è stata eseguita con successo
     * @return boolean TRUE se la modifica è andata a buon fine, altrimenti lancia l'eccezione
     */
    public function modificaClinica($datiDaModificare) {
        
        foreach ($datiDaModificare as $key => $value) {
            switch ($key) {
                case 'username':
                    $this->setUsername($value);
                    break;
                case 'codiceConferma':
                    $this->setCodiceConfermaUser($value);
                    break;
                case 'confermato':
                    if($value === 'true')
                    {
                        $this->setConfermato('TRUE');
                    }
                    else 
                    {
                        $this->setConfermato('FALSE');
                    }
                    break;
                case 'validato':
                    if($value === 'true')
                    {
                        $this->setValidatoClinica('TRUE');
                    }
                    else 
                    {
                        $this->setValidatoClinica('FALSE');
                    }
                    break;
                case 'bloccato':
                    if($value === 'true')
                    {
                        $this->setBloccato('TRUE');
                    }
                    else
                    {
                        $this->setBloccato('FALSE');
                    }
                    break;
                case 'email':
                    $this->setEmail($value);
                    break;
                
                case 'partitaIva':
                    $this->setTitolareClinica($value);
                    break;
                case 'nomeClinica':
                    $this->setNomeClinica($value);
                    break;
                case 'titolareClinica':
                case 'titolare':
                    $this->setTitolareClinica($value);
                    break;
                case 'via':
                case 'Via':
                    $this->setViaClinica($value);
                    break;
                case 'numeroCivico':
                case 'NumCivico':
                    $this->setNumeroCivicoClinica($value);
                    break;
                case 'CAP':
                    $this->setCAPClinica($value);
                    break;
                case 'localita':
                case 'localitaClinica':
                    $this->setLocalitaClinica($value);
                    break;
                case 'provincia':
                case 'provinciaClinica':
                    $this->setProvinciaClinica($value);
                    $this->trovaRegione($value);
                    break;
                case 'PEC':
                case 'pec':
                    $this->setPEC($value);
                    break;
                case 'telefono':
                    $this->setTelefonoClinica($value);
                    break;
                case 'capitaleSociale':
                    $this->setCapitaleSocialeClinica($value);
                    break;
                case 'passwordClinica':
                    if(!empty($value))
                    {
                        $this->modificaPassword($value);
                    }
                    break;
                default:
                    break;
            }
        }
        $fClinica = USingleton::getInstance('FClinica');
        return $fClinica->modificaClinica($this);
    }
    
    /**
     * Metodo che consente di ottenere una lista delle categorie che sono presenti nell'applicazione.
     * 
     * @access public
     * @return array Se la query è stata eseguita con successo, in caso contrario lancerà l'eccezione
     * @throws XDBException Se la query non è stata eseguita con successo
     */
    public function getCategorieApplicazione() {
        $categorie = USingleton::getInstance('FCategoria');
        return $listaCategorie = $categorie->cerca(); //cercaCategorie
    }
}

?>