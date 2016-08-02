<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
        
    }
    
    /**
     * Metodo che consente di inviare una email 
     * 
     * @access public
     * @param string $destinatario Indirizzo email del destinatario
     * @param string $subject Oggetto della email
     * @param string $body Corpo della email
     */
    public function inviaEmail($destinatario, $subject, $body) 
    {
        
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
