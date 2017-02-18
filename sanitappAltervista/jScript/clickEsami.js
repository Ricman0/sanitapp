$(document).ready(function () {
    
    $('#headerMain').on("click", "#esami", function (e) {
        var ajaxDiv = '#main';
        if( $("#contenutoAreaPersonale").length  )
        {
            ajaxDiv = '#contenutoAreaPersonale';
            
        }
        inviaController('ricercaEsami', ajaxDiv);
          
    });
    
    $('#headerMain').on("click", ".rigaEsame", function () {
        var id = $(this).attr('id');// id della riga che coincide con l'id dell'esame
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        var controller = $("#controllerTabella").attr("value");
        if(controller === "esami")
        {
            clickRiga(controller, 'visualizza', id, contenitore);
        }

    });
});