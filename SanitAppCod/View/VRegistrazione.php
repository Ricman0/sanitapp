

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

    
    
    public function restituisciFormUtente() 
    {
        return $this->visualizzaTemplate('inserisciUtente');  
    }

    public function restituisciFormClinica() 
    {
        return $this->prelevaTemplate('inserisciClinica');
    }
    
    public function restituisciFormMedico() 
    {
        return $this->prelevaTemplate('inserisciMedico');
    }
}
