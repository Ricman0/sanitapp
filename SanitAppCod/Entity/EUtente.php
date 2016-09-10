<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EUtente
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class EUtente 
{
    /**
     * @var string $_nome, variabile di tipo string,  che contiente il nome dell'utente
     */
    private $_nome; 
    
    /**
     * @var string $_cognome, variabile di tipo string,  che contiente il cognome dell'utente
     */
    private $_cognome; 
    
    /**
     * @var string $_codFiscale, variabile di tipo string,  che contiente il 
     *             codice fiscale dell'utente
     */
    private $_codFiscale;
    
    /**
     * @var string $_via, variabile di tipo string, che contiente l'indirizzo 
     *             in cui risiede l'utente
     */
    private $_via; 
    
    /**
     * @var int $_numeroCivico, variabile di tipo intero, che contiente il numero
     *          civico in cui risiede l'utente
     */
    private $_numeroCivico; 
    
    /**
     * @var int $_CAP, variabile di tipo intero, che contiente il CAP in cui 
     *          risiede l'utente
     */
    private $_CAP; 
    
    /**
     * @var string $_email, variabile di tipo string, che contiente l'indirizzo 
     *             di posta elettronica dell'utente. é valido come username per 
     *             l'accesso al sistema
     */
    private $_email; 
    
    /**
     * @var string $_password, variabile di tipo string, che contiente la
     *             password che l'utente inserisce per accedere al sistema
     */
    private $_password;
    
    /**
     * @var string $_username, variabile di tipo string, che contiene lo
     *              username che l'utente inserisce per registrarsi
     */
    private $_username;
    
    /**
     * @var string $_confermato permette di capire se l'account dell'utente è 
     * stato confermato(TRUE) o meno         
     */
    private $_confermato;
    
    /**
     * @var Array(EPrenotazione) $_prenotazioni array che contiente le 
     *                           prenotazioni a nome dell'utente
     */
    private $_prenotazioni; 
    
    /**
     * Costruttore della classe EUtente
     * 
     * @param string $nome Il nome dell'utente
     * @param string $cognome Il cognome dell'utente
     * @param string $cf Il codice fiscale dell'utente
     * @param string $via La via in cui risiede l'utente
     * @param int $numeroCivico Ilnumero civico dell'utente
     * @param string $cap Il cap del paese in cui risiede l'utente
     * @param string $email L'email dell'utente
     * @param string $password La password dell'utente
     */
    public function __construct($nome, $cognome, $cf, $via, $numeroCivico, $cap, $email, $username, $password) 
    {
        $this->_nome = $nome;
        $this->_cognome = $cognome; 
        $this->_codFiscale = $cf;
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
        $this->_email = $email; 
        $this->_username = $username;
        $this->_password = $password; 
        $this->_confermato = FALSE;
        $this->_prenotazioni = new ArrayObject() ;// da vedere:array di oggetti o bastava semplicemente Array()??
    }
    
    //metodi get
    /**
     * Metodo per conoscere il nome dell'utente
     * 
     * @return string Il nome dell'utente
     */ 
    public function getNomeUtente()
    {
        return $this->_nome;
    }
    
    /**
     * Metodo per conoscere il cognome dell'utente
     * 
     * @return string Il cognome dell'utente
     */
    public function getCognomeUtente()
    {
        return $this->_cognome;
    }
    
    /**
     * Metodo per conoscere il codice fiscale dell'utente
     * 
     * @return string Il codice fiscale dell'utente
     */
    public function getCodiceFiscaleUtente()
    {
        return $this->_codFiscale;
    }
    
    /**
     * Metodo per conoscere la via in cui risiede l'utente
     * 
     * @return string Il nome della via in cui risiede l'utente
     */
    public function getViaUtente()
    {
        return $this->_via;
    }
    
    /**
     * Metodo per conoscere il numero civico della via in cui risiede l'utente
     * 
     * @return int Il numero civico della via in cui risiede l'utente
     */
    public function getNumCivicoUtente()
    {
        return $this->_numeroCivico;
    }
    
    /**
     * Metodo per conoscere il cap del paese in cui risiede l'utente
     * 
     * @return int Il cap del paese in cui risiede l'utente
     */
    public function getCAPUtente()
    {
        return $this->_CAP;
    }
    
    /**
     * Metodo per conoscere l'email dell'utente
     * 
     * @return string L'email dell'utente
     */ 
    public function getEmailUtente()
    {
        return $this->_email;
    }
    
    /**
     * Metodo per conoscere lo username dell'utente
     * 
     * @return string lo username dell'utente
     */ 
    public function getUsernameUtente()
    {
        return $this->_username;
    }
    
    /**
     * Metodo per conoscere la password dell'utente
     * 
     * @return string La password dell'utente
     */ 
    public function getPasswordUtente()
    {
        return $this->_password;
    }
    
    /**
     * Metodo per conoscere le prenotazioni dell'utente
     * 
     * @return Array(EPrenotazione) Le prenotazioni dell'utente
     */ 
    public function getPrenotazioniUtente()
    {
        return $this->_prenotazioni;
    }
    
    /**
     * Metodo che permette di capire se l'account è stato confermato o meno
     * 
     * @return boolean TRUE se l'account è stato confermato, FALSE altrimenti
     */
    public function getConfermatoUtente()
    {
        return $this->_confermato;
    }
    
    //metodi set
    
    /**
     * Metodo che permette di modificare il nome dell'utente
     * 
     * @param string $nome Il nome dell'utente
     */ 
    public function setNomeUtente($nome)
    {
        $this->_nome = $nome;
    }
    
    /**
     * Metodo che permette di modificare il cognome dell'utente
     * 
     * @param string $cognome Il cognome dell'utente
     */
    public function setCognomeUtente($cognome)
    {
        $this->_cognome = $cognome;
    }
    
    /**
     * Metodo che permette di modificare il codice fiscale dell'utente
     * 
     * @param string $codFiscale Il codice fiscale dell'utente
     */
    public function setCodiceFiscaleUtente($codFiscale)
    {
        $this->_codFiscale = $codFiscale;
    }
    
    /**
     * Metodo che permette di modificare l'email dell'utente
     * 
     * @param string $email L'email dell'utente
     */ 
    public function setEmailUtente($email)
    {
        return $this->_email = $email;
    }    
     
    /**
     * Metodo che permette di modificare la via dell'utente
     * 
     * @param string $via La nuova via dell'utente
     */
    public function setViaUtente($via)
    {
        $this->_via = $via; 
    }
    
    /**
     * Metodo che permette di modificare il numero civico dell'utente
     * 
     * @param int $numCiv Il nuovo numero civico dell'utente
     */
    public function setNumCivicoUtente($numCiv)
    {
        $this->_numeroCivico = $numCiv; 
    }
    
    /**
     * Metodo che permette di modificare il CAP dell'utente
     * 
     * @param int $cap Il nuovo CAP dell'utente
     */
    public function setCAPUtente($cap)
    {
        $this->_CAP = $cap; 
    }
    
    /**
     * Metodo che permette di modificare lo username dell'utente
     * 
     * @param string $un Il nuovo username dell'utente
     */
    public function setUsernameUtente($un)
    {
        $this->_username = $un; 
    }
    
    /**
     * Metodo che permette di modificare la password dell'utente
     * 
     * @param string $pw La nuova password dell'utente
     */
    public function setPasswordUtente($pw)
    {
        $this->_password = $pw; 
    }
    
    /**
     * Metodo che permette di impostare la conferma dell'account 
     * 
     * @param boolean $confermato Imposta la conferma dell'account 
     */
    public function setConfermatoUtente($confermato)
    {
        $this->_confermato= $confermato;
    }
    
    /**
     * Metodo che permette di aggiungere una prenotazione nell'array di 
     * prenotazioni dell'utente
     * 
     * @param Entity.EPrenotazione $prenotazione Una nuova prenotazione effettuata a 
     *                      nome dell'utente.
     */
    public function aggiungiPrenotazioneUtente($prenotazione)
    {
        $this->_prenotazioni->append($prenotazione); // non so se sia giusto o se debba usare offsetSet() 
    }  
    
    
    /**
     * Metodo che permette di inserire un oggetto di tipo EUtente nel DB
     * 
     * @access public
     * @param EUtente $eUtente L'oggetto di tipo EUtente che si vuole memorizzare nel DB
     * @return Boolean TRUE se l'utente è stato inserito correttamente nel DB, FALSE altrimenti.
     */
    public function inserisciUtenteDB($eUtente) 
    {
        //crea un oggetto fUtente se non è esistente, si collega al DB e lo inserisce
        $fUtente = USingleton::getInstance('FUtente');
        return $fUtente->inserisciUtente($eUtente);
    }
    
    
   
    
}
