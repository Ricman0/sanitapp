<table id="tabellaPrenotazioni" class="tablesorter">
    <thead>
        <th>ID Prenotazione</th>
        <th>ID Esame</th>
        <th>Esame</th>
        <th>Nome </th>
        <th>Cognome</th>
        <th>Data e Ora</th>
        <th>Codice Fiscale</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPrenotazione" aria-hidden="true" ></i>           
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['IDPrenotazione']}" class="rigaPrenotazione">
                <td>{$curr_row['IDPrenotazione']}</td>
                <td>{$curr_row['IDEsame']}</td>
                <td>{$curr_row['NomeEsame']}</td>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['Cognome']}</td>
                <td>{$curr_row['DataEOra']}</td>
                <td>{$curr_row['CodFiscale']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>