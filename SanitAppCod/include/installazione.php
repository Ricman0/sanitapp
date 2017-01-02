<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Config
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

class config {
    
    /**
     * @var Array Array associativo: come chiavi  i nomi degli attributi 
     *            della classe Smarty e come valori i path delle directory
     *            templates, templates_c, configs e cache 
     */
    private $smartyConfig;
    
    /**
     * @var Array Array associativo: come chiavi username, password, host, dbname
     *            e come valori i rispettivi valori
     */
    private $dbConfig;
    
    /**
     * @var Array Array associativo: come chiavi header, host, SMTPSecure, 
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
     * @return Array Array associativo: come chiavi  i nomi degli attributi 
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
     * @return Array Array associativo: come chiavi username, password, host, dbname
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
     * @return Array L'array contenente come chiavi header, host, SMTPSecure, 
     *               port, SMTPAuth, username, password, from, fromname e come 
     *               valori i rispettivi valori
     */
    public function getEmailConfig() 
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
    
