<?php
/**
 * SanitApp application
 **/
require_once __DIR__ . '/include/SPL Autoload.php';
require_once __DIR__ . '/include/Config.php';

define('SANITAPP_MINIMUM_PHP_VERSION', '5.4.0');

if (version_compare(PHP_VERSION,SANITAPP_MINIMUM_PHP_VERSION, '<'))
{
	die('Hai bisogno di php ' . SANITAPP_MINIMUM_PHP_VERSION . ' per utilizzare SanitApp!');
}

$cSetup =  USingleton::getInstance('CSetup');
$cSetup->impostaPagina();



