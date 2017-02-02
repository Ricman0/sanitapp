<?php

/**
 * La classe UMail si occupa della gestione delle mail.
 *
 * @package Utility 
 * @author Claudia Di Marco & Riccardo Mantini
 */

// in __DIR__ è contenuta il percorso della cartella che contiene il file ma Autoloder.php non si trova in include ma in libs 
// per questo bisogna eliminare include dal path
$dir = explode(DIRECTORY_SEPARATOR, __DIR__); // tutte le parole che conpongono il path vengono memorizzate in un elemento dell'array $dir
array_pop($dir);// elimino l'ultimo elemento (ovvero la parola include)
$dir = implode(DIRECTORY_SEPARATOR, $dir);// riassemblo il path
require $dir . '/libs/PHPMailer/PHPMailerAutoload.php';

class UMail {
    
    /**
     * @access private
     * @var  string La mail da inviare
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
        $emailConfig = $config->getEmailUserConfig();
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
        $this->_email->CharSet = "UTF-8"; // in questo modo anche i caratteri accentati si leggono bene
        $email->IsHTML(true);//di default, il content-type è text/plain. Dato che voglio inserire dell'html per non far vedere il link cambio il content-type in text/html   
    }
    
    /**
     * Metodo che consente di inviare una email. 
     * 
     * @access public
     * @param string $destinatario Indirizzo email del destinatario
     * @param string $subject Oggetto della email
     * @param string $body Corpo della email
     * @param array $allegati Gli allegati della email
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
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
        return $this->_email->send();
        
        
        
    }
    
    
    /**
     * Metodo che permette l'invio di una mail all'utente contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     * @param string $codiceConferma Il codice per confermare l'account
     * @param array $dati I dati relativi all'utente (email, username, nome, cognome, codiceFiscale, indirizzo, CAP)
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRegistrazioneUtente($codiceConferma, $dati)        //controllato
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Conferma Account SanitApp";// = $subject;
        $url = "http://sanitapp.altervista.org/registrazione/conferma/" . $dati['username'] . "/". $codiceConferma;
        $url = "<html><a href=" . $url . "'>Conferma</a></html>";
        
        $testo = "<h4>Ciao " . $dati['nome'] . ", Benvenuto in SanitApp!</h4>"
                . " Questa è un'email riepilogativa dei dati che hai inserito: <br><br>"
                . " <strong>NOME  : </strong><span>  " . $dati['nome'] . "</span><br><br>"
                . " <strong>COGNOME  :  </strong><span>" . $dati['cognome'] . "</span><br><br>"
                . " <strong>CODICE FISCALE  :  </strong><span>" . $dati['codiceFiscale'] . "</span><br><br>"
                . " <strong>INDIRIZZO  :  </strong><span>" . $dati['indirizzo'] . "</span><br><br>"
                . " <strong>CAP  :  </strong><span>" . $dati['CAP'] . "</span><br><br>"
                . " <strong>EMAIL  :  </strong><span>" . $dati['email'] . "</span><br><br>"
                . " <strong>USERNAME  :  </strong><span>" . $dati['username'] . "</span><br><br>"
                . " Per completare la registrazione, clicca sul link seguente: <br>"
                . $url . "<br>"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . " nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso <br><br>"
                . " Nel caso in cui non ti sei registrato su SanitApp, ignora questa mail. <br><br>"   
                . "Saluti,<br>"
                . "SANITAPP";
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
    
    /**
     * Metodo che consente di inviare una mail per informare l'utente che la prenotazione è stata cancellata.
     * 
     * @access public
     * @param array $datiPerMail I dati della prenotazione e dell'utente per poter inviare la mail
     * @return boolean TRUE se l'email è stata inviata, altrimenti lancia un'eccezione
     * @throws XMailException Se l'email non è inviata
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
            return $inviata;
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
     * @param string $codiceConferma Il codice per confermare l'account
     * @param array $dati I dati relativi al medico (email, PEC, username, nome, cognome, codiceFiscale, via, CAP, provinciaAlbo, numeroIscrizione)
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRegistrazioneMedico($codiceConferma, $dati)        //controllato
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $url = "http://sanitapp.altervista.org/registrazione/conferma/" . $dati['username'] . "/". $codiceConferma;
        $url = "<html><a href=" . $url . "'>Conferma</a></html>";
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $testo = "<h4>Benvenuto in SanitApp Dott." . $dati['cognome'] . "!</h4>"
                . " Questa è un'email riepilogativa dei dati che ha inserito. <br><br>"
                . " <strong>NOME  :  </strong><span>" . $dati['nome'] . "</span><br><br>"
                . " <strong>COGNOME  :  </strong><span>" . $dati['cognome'] . "</span><br><br>"
                . " <strong>CODICE FISCALE  :  </strong><span>" . $dati['codiceFiscale'] . "</span><br><br>"
                . " <strong>INDIRIZZO  :  </strong><span>" . $dati['via'] . ", " . $dati['numeroCivico'] . "</span><br><br>"
                . " <strong>CAP  :  </strong><span>" . $dati['CAP'] . "</span><br><br>"
                . " <strong>EMAIL  :  </strong><span>" . $dati['email'] . "</span><br><br>"
                . " <strong>USERNAME  :  </strong><span>" . $dati['username'] . "</span><br><br>"
                . " <strong>PEC  :  </strong><span>" . $dati['PEC'] . "</span><br><br>"
                . " <strong>PROVINCIA ALBO  :  </strong><span>" . $dati['provinciaAlbo'] . "</span><br><br>"
                . " <strong>NUMERO ISCRIZIONE ALBO  :  </strong><span>" .  $dati['numeroIscrizione'] . "</span><br><br>"
                . " Per completare la registrazione, clicca sul link seguente: <br>"
                . $url . "<br>"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . " nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso <br><br>"
                . " Nel caso in cui non ti sei registrato su SanitApp, ignora questa mail. <br><br>"
                . "Saluti,<br>"
                . "SANITAPP";   
         
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
    
     /**
     * Metodo che permette l'invio di una mail alla clinica contenente
     * i dati inseriti nella form e un link per validare l'account.
     * 
     * @access public
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRegistrazioneClinica($codiceConferma, $dati)
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "Account SanitApp";// = $subject;
        $url = "http://sanitapp.altervista.org/registrazione/conferma/" . $dati['username'] . "/". $codiceConferma;
        $url = "<html><a href=" . $url . "'>Conferma</a></html>";
        $testo = " <h4>Benvenuto in SanitApp clinica " . $dati['nomeClinica'] . "!</h4>"
                . " Questa è un'email riepilogativa dei dati che ha inserito. <br><br>"
                . " <strong>NOME DELLA CLINICA  :  </strong><span>" . $dati['nomeClinica'] . "</span><br><br>"
                . " <strong>TITOLARE  :  </strong><span>" . $dati['titolare'] . "</span><br><br>"
                . " <strong>PARTITA IVA  :  </strong><span>" . $dati['partitaIVA'] . "</span><br><br>"
                . " <strong>INDIRIZZO  :  </strong><span>" .  $dati['via'] . ", " . $dati['numeroCivico'] .  "</span><br><br>"
                . " <strong>CAP  :  </strong><span>" . $dati['cap'] . "</span><br><br>"
                . " <strong>LOCALITÁ  :  </strong><span>" . $dati['localitàClinica'] . "</span><br><br>"
                . " <strong>PROVINCIA  :  </strong><span>" . $dati['provinciaClinica'] . "</span><br><br>"
                . " <strong>EMAIL  :  </strong><span>" . $dati['email'] . "</span><br><br>"
                . " <strong>USERNAME  :  </strong><span>" . $dati['username'] . "</span><br><br>"
                . " <strong>PEC  :  </strong><span>" . $dati['PEC'] . "</span><br><br>"
                . " <strong>TELEFONO  :  </strong><span>" .  $dati['telefono'] . "</span><br><br>"
                
//                . " <h5>Nome della clinica:</h5> " . $dati['nomeClinica'] ."\n"
//                . " <h5>Titolare:</h5> ". $dati['titolare'] ."\n"
//                . " <h5>Partita IVA:</h5> " . $dati['partitaIVA'] ."\n"
//                . " <h5>Indirizzo:</h5> " . $dati['via'] ."\n"
//                . " <h5>CAP:</h5> " . $dati['cap'] ."\n"
//                . " <h5>Località:</h5> " . $dati['localitàClinica'] . "\n"
//                . " <h5>Provincia:</h5> " . $dati['provinciaClinica'] . "\n"
//                . " <h5>Email:</h5> ". $dati['email'] . "\n"
//                . " <h5>Username:</h5> ". $dati['username'] ."\n"
//                . " <h5>PEC:</h5> ". $dati['PEC'] ."\n"
//                . " <h5>Telefono:</h5> ". $dati['telefono'] ."<br><br>"
                //devo inserire anche il link per la conferma
                . " Per completare la registrazione, clicca sul link seguente: <br>"
                . $url . "<br>"
                . "oppure copia e incolla il seguente codice ". $codiceConferma . " nella pagina di conferma "
                . "subito dopo aver effettuato il primo accesso <br><br>"
                . " Nel caso in cui non ti sei registrato su SanitApp, ignora questa mail. <br><br>"
                . "Saluti,<br>"
                . "SANITAPP";   
        
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
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
    
    /**
     * Metodo che consente di inviare una mail di memo per la prenotazione ad un utente
     * 
     * @access public
     * @param array $infoPrenotazione Contiene tutte le informazioni per inviare la mail di memo prenotazione(emailUtente,nomeUtente,cognomeUtente, nomeEsame, nomeClinica, indirizzoClinica, data e ora prenotazione)
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailMemoPrenotazione($infoPrenotazione) 
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($infoPrenotazione['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = 'Memo Prenotazione ';// = $subject;
        $testo = 'Gentile ' . $infoPrenotazione['nomeUtente'] . ' ' . $infoPrenotazione['cognomeUtente'] . ",<br>"
                . 'le ricordiamo che  <h4>il giorno ' . $infoPrenotazione['data'] . ' alle ore ' 
                . $infoPrenotazione['ora'] . "</h4> ha prenotato <h4>l'esame " . $infoPrenotazione['nomeEsame'] 
                . '</h4> presso <h4>la clinica ' . $infoPrenotazione['nomeClinica'] . '</h4> indirizzo: ' 
                . $infoPrenotazione['indirizzoClinica'] . '.<br><br>'
                . 'Inoltre, le ricordiamo che può disdire la prenotazione fino alla mezzanotte di oggi.<br>'
                . "Qualora non si presenti all'appuntamento, la clinica segnerà la prenotazione come non eseguita.<br>"
                . "Dopo 3 prenotazioni non eseguite, il sistema bloccherà l'account.<br><br> "
                . "Saluti,<br>"
                . "SANITAPP";
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
    
    /**
     * Metodo che consente di inviare una mail come notifica di inserimento di un referto.
     * 
     * @access public
     * @param array $datiNotifica Contiene tutte le informazioni per inviare la mail di motifica referto(emailUtente,nomeUtente,cognomeUtente, nomeEsame, nomeClinica, indirizzoClinica, data e ora della prenotazione)
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaNotificaReferto($datiNotifica)
    {
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($datiNotifica['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = 'Notifica referto ';// = $subject;
        $testo = 'Gentile ' . $datiNotifica['nomeUtente'] . ' ' . $datiNotifica['cognomeUtente'] . ",<br>"
                . "la informiamo che è stato inserito un suo referto per l'esame " . $datiNotifica['nomeEsame'] . " eseguito il giorno " . $datiNotifica['data'] . ' alle ore ' 
                . $datiNotifica['ora'] . ".<br><br>"
                . "Saluti,<br>SanitApp";
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
    
    /**
     * Metodo che permette l'invio di una mail all'utente contenente
     * la nuova password.
     * 
     * @access public
     * @param array $dati I dati necessari: email, password, username
     * @return boolean TRUE email inviata correttamente, FALSE altrimenti
     */
    public function inviaMailRecuperaPassword($dati)
    {
        //@param string $destinatario Il destinatario a cui inviare la mail riepilogativa con link //l'ho eliminato
        //aggiunge l'indirizzo email a cui inviare l'email ("to:")
        $this->_email->addAddress($dati['email']);
        // imposto l'oggetto dell'email
        $this->_email->Subject = "REcupero Password Account SanitApp";
        
        $testo = "<h4>Ciao " . $dati['username'] . "!</h4>"
                . " Questa è un'email di recupero password.<br>"
                
                . " La tua nuova password è: <br><br>"
                . $dati['password']. "<br><br>"
                . "Utilizzala per accedere alla tua area personale, "
                . "subito dopo aver effettuato il primo accesso sostituiscila con una password da te creata.<br><br>"
                . "Saluti,<br>"
                . "SANITAPP";
        $this->_email->Body = $testo;
        $inviata = $this->_email->send();
        return $inviata;
    }
}
    

