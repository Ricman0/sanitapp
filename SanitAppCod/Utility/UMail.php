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
     * @param string $inserito Il codice per confermare l'account
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRegistrazioneUtente($codiceConferma, $dati)
    {
        //@param string $destinatario Il destinatario a cui inviare la mail riepilogativa con link //l'ho eliminato
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Conferma Account SanitApp";// = $subject;
        $testo = "Ciao, " . $dati['nome'] . ", Benvenuto in SanitApp!"
                . " Questa è un'email riepilogativa dei dati che hai inserito."
                . " Nome: " . $dati['nome'] ."\r\n"
                . " Cognome: ". $dati['cognome'] ."\r\n"
                . " Codice Fiscale: " . $dati['codiceFiscale'] ."\r\n"
                . " Indirizzo: " . $dati['indirizzo'] ."\r\n"
                . " CAP: ". $dati['CAP'] ."\r\n"
                . " Email: ". $dati['email'] . "\r\n"
                . " Username: ". $dati['username'] ."\r\n"
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://sanitapp.altervista.org/registrazione/conferma/" . $codiceConferma . "\n"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . "nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso ";   
        
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        if ($inviata ===TRUE)
        {
            echo "email inviata";
        }
        else
        {
            echo "email non inviata";
        }
        return $inviata;
    }
    
    /**
     * 
     * @access public
     * @param type $datiPerMail
     * @return type
     * @throws XMailException Se l'email non  è inviata
     */    
    public function inviaEmailPrenotazioneCancellata($datiPerMail){
        $this->_email->addAddress($datiPerMail['emailDestinatario']);
        $this->_email->Subject = "Prenotazione Cancellata";
        $body = "Gentile " . ucfirst($datiPerMail['nome']) . " " . ucfirst($datiPerMail['cognome']) . ", "
                . "la informiamo che la prenotazione per l'esame " . $datiPerMail['nomeEsame'] 
                . " per il " . $datiPerMail['dataEOra'] . " presso la clinica " . $datiPerMail['nomeClinica'] . " è stata cancellata"; 
        $this->_email->Body = $body;
        $inviata = $this->_email->send();
        if ($inviata === TRUE)
        {
            echo "inviata"; return $inviata;
        }
        else
        {
            throw new XMailException('email non inviata');
        }
               
    }
    
            
    /**
     * Metodo che permette l'invio di una mail al medico contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     * @param string $inserito Il codice per confermare l'account
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRegistrazioneMedico($codiceConferma, $dati)
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($_POST['emailMedico']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = " Benvenuto in SanitApp Dott." . $dati['cognome'] . "!"
                . " Questa è un'email riepilogativa dei dati che ha inserito."
                . " Nome: " . $dati['nome'] ."\r\n"
                . " Cognome: ". $dati['cognome'] ."\r\n"
                . " Codice Fiscale: " . $dati['codiceFiscale'] ."\r\n"
                . " Indirizzo: " . $dati['via'] ."\r\n"
                . " CAP: ". $dati['CAP'] ."\r\n"
                . " Email: ". $dati['email'] . "\r\n"
                . " Username: ". $dati['username'] ."\r\n"
                . " PEC: ". $dati['PEC'] ."\r\n"
                . " Provincia Albo: ". $dati['provinciaAlbo'] ."\r\n"
                . " Iscrizione numero: ". $dati['numeroIscrizione'] ."\r\n"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://www.sanitapp/registrazione/conferma/" . $codiceConferma . "\n"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . "nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso ";  
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
    
     /**
     * Metodo che permette l'invio di una mail alla clinica contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     */
    public function inviaMailRegistrazioneClinica($codiceConferma, $dati)
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = " Benvenuto in SanitApp clinica " . $dati['nomeClinica'] . "!"
                . " Questa è un'email riepilogativa dei dati che ha inserito."
                . " Nome della clinica: " . $dati['nomeClinica'] ."\r\n"
                . " Titolare: ". $dati['titolare'] ."\r\n"
                . " Partita IVA: " . $dati['partitaIVA'] ."\r\n"
                . " Indirizzo: " . $dati['via'] ."\r\n"
                . " CAP: " . $dati['cap'] ."\r\n"
                . " Località: " . $dati['localitàClinica'] . "\r\n"
                . " Provincia: " . $dati['provinciaClinica'] . "\r\n"
                . " Email: ". $dati['email'] . "\r\n"
                . " Username: ". $dati['username'] ."\r\n"
                . " PEC: ". $dati['PEC'] ."\r\n"
                . " Telefono: ". $dati['telefono'] ."\r\n"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: \n"
                . "http://www.sanitapp/registrazione/conferma/" . $codiceConferma . "\n"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . "nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso ";
        
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
