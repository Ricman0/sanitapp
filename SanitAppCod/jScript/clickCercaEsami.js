
$(document).ready(function () {
    $('#headerMain').on("click", ".ricercaEsamiCerca", function () {
        
//        var id = $(this).attr('id');// id= ricercaEsamiCerca 
//        //this si riferisce al button ricercaEsamiCerca. Io cerco il div più vicino che abbia come id contenutoAreaPersonale 
//        // e poi prendo id che ovviamente è contenutoAreaPersonale.
//        var ajaxDiv = "#" + $(this).closest('div').prop('id');
        var ajaxDiv = '#main';
        //se esiste il div contenutoAreaPersonale
        if ($('#contenutoAreaPersonale').length) {
            ajaxDiv ='#contenutoAreaPersonale';
        }
        var  nomeClinica = '';
        if($("input[name=clinica]").length){
            nomeClinica = (($("input[name=clinica]").val()).toLowerCase()).trim();
        }
         
        var nomeEsame = (($("input[name=esame]").val()).toLowerCase()).trim();
        var luogo = (($("input[name=luogo]").val()).toLowerCase()).trim();
        var datiPOST = {nomeClinica:nomeClinica, luogo:luogo, nomeEsame: nomeEsame};
        $.ajax({
            type: 'POST',
            url: 'esami',
            data: datiPOST,
            success: function(datiRisposta)
            {
                $(ajaxDiv).html(datiRisposta);
                if ($('#tornaHomePageButton').length &&  $('#contenutoAreaPersonale').length) {
                    $('#tornaHomePageButton').replaceWith("<input class='mySanitApp' id='tornaAreaPersonaleButton' value='OK' type='button'>");
                }
                $("#tabellaEsami").tablesorter({
                      theme: 'blue',
                      widgets: ["filter"],
                      widgetOptions: {
                          // filter_anyMatch replaced! Instead use the filter_external option
                          // Set to use a jQuery selector (or jQuery object) pointing to the
                          // external filter (column specific or any match)
                          filter_external: '.search',
                          // add a default type search to the first name column
                          filter_defaultFilter: {1: '~{query}'},
                          // include column filters
                          filter_columnFilters: true,
                          filter_placeholder: {search: 'Search...'},
                          filter_saveFilters: true,
                          filter_reset: '.reset'
                      }

                  });
              },
            error: function()
            {
              alert("Chiamata fallita, si prega di riprovare...");
            }
        });
    });
});

