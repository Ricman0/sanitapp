<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EMedico
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EMedico
{
    //attributi della classe EMedico
    /**
     * @var string $_codiceConferma, variabile che contiente il codice per confermare 
     * l'account del medico
     */
    private $_codiceConferma; 
    
    /**
     * @var string $_codFiscale Il codice fiscale del medico
     */
    private $_codFiscale;
    
    /**
     * @var string $_nome Il nome del medico
     */
    private $_nome;
    
    /**
     * @var string $_cognome Il cognome del medico
     */
    private $_cognome;
    
    /**
     * @var string $_email L'email del medico
     */
    private $_email;
    
    /**
     * @var string $_via La via in cui ha ... il medico
     */
    private $_via;
    /**
     * @var  int $_numeroCivico Numero civico del medico
     */
    private $_numeroCivico;
    /**
     * @var  string $_CAP CAP della città o paese in cui si trova il medico
     */
    private $_CAP;
    
    /**
     * @var string $_PEC L'indizzo email certificato del medico
     */
    private $_PEC;
    
    /**
     * @var string $_password Password scelta e usata dal medico per accedere al sistema
     */
    private $_password;
    
    /**
     * @var boolean $_validato Indica se il medico è stato validato dal amministratore
     */
    private $_validato;
    
    /**
     * @var string $_provinciaAlbo Indica la provincia in cui il medico è iscritto all'albo
     */
    private $_provinciaAlbo;
    
    /**
     * @var string $_numIscrizione Indica il numero di iscrizione del medico nell'albo
     */
    private $_numIscrizione;
    
    /**
     * @var string $_confermato permette di capire se l'account del medico è 
     * stato confermato(TRUE) o meno          
     */
    private $_confermato;
    
    /**
     * Costruttore della classe EMedico
     * 
     * @param string $nome Il nome del medico
     * @param string $cognome Il cognome del medico
     * @param string $cf Il codice fiscale del medico
     * @param string $via La via in cui risiede il medico
     * @param string $cap Il cap del paese in cui risiede il medico
     * @param string $email L'email del medico
     * @param string $password La password del medico
     * @param string $PEC La PEC del medico
     * @param string $provinciaAlbo La provincia dell'albo in cui il medico è iscritto
     * @param string o int? $numIscrizione Il numero di iscrizione nell'albo del medico
     * @param int o string? $cod Il codice per confermare l'account
     */
    public function __construct($nome, $cognome, $cf, $via, $cap, $email, $password, $PEC, $provinciaAlbo, $numIscrizione, $cod) 
    {
        $this->_nome = $nome;
        $this->_cognome = $cognome; 
        $this->_codFiscale = $cf;
        $this->_via = $via;
        $this->_numeroCivico = NULL; 
        $this->_CAP = $cap; 
        $this->_email = $email; 
        $this->_password = $password; 
        $this->_validato = FALSE;
        $this->_PEC = $PEC;
        $this->_provinciaAlbo = $provinciaAlbo;
        $this->_numIscrizione = $numIscrizione;
        $this->_confermato = FALSE;
        $this->_codiceConferma = $cod;
    }
    
    //metodi get
    /**
     * Metodo per conoscere il nome del medico
     * 
     * @return string Il nome del medico
     */ 
    public function getNomeMedico()
    {
        return $this->_nome;
    }
    
    /**
     * Metodo per conoscere il cognome del medico
     * 
     * @return string Il cognome del medico
     */
    public function getCognomeMedico()
    {
        return $this->_cognome;
    }
    
    /**
     * Metodo per conoscere il codice fiscale del medico
     * 
     * @return string Il codice fiscale del medico
     */
    public function getCodiceFiscaleMedico()
    {
        return $this->_codFiscale;
    }
    
    /**
     * Metodo per conoscere la via in cui risiede il medico
     * 
     * @return string Il nome della via in cui risiede il medico
     */
    public function getViaMedico()
    {
        return $this->_via;
    }
    
    /**
     * Metodo per conoscere il numero civico della via in cui risiede il medico
     * 
     * @return int Il numero civico della via in cui risiede il  medico
     */
    public function getNumCivicoMedico()
    {
        return $this->_numeroCivico;
    }
    
    /**
     * Metodo per conoscere il cap del paese in cui risiede il medico
     * 
     * @return int Il cap del paese in cui risiede il medico
     */
    public function getCAPMedico()
    {
        return $this->_CAP;
    }
    
    /**
     * Metodo per conoscere il codice di conferma del medico
     * 
     * @return int/string Il codice del medico 
     */
    public function getCodiceConfermaMedico()
    {
        return $this->_codiceConferma;
    }
    
    /**
     * Metodo per conoscere l'email del medico
     * 
     * @return string L'email del medico
     */ 
    public function getEmailMedico()
    {
        return $this->_email;
    }
    
    /**
     * Metodo per conoscere la PEC  del medico
     * 
     * @return string La PEC del medico
     */ 
    public function getPECMedico()
    {
        return $this->_PEC;
    }
    
    /**
     * Metodo per conoscere se il medico è stato validato 
     * 
     * @return boolean True se il medico è stato validato, False altrimenti
     */ 
    public function getValidatoMedico()
    {
        return $this->_validato;
    }
    
    /**
     * Metodo per conoscere il numero d'iscrizione del medico all'albo
     * 
     * @return string Il numero d'iscrizione del medico all'albo
     */ 
    public function getnumIscrizioneMedico()
    {
        return $this->_numIscrizione;
    }
    
    /**
     * Metodo per conoscere la provincia dell'albo a cui è iscritto il medico
     * 
     * @return string La provincia dell'albo a cui è iscritto il medico
     */ 
    public function getProvinciaAlboMedico()
    {
        return $this->_provinciaAlbo;
    }
    
    /**
     * Metodo per conoscere la password del medico
     * 
     * @return string La password del medico
     */ 
    public function getPasswordMedico()
    {
        return $this->_password;
    }
    
    /**
     * Metodo che permette di capire se l'account è stato confermato o meno
     * 
     * @return boolean TRUE se l'account è stato confermato, FALSE altrimenti
     */
    public function getConfermatoMedico()
    {
        return $this->_confermato;
    }
    //metodi set
    
    /**
     * Metodo che permette di modificare il nome del medico
     * 
     * @param string $nome Il nome del medico
     */ 
    public function setNomeMedico($nome)
    {
        $this->_nome = $nome;
    }
    
    /**
     * Metodo che permette di modificare il cognome del medico
     * 
     * @param string $cognome Il cognome del medico
     */
    public function setCognomeMedico($cognome)
    {
        $this->_cognome = $cognome;
    }
    
    /**
     * Metodo che permette di modificare il codice fiscale del medico
     * 
     * @param string $codFiscale Il codice fiscale del medico
     */
    public function setCodiceFiscaleMedico($codFiscale)
    {
        $this->_codFiscale = $codFiscale;
    }
    
    /**
     * Metodo che permette di modificare l'email del medico
     * 
     * @param string $email L'email del medico
     */ 
    public function setEmailMedico($email)
    {
        return $this->_email = $email;
    }
    /**
     * Metodo che permette di modificare la via del medico
     * 
     * @param string $via La nuova via del medico
     */
    public function setViaMedico($via)
    {
        $this->_via = $via; 
    }
    
    /**
     * Metodo che permette di modificare il numero civico del medico
     * 
     * @param int $numCiv Il nuovo numero civico del medico
     */
    public function setNumCivicoMedico($numCiv)
    {
        $this->_numeroCivico = $numCiv; 
    }
    
    /**
     * Metodo che permette di modificare il CAP del medico
     * 
     * @param int $cap Il nuovo CAP del medico
     */
    public function setCAPMedico($cap)
    {
        $this->_CAP = $cap; 
    }
    
    /**
     * Metodo che permette di modificare la password del medico
     * 
     * @param string $pw La nuova password del medico
     */
    public function setPasswordMedico($pw)
    {
        $this->_password = $pw; 
    } 
    
    /**
     * Metodo che permette di modificare la PEC  del medico
     * 
     * @param string $PEC La PEC del medico 
     */ 
    public function setPECMedico($PEC)
    {
        $this->_PEC= $PEC;
    }
    
    /**
     * Metodo che permette di modificare il codice di conferma del medico
     * 
     * @param string o int? $cod Il nuovo codice per la conferma del medico
     */
    public function setCodiceConfermaMedico($cod)
    {
        $this->_codiceConferma = $cod; 
    }
    
    /**
     * Metodo che permette di modificare la validità del medico 
     * 
     * @param boolean $validato True se il medico è stato validato, False altrimenti
     */ 
    public function setValidatoMedico($validato)
    {
        $this->_validato = $validato;
    }
    
    /**
     * Metodo che permette di modificare il numero d'iscrizione del medico all'albo
     * 
     * @param string $numIscrizione Il numero d'iscrizione del medico all'albo
     */ 
    public function setnumIscrizioneMedico($numIscrizione)
    {
        $this->_numIscrizione = $numIscrizione;
    }
    
    /**
     * Metodo che permette di modificare la provincia dell'albo a cui è iscritto il medico
     * 
     * @param string $provinciaAlbo La provincia dell'albo a cui è iscritto il medico
     */ 
    public function setProvinciaAlboMedico($provinciaAlbo)
    {
        $this->_provinciaAlbo = $provinciaAlbo;
    }
    
    /**
     * Metodo che permette di impostare la conferma dell'account 
     * 
     * @param boolean $confermato Imposta la conferma dell'account 
     */
    public function setConfermatoMedico($confermato)
    {
        $this->_confermato= $confermato;
    }
    
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EMedico nel DB
     * 
     * @access public
     * @param EMedico $eMedico L'oggetto di tipo EMedico che si vuole memorizzare nel DB
     */
    public function inserisciMedicoDB($eMedico) 
    {
        //crea un oggetto fMedico se non è esistente, si collega al DB e lo inserisce
        $fMedico = USingleton::getInstance('FMedico');
        
        if($fMedico->inserisciMedico($eMedico) === TRUE)
        {
            return $eMedico->getCodiceConfermaMedico();
        }
        else
        {
            return FALSE;
        }
    }
}
