<?php

/**
 * La classe VGestisciUser si occupa di recuperare i dati e visualizzare i template relativi alla gestione degli user e delle categorie.
 *
 * @package View
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VGestisciUser extends View{
    
    
    
    /**
     * Metodo che permette di visualizzare tutti gli user dell'applicazione fatta eccezione per gli amministratori.
     * 
     * @access public
     * @param array $risultato Un array di user (non amministratori)
     */
    public function visualizzaUserNonAmministratori($risultato) 
    {
        if(count($risultato)>0)
        {
            $this->assegnaVariabiliTemplate('bloccati', FALSE);
            $this->assegnaVariabiliTemplate('daValidare', FALSE);
            $this->assegnaVariabiliTemplate('dati', $risultato);
            $this->visualizzaTemplate('tabellaUser');
        }
        else
        {
            $this->visualizzaFeedback('Non esistono user che non siano amministratori'); 
        }
        
    }
    
    /**
     * Metodo che consente di visualizzare una tabella di tutti gli user bloccati dell'applicazione.
     * 
     * @access public
     * @param array $usersBloccati Gli users bloccati
     */
    public function visualizzaUserBloccati($usersBloccati) {
        if(count($usersBloccati)>0)
        {
            $this->assegnaVariabiliTemplate('bloccati', TRUE);
            $this->assegnaVariabiliTemplate('daValidare', FALSE);
            $this->assegnaVariabiliTemplate('dati', $usersBloccati);
            $this->visualizzaTemplate('tabellaUser');
        }
        else
        {
            $this->visualizzaFeedback('Non esistono user bloccati'); 
        }
        
    }
    
    /**
     * Metodo che consente di visualizzare una tabella di tutti gli user dell'applicazione che l'amministratore deve validare.
     * 
     * @access public
     * @param array $usersDaValidare Gli users da validare
     */
    public function visualizzaUserDaValidare($usersDaValidare){
        if(count($usersDaValidare)>0)
        {
            $this->assegnaVariabiliTemplate('bloccati', FALSE);
            $this->assegnaVariabiliTemplate('daValidare', TRUE);
            $this->assegnaVariabiliTemplate('dati', $usersDaValidare);
            $this->visualizzaTemplate('tabellaUser');
        }
        else
        {
            $this->visualizzaFeedback('Non esistono user da validare'); 
        }
    }
    
    /**
     * Metodo che visualizza tutte le informazione di uno user passato come parametro.
     * 
     * @access public
     * @param array $user Lo user di cui si vogliono visualizzare tutte le informazioni
     */
    public function visualizzaInfoUser($user){
        if ($user['Bloccato']==0)
        {
            $user['Bloccato']= 'NO';
        }
        else
        {
            $user['Bloccato']= 'SI';
        }
        if ($user['Confermato']==0)
        {
            $user['Confermato']= 'NO';
        }
        else
        {
            $user['Confermato']= 'SI';
        }
        if($user['TipoUser']!=='utente')
        {
            if ($user['Validato']==0)
            {
                $user['Validato']= 'NO';
            }
            else
            {
                $user['Validato']= 'SI';
            }
        }
        
        $this->assegnaVariabiliTemplate('user', $user);
        $this->assegnaVariabiliTemplate('tastoBloccato', TRUE);
        $this->assegnaVariabiliTemplate('tastoValidato', TRUE);
        $this->assegnaVariabiliTemplate('tastoConfermato', TRUE);
        $this->assegnaVariabiliTemplate('tastoElimina', TRUE);
        $this->assegnaVariabiliTemplate('tastoModifica', TRUE);
        $this->assegnaVariabiliTemplate('tipoUser', $user['TipoUser']);
        
        $this->visualizzaTemplate('infoUser');
    }
    
    /**
     * Metodo che visualizza tutte le informazione di uno user bloccato passato come parametro.
     * 
     * @access public
     * @param array $user Lo user bloccato di cui si vogliono visualizzare tutte le informazioni
     */
    public function visualizzaInfoUserBloccato($user) {
        if ($user['Bloccato']==0)
        {
            $user['Bloccato']= 'NO';
        }
        else
        {
            $user['Bloccato']= 'SI';
        }
        if ($user['Confermato']==0)
        {
            $user['Confermato']= 'NO';
        }
        else
        {
            $user['Confermato']= 'SI';
        }
        if($user['TipoUser']!=='utente')
        {
            if ($user['Validato']==0)
            {
                $user['Validato']= 'NO';
            }
            else
            {
                $user['Validato']= 'SI';
            }
        }
        $this->assegnaVariabiliTemplate('user', $user);
        $this->assegnaVariabiliTemplate('tastoBloccato', TRUE);
        $this->assegnaVariabiliTemplate('tastoValidato', FALSE);
        $this->assegnaVariabiliTemplate('tastoConfermato', FALSE);
        $this->assegnaVariabiliTemplate('tastoElimina', FALSE);
        $this->assegnaVariabiliTemplate('tastoModifica', FALSE);
        $this->assegnaVariabiliTemplate('tipoUser', $user['TipoUser']);
        $this->visualizzaTemplate('infoUser');
    }
    
    /**
     * Metodo che visualizza tutte le informazione di uno user da validare passato come parametro.
     * 
     * @access public
     * @param array $user Lo user da validare di cui si vogliono visualizzare tutte le informazioni
     */
    public function visualizzaInfoUserDaValidare($user) {
        if ($user['Bloccato']==0)
        {
            $user['Bloccato']= 'NO';
        }
        else
        {
            $user['Bloccato']= 'SI';
        }
        if ($user['Confermato']==0)
        {
            $user['Confermato']= 'NO';
        }
        else
        {
            $user['Confermato']= 'SI';
        }
        if($user['TipoUser']!=='utente')
        {
            if ($user['Validato']==0)
            {
                $user['Validato']= 'NO';
            }
            else
            {
                $user['Validato']= 'SI';
            }
        }
        $this->assegnaVariabiliTemplate('user', $user);
        $this->assegnaVariabiliTemplate('tastoBloccato', FALSE);
        $this->assegnaVariabiliTemplate('tastoValidato', TRUE);
        $this->assegnaVariabiliTemplate('tastoConfermato', FALSE);
        $this->assegnaVariabiliTemplate('tastoElimina', FALSE);
        $this->assegnaVariabiliTemplate('tastoModifica', FALSE);
        $this->assegnaVariabiliTemplate('tipoUser', $user['TipoUser']);
        $this->visualizzaTemplate('infoUser');
    }
    
   
}
