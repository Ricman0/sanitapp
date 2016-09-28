

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VRegistrazione
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class VRegistrazione extends View {

    
    
    public function restituisciFormUtente($datiValidi=NULL) 
    {
        if($datiValidi=== NULL)
        {
            return $this->visualizzaTemplate('inserisciUtente');  
        }
        else
        {
            $this->prelevaTemplate('inserisciUtente');
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            return $this->visualizzaTemplate('inserisciUtente');
        }
      
    }

    public function restituisciFormClinica($datiValidi=NULL) 
    {
        if($datiValidi=== NULL)
        {
            return $this->visualizzaTemplate('inserisciClinica');  
        }
        else
        {
            $this->prelevaTemplate('inserisciClinica');
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            return $this->visualizzaTemplate('inserisciClinica', $datiValidi);
        }
    }
    
    public function restituisciFormMedico($datiValidi=NULL) 
    {
        if($datiValidi=== NULL)
        {
            return $this->visualizzaTemplate('inserisciMedico');  
        }
        else
        {
            $this->prelevaTemplate('inserisciMedico');
            $this->assegnaVariabiliTemplate('datiValidi', $datiValidi);
            return $this->visualizzaTemplate('inserisciMedico', $datiValidi);
        }
    }
    
    public function confermaInserimento()
    {
        //perchè devo inserire il return???
        
        $this->visualizzaTemplate('mailInviata');
    }
}
