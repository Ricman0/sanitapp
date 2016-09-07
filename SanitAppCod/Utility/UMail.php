<?php

/**
 * Description of UMail
 *
 * @package Utility 
 * @author Claudia Di Marco & Riccardo Mantini
 */

require './libs/PHPMailer/PHPMailerAutoload.php';

class UMail {
    
    /**
     * La mail da inviare
     * 
     * @access private
     * @var type Description
     */
    private $_email;
    
    /**
     * Costruttore della classe UMail
     * 
     * @access public
     */
    public function __construct() 
    {
        //se non esiste già un'istanza di PHPMailer, crea un'istanza di PHPMailer
        // il riferimento per tale istanza è $email
        $email = USingleton::getInstance('PHPMailer');
        $config = USingleton::getInstance('Config');
        $emailConfig = $config->getEmailConfig();
        // si specifica il metodo da usare. 
        // si dice alla classe di voler usare SMTP
        $email->isSMTP(); 
        $email->SMTPSecure = $emailConfig['SMTPSecure'];
        $email->SMTPAuth = $emailConfig['SMTPAuth'];
        $email->port = $emailConfig['port'];
        /*
         * Quando si usa SMTP, si ha la necessità di usare un SMTP server valido, 
         * This may well be the same one that you use in your personal mail client.
         */
        $email->Host = $emailConfig['host'];
        $email->Username = $emailConfig['username'];
        $email->Password = $emailConfig['password'];
        $email->From = $emailConfig['from'];
        $email->FromName= $emailConfig['fromname'];
        $this->_email = $email;
        // $this->_email->setLanguage('it','language/'); oppure
        $this->_email->setLanguage('it', "./libs/PHPMailer/language/phpmailer.lang-it.php");
        
    }
    
    /**
     * Metodo che consente di inviare una email 
     * 
     * @access public
     * @param string $destinatario Indirizzo email del destinatario
     * @param string $subject Oggetto della email
     * @param string $body Corpo della email
     * @param array $allegati Gli allegati della email
     */
    public function inviaEmail($destinatario, $subject, $body, $allegati = NULL) 
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($destinatario);
        // imposto l'oggetto dell'email
        $this->_email->Subject = $subject;
        // imposto il body dell'email; stripslashes rimuove gli eventuali backslash
        $this->_email->Body = stripslashes($body);
        
