$(document).ready(function() {
    
    //click sul tasto cliniche della navigationBar
    $('#headerMain').on("click","#cliniche", function(event){
        event.preventDefault();
        var ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  )
        {
            ajaxDiv = '#contenutoAreaPersonale';
            
        }
        inviaController('ricercaCliniche', ajaxDiv);
    });
    
    
    $('#headerMain').on("click","#bottoneRicercaCliniche", function(){
        var ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  )
        {
            ajaxDiv = '#contenutoAreaPersonale';
            
        }
        var nomeClinica = $('#nomeClinicaFormRicercaCliniche').val().toLowerCase().trim();;
        var luogoClinica = $('#luogoClinicaFormRicercaCliniche').val().toLowerCase().trim();;
        var datiPOST = {nome:nomeClinica, luogo:luogoClinica};
        $.ajax({
            type: 'POST',
            url: 'cliniche',
            data: datiPOST,
            success: function(datiRisposta)
            {
              $(ajaxDiv).html(datiRisposta);
              $("#tabellaCliniche").tablesorter({
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
