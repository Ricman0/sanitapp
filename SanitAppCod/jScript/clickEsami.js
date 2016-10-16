$(document).ready(function () {

    $("#esami").click(function () {
        inviaController('ricercaEsami', '#main');
    });
    
    $('#main').on("click", ".rigaEsame", function () {
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
            },
            error:function()
            {
                alert("Sbagliato ESAMI");
            }
        });  
    }