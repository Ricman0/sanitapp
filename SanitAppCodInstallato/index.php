<?php

require_once __DIR__ . '/include/SPL Autoload.php';
require_once __DIR__ . '/include/Config.php';
$cHome= USingleton::getInstance('CHome');
if (PHP_SAPI === 'cli') 
    {
        $cHome->smistaJob($argv); //per il cronjob
    }
else
    {
        $cHome->impostaPagina(); // gestisce le richieste HTTP
    }