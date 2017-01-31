<table id="tabellaUser" class="tablesorter">
    <thead>
        {if ($bloccati===TRUE  || $daValidare===TRUE)}
            <td>Nome</td>
        {/if}
        <th>Username</th>
        <th>Email</th>
        <th>Tipo User</th>
        {if ($bloccati!==TRUE && $daValidare!==TRUE) }
            <th>Bloccato</th>
        {/if}
       <!-- <th>Validato</th> -->
    </thead>
    <tbody>
        <br>
        {if $bloccati===TRUE }
            <h3>USER BLOCCATI</h3>
            <h4>Clicca su una riga della tabella per visualizzare l'user corrispondente.</h4>
        {elseif $daValidare===TRUE}
            <h3>USER DA VALIDARE</h3>
            <h4>Clicca su una riga della tabella per visualizzare l'user corrispondente.</h4>
        {else}
            <h3>USER</h3>
            <h4>Clicca su una riga della tabella per visualizzare l'user corrispondente.</h4>
            <h4>Clicca sull'icona successiva per aggiungere un nuovo user.</h4>
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiUser" aria-hidden="true" ></i>              
            <br>
        {/if}
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['Username']}" class="rigaUser cliccabile">
                {if ($bloccati===TRUE  || $daValidare===TRUE) }
                    {if ($curr_row['TipoUser']==='utente' || $curr_row['TipoUser']==='medico')}
                        <td>{$curr_row['Nome']} {$curr_row['Cognome']}</td>
                    {else}
                        <td>{$curr_row['NomeClinica']}</td>
                    {/if}
                {/if}
                <td>{$curr_row['Username']}</td>
                <td>{$curr_row['Email']}</td>
                <td>{$curr_row['TipoUser']}</td>
                {if ($bloccati!==TRUE && $daValidare!==TRUE) }
                <td>{$curr_row['Bloccato']}</td>
                {/if}
                
                <!--
                {if ($curr_row['TipoUser']=='clinica' || $curr_row['TipoUser']=='medico')}
                    <td>{$curr_row['Validato']}</td>
                {/if}
                -->
            </tr>
        {/foreach}
    </tbody>
</table>