        if($allegati !="")
        {
            foreach ($allegati as $key => $value) 
            {
                $this->_email->AddAttachment($allegati);
            }
            //qui dovrai ciclare gli allegati se sono più di uno con il solito foreach 
             
        } 
        if (!$this->_email->send())
        {}
        if(!$mail->send()) 
        {
            echo "Il messaggio non è stato spedito poichè c'è stato un errore: " . $this->errore();
        } 
        else 
        {
            echo "Il messaggio è stato inviato correttamente";
        }
        
        
    }
    
    
    /**
     * Metodo che permette l'invio di una mail all'utente contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     * 
     */
    public function inviaMailRegistrazioneUtente()
    {
        //@param string $destinatario Il destinatario a cui inviare la mail riepilogativa con link //l'ho eliminato
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($_POST['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = "Ciao, " . $_POST['nome'] . ", Benvenuto in SanitApp!"
                . " Questa è un'email riepilogativa dei dati che hai inserito."
                . " Nome: " . $_POST['nome'] ."\r\n"
                . " Cognome: ". $_POST['cognome'] ."\r\n"
                . " Codice Fiscale: " . $_POST['codiceFiscale'] ."\r\n"
                . " Indirizzo: " . $_POST['indirizzo'] ."\r\n"
                . " CAP: ". $_POST['CAP'] ."\r\n"
                . " Email: ". $_POST['email'] . "\r\n"
                . " Username: ". $_POST['username'] ."\r\n"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://www.sanitapp/registrazione/conferma/utente/" . $_POST['username'] . "/";    
        
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        if ($inviata ===TRUE)
        {
            echo "";
        }
    }
    
    /**
     * Metodo che permette l'invio di una mail al medico contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     */
    public function inviaMailRegistrazioneMedico()
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($_POST['emailMedico']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = " Benvenuto in SanitApp Dott." . $_POST['cognomeMedico'] . "!"
                . " Questa è un'email riepilogativa dei dati che ha inserito."
                . " Nome: " . $_POST['nomeMedico'] ."\r\n"
                . " Cognome: ". $_POST['cognomeMedico'] ."\r\n"
                . " Codice Fiscale: " . $_POST['codiceFiscaleMedico'] ."\r\n"
                . " Indirizzo: " . $_POST['indirizzoMedico'] ."\r\n"
                . " CAP: ". $_POST['CAPMedico'] ."\r\n"
                . " Email: ". $_POST['emailMedico'] . "\r\n"
                . " Username: ". $_POST['usernameMedico'] ."\r\n"
                . " PEC: ". $_POST['PECMedico'] ."\r\n"
                . " Provincia Albo: ". $_POST['provinciaAlbo'] ."\r\n"
                . " Iscrizione numero: ". $_POST['numeroIscrizione'] ."\r\n"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://www.sanitapp/registrazione/conferma/medico/" . $_POST['usernameMedico'] . "/";    
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        if ($inviata ===TRUE)
        {
            echo "";
        }
    }
    
     /**
     * Metodo che permette l'invio di una mail alla clinica contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     */
    public function inviaMailRegistrazioneClinica()
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($_POST['emailClinica']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = " Benvenuto in SanitApp clinca" . $_POST['nomeClinica'] . "!"
                . " Questa è un'email riepilogativa dei dati che ha inserito."
                . " Nome della clinica: " . $_POST['nomeClinica'] ."\r\n"
                . " Titolare: ". $_POST['titolare'] ."\r\n"
                . " Partita IVA: " . $_POST['partitaIVA'] ."\r\n"
                . " Indirizzo: " . $_POST['indirizzoClinica'] ."\r\n"
                . " CAP: " . $_POST['CAPClinica'] ."\r\n"
                . " Località: " . $_POST['localitàClinica'] . "\r\n"
                . " Provincia: " . $_POST['provinciaClinica'] . "\r\n"
                . " Email: ". $_POST['emailClinica'] . "\r\n"
                . " Username: ". $_POST['usernameClinica'] ."\r\n"
                . " PEC: ". $_POST['PECClinica'] ."\r\n"
                . " Telefono: ". $_POST['telefonoClinica'] ."\r\n"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://www.sanitapp/registrazione/conferma/clinica/" . $_POST['usernameClinica'] . "/";    
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        if ($inviata ===TRUE)
        {
            echo "";
        }
    }
    /**
     * Metodo che restituisce l'errore che si è avuto durante l'invio dell'email 
     * 
     * @access public
     */
    public function errore() 
    {
        //per avere il messaggio di errore in Italiano
        $this->_email->setLanguage('it', "./libs/PHPMailer/language/phpmailer.lang-it.php");
        return $this->_email->ErrorInfo;
    }
}
    
    
//    $mittente = "server@vostrodominio.it";
//    $nomemittente = "Richiesta Informazioni";
//    $destinatario = "info@vostrodominio.it";
//    $ServerSMTP = "smtp.vostrodominio.it"  //server SMTP 
//    $corpo_messaggio = "Grazie per averci contattato!!\n"
//            ."Cordiali Saluti,\nServizio Clienti";
//
//    $messaggio = new PHPMailer;
//    // utilizza la classe SMTP invece del comando mail() di php
//    $messaggio->IsSMTP(); 
//    $messaggio->SMTPKeepAlive = "true";
//    $messaggio->Host  = $ServerSMTP;
//    $messaggio->From   = $mittente;
//    $messaggio->FromName = $nomemittente;
//    $messaggio->AddAddress($destinatario); 
//    $messaggio->Body = $corpo_messaggio;
//    if(!$messaggio->Send()) {
//            echo "errore nella spedizione: ".$messaggio->ErrorInfo;
//    } else {
//            echo "messaggio inviato correttamente";
//    }
