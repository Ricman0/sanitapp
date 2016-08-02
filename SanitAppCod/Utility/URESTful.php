<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of URESTful
 * 
 * @package Utility.URESTful
 * @author Claudia Di Marco & Riccardo Mantini
 */
class URESTful
{
    /*
     * Attributi della classe URESTful
     */
    
    /**
     * @ var string $_methodRequest Il metodo contenuto nella HTTP Request (esempio: GET, POST, ...)
     * $_metodoRequest viene inizializzato a "".
     */
    private $_methodRequest="";
    
    /**
     * @var int $_statusCode Il codice da inserire nella HTTP Response (esempio: 200, 404, ...)
     * Il codice dello stato della risposta è inizializzato a 200
     */
    private $_statusCode=200;
    
    /**
     * @var Array $_elementiUrl Array contenente gli elementi dell'url 
     */
    private $_elementiUrl;
    
    /**
     * @var Array $_parametri Array contententi i valori passati nel post 
     */
    private $_parametri;
    
    /**
     * @var string $_contentType Stringa contenente il content type della risposta HTTP.
     * Il valore di defalut è "text/html"
     */
    private $_contentType = "text/html";
    
    /**
     * Metodo costruttore
     */
    public function __construct() 
    {
        //permette di impostare l'attributo $_metodoRequest
        $this->_methodRequest = $_SERVER['REQUEST_METHOD'];
        /* explode divide l'url in più parti. Ogni volta che incontra / memorizza
         *  la sottostringa contenuta tra / e / in un array. 
         */
        $this->_elementiUrl = explode( '/', $_SERVER['PATH_INFO']); // oppure $_SERVER['REQUEST_URI']
        $this->input();
    }
    
    /**
     * Metodo che permette di conoscere il metodo della Request Line nella HTTP Request 
     * 
     * @access public
     * @return string Il metodo contenuto nella HTTP Request 
     */
    public function getMethodRequest() 
    {
        return $this->_methodRequest ;
    }
    
    /**
     * Metodo che permette di impostare l'attributo $_metodoRequest
     * 
     * @access private
     * @return string Il metodo contenuto nella HTTP Request 
     */
    private function setMethodRequest()
    {
        $this->_methodRequest = $_SERVER['REQUEST_METHOD'];
    }
    
    /**
     * Metodo che permette di conoscere l'URI della Request HTTP in modo 
     * da identificare la risorsa per poter applicare la richiesta
     * 
     * @access public
     * @return string L'URI contenuta nella HTTP Request 
     */
    public function getURI()
    {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Metodo che trasforma  le informazioni contenuto nello status code della 
     * risposta HTTP in una frase leggibile.  
     * 
     * @access private
     * @return string Lo status phrase 
     */
    private function getStatusPhrase() 
    {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Page Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            511 => 'Network Authentication Required');
        return ($status[$this->_statusCode]) ? $status[$this->_statusCode] : $status[500];
    }
    
    /**
     * Metodo per impostare l'header della risposta HTTP
     * 
     * @access private
     */
    private function setHeaderResponse()
    {
        header("HTTP/1.1 ".$this->_statusCode." ".$this->getStatusPhrase());
        header("Content-Type:" . $this->_contentType );
    }
    
    /*
     * Metodo che permette di analizzare i dati in ingresso in base al tipo
     * di richiesta 
     * 
     * @access private 
     */
    private function input() 
    {
        switch ($this->getMethodRequest())
        {
            case "POST":
                $body = file_get_contents($_POST);
                $this->inputParametri($body);
                break;
            case "GET":
                if(isset($_SERVER['QUERY_STRING']))
                {
                    parse_str($_SERVER['QUERY_STRING'], $_parametri);
                }
                $body = file_get_contents($_GET);
                $this->inputParametri($body);
                break;
            case "PUT":
                $body = file_get_contents("php://input");
                $this->inputParametri($body);
                break;
                break;
            case "DELETE":
                $body = file_get_contents($_GET);
                $this->inputParametri($body);
                break;
            default:
                $this->risposta('', 406);
                break;
        }
    }
    
    /**
     * @access private
     */
    private function inputParametri($body) 
    {
        if(isset($_SERVER['CONTENT_TYPE']))
                {
                    $this->_contentType = $_SERVER['CONTENT_TYPE'];
                }
                switch ($_contentType) 
                {
                    case "application/json":
                        $bodyParam = json_decode($body);
                        if($bodyParam)
                        {
                            foreach ($bodyParam as $nomeParam => $valoreParam) 
                            {
                                $this->_parametri[$nomeParam] = $valoreParam;
                            }
                        }
                        break;
                    case "application/x-www-form-urlencoded":
                        parse_str($body, $postVar)= json_decode($body);
                        foreach ($postVar as $campo => $valore) 
                        {
                            $this->_parametri[$campo] = $valore;
                        }
                        break;
                    default:
                        break;
                }        
    }
    
    /**
     * @access public
     */
    public function response($data, $code) 
    {
        $this->_statusCode = ($code)? $code : 200;
        $this->setHeaderResponse();
        echo data;
        exit;
    }
}
