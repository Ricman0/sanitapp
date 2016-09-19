<table>
    <thead>
        <th>Clinica</th>
        <th>Località</th>
        <th>Provincia</th>
    </thead>
    <tbody>
        {foreach from=$dati item=curr_row}
            <tr>
                <td>{$curr_row['NomeClinica']}</td>
                <td>{$curr_row['Località']}</td>
                <td>{$curr_row['Provincia']}</td>
            </tr>
        {/foreach}
    </tbody>
</table>