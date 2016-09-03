<?php

require_once './include/SPL Autoload.php';
require_once './include/Config.php';

$cHome= USingleton::getInstance('CHome');
$cHome->impostaPagina();

//        $query = "SELECT * FROM Utente";
//        $cHome= USingleton::getInstance('CHome');
//        $fdb= new FDatabase();
//        $fdb->eseguiQuery($query);
//        print_r($fdb);
//            $view = new VHome();
//            $navBar = $view->prelevaTemplate("navigationBar");
//            $logIn = $view->prelevaTemplate("logIn");
//            $main = $view->prelevaTemplate("areaPersonale");
//            $cartina = $view->prelevaTemplate("cartinaItalia");
//////        $inserisci = $view->prelevaTemplate("inserisci");
//////        $inserisci = $this->prelevaTemplate("mainRicerca");
////////        $this->assegnaVariabiliTemplate("mainRicerca", $inserisci);
//////        //assegno le variabili ai template
//            $view->assegnaVariabiliTemplate("mainRicerca", $main);
//            $view->assegnaVariabiliTemplate("navigationBar", $navBar);
//            $view->assegnaVariabiliTemplate("logIn", $logIn);
//            $view->assegnaVariabiliTemplate("cartina", $cartina);
//////        // visualizzo il template
//            $view->visualizzaTemplate("HomePage");
//
?>


