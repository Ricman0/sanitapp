<?php

/**
 * Description of CRicercaEsami
 *
 * @author Claudia Di Marco & Riccardo Mantini
 */
class CRicercaEsami {
    
    public function impostaPaginaRisultatoEsami() 
    {
        $fEsami = USingleton::getInstance('FEsame');
        $risultato = $fEsami->cercaEsame($_GET['parametro1'], $_GET['parametro2'], $_GET['parametro3']);
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $vEsami->restituisciPaginaRisultatoEsami($risultato);
        
        
//        return $risultato;
    }
    
    public function gestisciEsami() {
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $task = $vEsami->getTask();
        switch($task)
        { 
            case 'visualizza':
                $id = $vEsami->getId();
                if(isset($id))
                {
                    
                    $eEsame = new EEsame($id);
                    $vEsami->visualizzaInfoEsameOspite($eEsame, "FALSE");
                }
            break;
            default :
                $this->impostaPaginaRisultatoEsami();
                break;
        }
    }
    
    public function impostaPaginaRicercaEsami(){
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $vEsami->restituisciFormRicercaEsami();
        
        
    }
    
//    public function impostaPaginaRisultatoEsami(){
//        
//        $vEsami = USingleton::getInstance('VRicercaEsami');
//        $vEsami->restituisciPaginaRisultatoEsami();
//        
//    }
    
    public function ritornaEsami() {
        
        $vEsami = USingleton::getInstance('VRicercaEsami');
        $nomeEsame = $vEsami->recuperaValore('esame');
        $clinica = $vEsami->recuperaValore('clinica');
        $luogo = $vEsami->recuperaValore('luogo');
        $fEsami = USingleton::getInstance('FEsame');
        $fEsami->recuperaEsami($nomeEsame, $clinica, $luogo);
    }
    
//     private function  recuperaValore($indice) 
//    {
//        if(isset($_POST[$indice]))
//       {
//            $parametro = $_POST[$indice];
//       }
//       else
//       {
//           
//       }
//       return $parametro;
//    }
}
