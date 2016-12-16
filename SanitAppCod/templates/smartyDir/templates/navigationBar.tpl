<nav id="navigationBar">
    <ul class="nav">
        <li class="nav" id="home">
            <a class="nav homepage"  id="homeNavBar">
                <i class="fa fa-home fa-2x" id="icona-home" aria-hidden="true" ></i>
            </a>
        </li>
        <li class="nav" id="cliniche">    
            <a class="nav"><i class="fa fa-hospital-o fa-lg" id="icona-cliniche" aria-hidden="true"></i> Cliniche</a> 
        </li>
        <li class="nav" id="esami">
            <a  class="nav" >
                <i class="fa fa-file-text-o fa-lg" id="icona-esami" aria-hidden="true"></i> Esami</a>
        </li>
        {if isset($username)}
            <li class="nav mySanitApp" id="mySanitApp">
                <a class="nav" ><i class="fa fa-user fa-lg" id="icona-mySanitApp" aria-hidden="true"></i> MySanitApp</a>
            </li>
        {else}
            <li class="nav" id="registrazione">
                <a class="nav" ><i class="fa fa-user-plus fa-lg" id="icona-registrazione" aria-hidden="true"></i> Registrazione</a>
               <div class="dropdown-content">
                    <a id="registrazioneUtente" ><i class="fa fa-user fa-lg" id="icona-esami" aria-hidden="true"></i> Utente</a>
                    <a id="registrazioneMedico" ><i class="fa fa-user-md fa-lg" id="icona-esami" aria-hidden="true"></i> Medico</a>
                    <a id="registrazioneClinica" ><i class="fa fa-hospital-o fa-lg" id="icona-esami" aria-hidden="true"></i> Clinica</a>
                </div>
            </li>
        {/if}
    </ul>
</nav>