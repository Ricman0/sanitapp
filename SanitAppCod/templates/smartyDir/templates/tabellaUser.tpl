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
            <h4>User Bloccati</h4>
        {elseif $daValidare===TRUE}
            <h4>User Da Validare</h4>
        {else}
            <h4>User</h4>
        {/if}
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['Username']}" class="rigaUser">
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
