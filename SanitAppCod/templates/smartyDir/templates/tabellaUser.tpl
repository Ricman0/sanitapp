<table id="tabellaUser" class="tablesorter">
    <thead>
        <th>Username</th>
        <th>Email</th>
        <th>Tipo User</th>
        <th>Bloccato</th>
       <!-- <th>Validato</th> -->
    </thead>
    <tbody>
        <br>

        <h4>User </h4>
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['Username']}" class="rigaUser">
                <td>{$curr_row['Username']}</td>
                <td>{$curr_row['Email']}</td>
                <td>{$curr_row['TipoUser']}</td>
                <td>{$curr_row['Bloccato']}</td>
                <!--
                {if ($curr_row['TipoUser']=='clinica' || $curr_row['TipoUser']=='medico')}
                    <td>{$curr_row['Validato']}</td>
                {/if}
                -->
            </tr>
        {/foreach}
    </tbody>
</table>
