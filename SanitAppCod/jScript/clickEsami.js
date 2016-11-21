$(document).ready(function () {

    
    $('#headerMain').on("click", "#esami", function () {
        inviaController('ricercaEsami', '#main');
    });
    
    $('#headerMain').on("click", ".rigaEsame", function () {
        var id = $(this).attr('id');// id della riga che coincide con l'id dell'esame
//        var nomeClinica = $('.rigaNomeClinica').html();
//        alert(nomeClinica);
        var contenitore = "#" + $(this).closest("div").prop("id"); //ritorna l'elemento contenitore sul quale inserire la risposta ajax
        var controller = $("#controllerTabella").attr("value");
        if(controller == "esami")
        {
            clickRiga(controller, 'visualizza', id, contenitore);
        }

    });
});

function inviaController($controller, ajaxdiv)
    {
       $.ajax({
            type: 'GET',
            url: $controller ,
            success: function(datiRisposta)
            {
                
                alert(datiRisposta);
                $(ajaxdiv).html(datiRisposta);
//                if(ajaxdiv === '#contenutoAreaPersonale')
//                {
//                    $('#ricercaEsamiCerca').attr('data-AreaPersonale','SI');
//                }
            },
            error:function()
            {
                alert("Sbagliato ESAMI");
            }
        });  
    }