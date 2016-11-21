<?php

/**
 * Funzione che consente di caricare le classi necessarie per l'applicazione
 * 
 * @author Claudia Di Marco & Riccardo Mantini
 * @param string $nomeClasse Stringa contenente il nome della classe da caricare
 */
function SanitAppAutoload($nomeClasse)
{
    /*
     * Il percorso completo e il nome del file con i link simbolici risolti.
     * Se utilizzato all'interno di un'inclusione, viene restituito il nome 
     * del file incluso. 
     */
    
    /*
     * DIRECTORY_SEPARATOR è una costante predefinita di PHP che contiene
     * il carattere utilizzato dal sistema operativo su cui gira il server
     *  per comporre i percorsi dei file.
     */
    
    
    /* potrei inserire questa funzione invece degli switch ma devo vedere bene 
     * cosa esce da dirname
     * $nomeFile = dirname(__FILE__).DIRECTORY_SEPARATOR.($nomeClasse).'.php';
     * if (is_readable($nomeFile))
     *  {
     *      require $nomeFile;
     *   }
     */
    switch ($nomeClasse[0])
    {
        case'C':
            $nomeFile = './Controller/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
            
        case'E':
            $nomeFile = './Entity/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
            
        case'F':
            $nomeFile = './Foundation/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
            
        case'U':
            $nomeFile = './Utility/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
            
        case'V':
            $nomeFile = './View/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
        
        case'X':
            $nomeFile = './Eccezioni/' . $nomeClasse . '.php';
            if (is_readable($nomeFile))
            {
                require ($nomeFile);
            }
            break;
    }
}

/*
 * La funzione phpversion() ritorna la currente versione di php usata
 */

/* versione_compare(versione1, versione2, operator) compara le due versione 
 * di php passate come argomenti 
 * e ritorna TRUE  se la relazione è quella specificata dall'operatore >=
 * FALSE altrimenti. 
*/

 if (version_compare(phpversion(), '5.1.2', '>=')) 
    {
        //la funzione SPL autoloading è stata introdotta in PHP 5.1.2
        if (version_compare(phpversion(), '5.3.0', '>=')) 
            {
               
                spl_autoload_register('SanitAppAutoload', true, true);
            } 
        else 
            {
                spl_autoload_register('SanitAppAutoload');
                
            }
    } 
else 
    {
        // la funzione __autoload($nomeClasse) è deprecata ormai
        function __autoload($nomeClasse)
        {
            SanitAppAutoload($nomeClasse);
            
        }
    }
