<?php

/**
 * Description of View
 * 
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */

// in __DIR__ è contenuta il percorso della cartella che contiene il file ma Autoloder.php non si trova in include ma in libs 
// per questo bisogna eliminare include dal path
$dir = explode(DIRECTORY_SEPARATOR, __DIR__); // tutte le parole che conpongono il path vengono memorizzate in un elemento dell'array $dir
array_pop($dir);// elimino l'ultimo elemento (ovvero la parola include)
$dir = implode(DIRECTORY_SEPARATOR, $dir);// riassemblo il path

require ($dir . '/libs/smartyLib/Smarty.class.php');

class View extends Smarty {

    /**
     * Costruttore della classe View
     * it will take care of the smarty details for us. 
     * This approach has another advantage: if, at one moment in time, 
     * you should choose to use another template engine,
     *  you can create a wrapper for that engine, 
     * while retaining the SMTemplate interface, 
     * and thus without breaking the code that uses View class.
     * 
     * @final
     * @access public
     */
    final public function __construct() {
        // dichiaro questo metodo finale perchè non voglio 
        // che sia sovrascritto da altre classi che la ereditano
        parent::__construct(); // richiamo il costruttore di Smarty
        //se non esiste creo un'istanza della classe config (di config.php)
        $config = USingleton::getInstance('Config');
        //$smartyConfig è un'array in cui memorizzo il necessario per la configurazione 
        //di Smarty in modo da poter settare le dir di View
        $smartyConfig = $config->getSmartyConfig();
        $this->template_dir = $smartyConfig['template_dir'];
        $this->compile_dir = $smartyConfig['compile_dir'];
        $this->config_dir = $smartyConfig['config_dir'];
        $this->cache_dir = $smartyConfig['cache_dir'];
        /*
         * Il caching si usa per velocizzare una chiamata a display() 
         * o fetch() salvando il suo output su un file. Se una versione 
         * della chiamata è disponibile in cache, viene visualizzata questa 
         * invece di rigenerare l'output.
         * Col caching abilitato, la chiamata alla funzione 
         * display('index.tpl') causa la normale generazione del template, 
         * ma oltre a questo salva una copia dell'output in un file 
         * (la copia in cache) nella $cache_dir. Alla chiamata successiva 
         * di display('index.tpl'), verrà usata la copia in cache invece di 
         * generare di nuovo il template.La funzione is_cached() 
         * può essere usata per verificare se un template
         *  ha una cache valida oppure no
         */
        $this->caching = false;
        /*  Ogni pagina in cache ha un tempo 
         * di vita limitato, determinato da $cache_lifetime. 
         * Il valore di default è 3600 secondi, cioè 1 ora. 
         */
        $this->cache_lifetime = 0;
        /* Se $compile_check è abilitato, tutti i file di template e di 
         * configurazione che sono coinvolti nel file della cache vengono
         * verificati per vedere se sono stati modificati.
         * Se qualcuno dei file ha subito una modifica dopo che la cache
         * è stata generata, il file della cache viene rigenerato. 
         * Questo provoca un piccolo sovraccarico, quindi, 
         * per avere prestazioni ottimali, lasciate $compile_check a false. 
         */
        $this->compile_check = false;
        /*
         * C'è una console di debugging inclusa in Smarty. La console vi 
         * informa di tutti i template che sono stati inclusi, 
         * le variabili assegnate e quelle dei file di configurazione per la 
         * chiamata attuale del template. Nella distribuzione di Smarty è 
         * incluso un template chiamato 
         */
        $this->debugging = false;
    }

    /**
     * Metodo che preleva e restituire il template specificato
     * 
     * @access public
     * @final
     * @param string $nomeTemplate Il template da prelevare
     * @return mixed Il template prelevato
     */
    final public function prelevaTemplate($nomeTemplate) {
        /*
         * fetch preleva il template il cui nome è $nomeTemplate.tpl
         * e lo ritorna come testo invece che effettuate il display del template.
         * Questo significa che si può prelevare il template e poi
         * assegnarlo ad una variabile presente all'interno di un template.
         */
        $template = $this->fetch($nomeTemplate . '.tpl');
        return $template;
    }

    /**
     * Metodo che permette di assegnare un valore alla variabile presente nel template.
     * 
     * @access public
     * @final
     * @param String $nomeVariabile Il nome della variabile a cui deve
     *                              essere assegnato il dato nel template
     * @param mixed $dati Dati da passare al template
     */
    final public function assegnaVariabiliTemplate($nomeVariabile, $dati) {

        $this->assign($nomeVariabile, $dati);
    }

