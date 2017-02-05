<h3>CLIENTI DELLA CLINICA</h3>
<hr>
<br>
<h4>Clicca su una riga per avere informazioni sul cliente corrispondente</h4>
<table id="tabellaClienti" class="tablesorter">
    <thead>
        <th>Codice Fiscale</th>
        <th>Nome</th>
        <th>Cognome</th>
        <th>Via</th>
        <th>CAP</th>
        <th>Email</th> 
    </thead>
    <tbody>        
        {foreach from=$dati item=curr_row}
            <tr id="{$curr_row['CodFiscale']}" class="rigaCliente cliccabile">
                <td>{$curr_row['CodFiscale']}</td>
                <td>{$curr_row['Nome']}</td>
                <td>{$curr_row['Cognome']}</td>
                <td>{$curr_row['Via']}, {$curr_row['NumCivico']}</td>
                <td>{$curr_row['CAP']}</td>
                <td>{$curr_row['Email']}</td>
                
            </tr>
        {/foreach}
    </tbody>
</table>