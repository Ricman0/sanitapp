<?php

/**
 * La classe Config si occupa della configurazione.
 *
 * @package include
 * @author Claudia Di Marco & Riccardo Mantini
 */

    
// in __DIR__ è contenuta il percorso della cartella che contiene il file ma Autoloder.php non si trova in include ma in libs 
// per questo bisogna eliminare include dal path
$dir = explode(DIRECTORY_SEPARATOR, __DIR__); // tutte le parole che compongono il path vengono memorizzate in un elemento dell'array $dir
array_pop($dir);// elimino l'ultimo elemento (ovvero la parola include)
$dir = implode(DIRECTORY_SEPARATOR, $dir);// riassemblo il path
require_once ($dir . '/libs/smartyLib/Autoloader.php');

class Config {
    
    /**
     * @var array Array associativo: come chiavi  i nomi degli attributi 
     *            della classe Smarty e come valori i path delle directory
     *            templates, templates_c, configs e cache 
     */
    private $smartyConfig;
    
    /**
     * @var array Array associativo: come chiavi username, password, host, dbname
     *            e come valori i rispettivi valori
     */
    private $dbConfig;
    
    /**
     * @var array Array associativo: come chiavi header, host, SMTPSecure, 
     *            port, SMTPAuth, username, password, from, fromname e come 
     *            valori i rispettivi valori
     */
    private $emailConfig;

    /**
     * Inizializza gli array necessari per la configurazione
     */
    public function __construct() 
    {
        $this->setSmartyConfig();
        $this->setDBConfig();
        $this->setEmailConfig();
    }

    /**
     * Metodo che restituisce un array contenente il necessario per la 
     * configurazione di Smarty
     * 
     * @access public
     * @return array Array associativo: come chiavi  i nomi degli attributi 
     *               della classe Smarty e come valori i path delle directory
     *               templates, templates_c, configs e cache
     */
    public function getSmartyConfig() 
    {
        return $this->smartyConfig;
    }
    
    /**
     * Metodo che restituisce un array contenente il necessario per la 
     * configurazione del database
     * 
     * @access public
     * @return array Array associativo: come chiavi username, password, host, dbname
     *               e come valori i rispettivi valori
     */
    public function getDBConfig() 
    {
        return $this->dbConfig;
    }
    /**
     * Metodo che restituisce un array contenente il necessario per la 
     * configurazione di PHPMailer
     * 
     * @access public
     * @return array L'array contenente come chiavi header, host, SMTPSecure, 
     *               port, SMTPAuth, username, password, from, fromname e come 
     *               valori i rispettivi valori
     */
    public function getEmailUserConfig() 
    {
        return $this->emailConfig;
    }

    /**
     * Metodo utilizza per modificare la configurazione di Smarty
     * 
     * @access private
     */
    private function setSmartyConfig() 
    {
        // in __DIR__ è contenuta il percorso della cartella che contiene il file ma Autoloder.php non si trova in include ma in libs 
        // per questo bisogna eliminare include dal path
        $dir = explode(DIRECTORY_SEPARATOR, __DIR__); // tutte le parole che conpongono il path vengono memorizzate in un elemento dell'array $dir
        array_pop($dir);// elimino l'ultimo elemento (ovvero la parola include)
        $dir = implode(DIRECTORY_SEPARATOR, $dir);// riassemblo il path
        Smarty_Autoloader::register();
        $this->smartyConfig['template_dir'] = $dir . '/templates/smartyDir/templates/';
        $this->smartyConfig['compile_dir'] = $dir . '/templates/smartyDir/templates_c/';
        $this->smartyConfig['config_dir'] = $dir . '/templates/smartyDir/configs/';
        $this->smartyConfig['cache_dir'] = $dir . '/templates/smartyDir/cache/';
    }
    
    
 private function setDBConfig() {
$this->dbConfig['username'] ='sanitapp';
$this->dbConfig['password'] ='pippo';
$this->dbConfig['host'] ='localhost';
$this->dbConfig['dbname'] ='my_sanitapp';
}

 private function setEmailConfig(){
$this->emailConfig['header']= 'From:SanitApp <sanitapp@site.com>';
$this->emailConfig['host']='smtp.live.com';
$this->emailConfig['SMTPSecure']='tls';
$this->emailConfig['port']=25;
$this->emailConfig['SMTPAuth']=TRUE;
$this->emailConfig['username']='onizuka-89@hotmail.it';
$this->emailConfig['password']='viadelcarmine31';
$this->emailConfig['from']='onizuka-89@hotmail.it';
$this->emailConfig['fromname']='SanitApp';
}
}