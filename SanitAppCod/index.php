<?php
//$user_agent = getenv("HTTP_USER_AGENT");
////echo "c";
//$dir = ;
////echo 'a';
//if(strpos($user_agent, "Win") !== FALSE)
//{
//    $os = "Windows";
//}
//elseif(strpos($user_agent, "Mac") !== FALSE)
//{
//    $os = "Mac";
//    echo 'sd';
//    print_r($dir);
//    echo 'td';
//}

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