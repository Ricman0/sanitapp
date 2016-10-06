<table id="tabellaPazienti" class="tablesorter">
    <thead>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Via</th>
        <!--<th>Numero Civico</th>-->
        <th>CAP</th>
        <th>Email</th>
        <th>Codice Fiscale</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungi" aria-hidden="true" ></i>
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['CodFiscale']}" class="rigaPaziente">
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['Cognome']}</td>
                <td>{$curr_row['Via']}, {$curr_row['NumCivico']}</td>
                <!--<td>{$curr_row['NumCivico']}</td>-->
                <td>{$curr_row['CAP']}</td>
                <td>{$curr_row['Email']}</td>
                <td>{$curr_row['CodFiscale']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>