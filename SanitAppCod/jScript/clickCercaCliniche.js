$(document).ready(function () {
    
    $("#ricercaClinicheCerca").click(function (event) {
        event.preventDefault();
        inviaController('cliniche', '#main', '#formRicercaCliniche');
    });
});

function inviaController($controller, ajaxdiv, id)
{
    var dati = $(id).serialize();
    $.ajax({
        type: 'POST',
        url:$controller,
        data: dati,
        success: function(datiRisposta)
        {
            alert(datiRisposta);
            $(ajaxdiv).html(datiRisposta);
        },
        error:function()
        {
            alert("Sbagliato click su CERCA CLINICHE");
        }
        
    });
}