    /**
     * Metodo che carica un template e lo visualizza.
     * 
     * @access public
     * @final
     * @param String $nomeTemplate Il nome del template da caricare e visualizzare
     */
    final public function visualizzaTemplate($nomeTemplate) {
        $this->display($nomeTemplate . '.tpl');
    }
    
    /**
     * Metodo che permette di conoscere il valore di controller dell'URL
     * 
     * @access public
     * @return mixed Ritorna il valore di controller, se è settato. FALSE altrimenti
     */
    public function getController() 
    {
        if (isset($_REQUEST['controller'])) 
            {
                return $_REQUEST['controller'];
            } 
        else 
            {
                return "FALSE";
            }
    }

    /**
     *  Metodo che permette di conoscere il valore di task dell'URL.
     * 
     * @access public
     * @final
     * @return string|boolean Ritorna il valore (stringa) di task. FALSE altrimenti.
     */
    final public function getTask() 
    {
        if (isset($_REQUEST['task'])) 
        {
            return $_REQUEST['task'];
        }
        else 
        {
            return FALSE;
        }
    }

    /**
     *  Metodo che permette di conoscere il valore di task2 dell'URL
     * 
     * @access public
     * @final
     * @return string|boolean Ritorna il valore (stringa) di task2. FALSE altrimenti.
     */
    final public function getTask2() 
    {
        if (isset($_REQUEST['task2'])) 
        {
            return $_REQUEST['task2'];
        }
        else 
        {
            return FALSE;
        }
    }
  

    /**
     * Metodo che permette di recuperare dall'array REQUEST il valore dell'elemento a cui corrisponde l'indice passato come parametro.
     * 
     * @access public
     * @param string $indice Il nome dell'indice il cui valore deve essere recuperato dall'array REQUEST
     * @return string|boolean Il valore recuperato, FALSE altrimenti
     */
    public function recuperaValore($indice) 
    {
        
        if (isset($_REQUEST[$indice])) 
            {
                return trim($_REQUEST[$indice]);
            } 
        else 
            {
                return FALSE;
            }
    }

    /**
     * Metodo che permette di recuperare dall'array FILES il file inserito dall'utente
     * in un campo della form. Il campo è individuato dall'indice.
     * 
     * @access public
     * @param string $indice Il nome dell'indice che deve essere recuperato dall'array FILES
     * @throws XDatiRefertoException Lanciata se il file non esiste oppure ha dimensione nulla
     * @return array le proprietà del file recuperato
     */
    public function recuperaInfoFile($indice) {
        if ($_FILES[$indice]['size'] > 0) 
        {
            $infoFile['uploadDir'] = './uploadedFiles/referti/';
            $infoFile['fileName'] = basename($_FILES[$indice]['name']);
            $infoFile['tmpName'] = $_FILES[$indice]['tmp_name']; //nome temporaneo
            $infoFile['fileSize'] = $_FILES[$indice]['size'];
            $infoFile['fileType'] = $_FILES[$indice]['type'];
            $infoFile['path'] = $infoFile['uploadDir']. $infoFile['fileName'];            
        }
         else 
        {
            throw new XDatiRefertoException('Non è stato postato alcun file. ');
        }
        return $infoFile;
    }
    
     public function recuperaFile($indice) {
        $file = addslashes(file_get_contents($_FILES[$indice]['tmp_name']));
        return $file;
    }
    
    
    /**
     * Visualizza una pagina di errore con un messaggio di errore.
     * 
     * @access public
     * @param string|array $messaggio Il messaggio o i messaggi da mandare in output
     */    
    public function visualizzaFeedback($messaggio, $homePage=NULL) {
        $this->assegnaVariabiliTemplate('messaggio', $messaggio);  
        $this->assegnaVariabiliTemplate('homePage', $homePage);
        $this->visualizzaTemplate('feedbacks');
        
    }
    
    /**
     * Metodo che consente di recuparare i dati inviati tramite POST
     * 
     * @access public
     * @return Array I dati da validare
     */
    public function recuperaDatidaValidare(){
        $datiDaValidare; 
        foreach ($_POST as $key => $value) {
            $datiDaValidare[$key] = trim($value);
        }
        return $datiDaValidare;
    }

}
