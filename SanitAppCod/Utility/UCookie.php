<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UCookie
 *
 * @package Utility
 * @author Claudia Di Marco & Riccardo Mantini
 */
class UCookie {
    
    const ORA = 3600;
    const GIORNO = 86400; //in secondi
    const SETTIMANA = 604800;
    const MESE = 2592000;
    const ANNO = 31536000;
    
    public function __construct($name = 'cookieDefault', $value = 'valoreDefault',
            $expire = self::ORA , $path = '/', $domain = 'sanitapp.it', 
            $secure = 'FALSE', $httponly = 'FALSE')
    {
        setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
    }
    
    /**
     * Metodo che permette di controllare se esiste un cookie con il nome
     * passato per parametro
     * 
     * @access public
     * @param string $name Il nome del cookie
     * @return boolean True se il cookie esiste, false altrimenti
     */
    public function esisteCookie($name)
    {
        if(isset($_COOKIE[$name]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Metodo che permette di controllare se il cookie con il nome
     * passato per parametro è vuoto
     * 
     * @access public
     * @param string $name Il nome del cookie
     * @return boolean True se il cookie è vuoto o se non esiste alcun 
     *                 cookie con questo nome, false altrimenti
     */
    public function cookieVuoto($name)
    {
        if(empty($_COOKIE[$name]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
 
    /**
     * Metodo che restituisce il valore del cookie
     * 
     * @access public
     * @param string $name Il nome del cookie 
     * @return mixed Valore del cookie se esiste, false altrimenti.
     */
    public function getCookie($name) 
    {
        if(isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        else
            return false;
    }
    
    
   /**
    * Metodo che consente di eliminare un cookie esistente
    * 
    * @access public
    * @param string $name Il nome del cookie
    */
   public function eliminaCookie($name) 
   {
       if(isset($_COOKIE[$name]))
        {
           // imposto l'expiration date un'ora prima
           setcookie($name, "", time()-3600 );
        }
   }
   
   /**
    * Metodo che consente di capire se i cookie sono abilitati
    * 
    * @access public
    * @return boolean true se sono abilitati, false altrimenti.
    */
   public function cookieAbilitati()
   {
       if(count($_COOKIE) > 0) 
            {
                return true;
            } 
        else 
            {
                return false;
            }
   }
}
