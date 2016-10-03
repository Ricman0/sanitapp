<table id="tabellaPrenotazioni" class="tablesorter">
    <thead>
        <th>ID Prenotazione</th>
        <th>Nome Esame</th>
        <th>Nome Clinica</th>
        <th>Data e Ora</th>
        <th>Eseguita</th>
        <th>Medico Esame</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x tastoAggiungi" id="iconaAggiungiPrenotazione" aria-hidden="true" ></i>           
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr {$curr_row['IDPrenotazione']}>
                <td>{$curr_row['IDPrenotazione']}</td>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['NomeClinica']}</td>
                <td>{$curr_row['DataEOra']}</td>
                <td>{$curr_row['Eseguita']}</td>
                <td>{$curr_row['MedicoEsame']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>