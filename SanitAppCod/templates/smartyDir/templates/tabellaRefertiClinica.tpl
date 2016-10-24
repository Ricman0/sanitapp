<table id="tabellaReferti" class="tablesorter">
    <thead>
        <th>ID Referto</th>
        <th>ID Prenotazione</th>
        <th>ID Esame</th>
        <th>Esame</th>
        <th>Nome </th>
        <th>Cognome</th>
        <th>Codice Fiscale</th>
        <th>Data</th>
        
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiReferto" aria-hidden="true" ></i>           
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['IDReferto']}" class="rigaPrenotazione">
                <td>{$curr_row['IDReferto']}</td>
                <td>{$curr_row['IDPrenotazione']}</td>
                <td>{$curr_row['IDEsame']}</td>
                <td>{$curr_row['NomeEsame']}</td>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['Cognome']}</td>
                <td>{$curr_row['CodFiscaleUtenteEffettuaEsame']}</td>
                <td>{$curr_row['DataReferto']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>