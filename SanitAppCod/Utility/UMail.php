<?php

/**
 * Description of UMail
 *
 * @package Utility 
 * @author Claudia Di Marco & Riccardo Mantini
 */

require './libs/PHPMailer/class.phpmailer.php';
class UMail {
    
    /**
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
        $email = USingleton::getInstace('PHPMailer');
        $config = USingleton::getInstace('Config');
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
        
        if($allegare !="")
        {
            //qui dovrai ciclare gli allegati se sono più di uno con il solito foreach 
            $this->_email->AddAttachment($allegare); 
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
