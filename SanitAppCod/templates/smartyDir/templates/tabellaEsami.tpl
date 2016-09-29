<table id="tabellaEsami" class="tablesorter">
    <thead>
        <th>Nome</th>
        <th>Descrizione</th>
        <th>Prezzo</th>
        <th>Durata</th>
        <th>Medico</th>
        <th>Categoria</th>
        <th>Clinica</th>
        <th>Località</th>
    </thead>
    <tbody>
        <br>
        {if isset($tastoAggiungi)}
            <i class="fa fa-plus-circle fa-2x" id="icona-aggiungi" aria-hidden="true" ></i>
        {/if}
        <br>
        
        {foreach from=$dati item=curr_row}
            <tr>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['Descrizione']}</td>
                <td>{$curr_row['Prezzo']}</td>
                <td>{$curr_row['Durata']}</td>
                <td>{$curr_row['MedicoEsame']}</td>
                <td>{$curr_row['NomeCategoria']}</td>
                <td>{$curr_row['NomeClinica']}</td>
                <td>{$curr_row['Località']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>