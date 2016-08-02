<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./Css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="./Css/logo.css">
        <link rel="stylesheet" type="text/css" href="./Css/homePage.css">
        <link rel="icon" href="./Immagini/favicon.ico" />
        <script type="text/javascript" src="./jScript/jquery-1.12.4.min.js"></script>
        <link rel="stylesheet" type="text/css" href="./Css/logIn.css">

        <link rel="stylesheet" type="text/css" href="./Css/navigationBar.css">
        <link rel="stylesheet" type="text/css" href="./Css/mainRicerca.css">  
        <link rel="stylesheet" type="text/css" href="./Css/footer.css">
        <link rel="stylesheet" type="text/css" href="./Css/cartinaItalia.css"/>
        <script type="text/javascript" src="./jScript/gestioneCartinaItalia.js"></script>
<!--<img src="./Immagini/cartinaItalia.gif" />
  <!--      <link rel="stylesheet" type="text/css" href="./Css/inserisciUtente.css">
        <link rel="stylesheet" type="text/css" href="./Css/inserisciMedico.css">
        
        

        <!--inserisco meta viewport per ottenere una nav bar responsive
        <meta name="viewport" content="width=device-width" initial-scale=1  maximum-scale=1>    

        <meta charset="UTF-8">
        
        <script type="text/javascript" src="./jScript/adaptive-image.js"></script>
        <script type="text/javascript" src="./jScript/eventi_click.js"></script>
        
-->

    <body>
        <!-- Classe container per l'intera pagina-->
        <div id="wrapper">

            <!-- Header della pagina-->
            
            <div class="header" id="header">
                <img id="logoSanitApp" src="Immagini/logoSanitApp.png" alt="logoSanitApp">
                {$logIn}
                {$navigationBar}    <!-- Navigation bar della pagina-->
            </div>
        
            <!-- Main della pagina-->
        <div id="main">
            {$mainRicerca}
            {$cartina}
        </div> 
        <!--
        <div id="contenutiAjax">
            
        </div>
        <!--Footer della pagina-->
            <div id="footer">
                <span class="copyright">©2016 Copyright - SanitApp</span>
            </div>
        </div>
    </body>
</html>