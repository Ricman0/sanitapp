<table id="tabellaPrenotazioni" class="tablesorter">
    <thead>
        <th>ID Prenotazione</th>
        <th>ID Esame</th>
        <th>Nome Esame</th>
        <th>Nome Clinica</th>
        <th>Data e Ora</th>
        <th>Confermata</th>
        <th>Eseguita</th>
        <th>Tipo</th>
        <th>Medico Esame</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x" id="icona-aggiungi" aria-hidden="true" ></i>
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr>
                <td>{$curr_row['IDPrenotazione']}</td>
                <td>{$curr_row['IDEsame']}</td>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['NomeClinica']}</td>
                <td>{$curr_row['DataEOra']}</td>
                <td>{$curr_row['Confermata']}</td>
                <td>{$curr_row['Eseguita']}</td>
                <td>{$curr_row['Tipo']}</td>
                <td>{$curr_row['MedicoEsame']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>