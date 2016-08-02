$(document).ready(function(){
    $('#mySanitApp').click(function(){
       inviaController('mySanitApp', '#contenutiAjax');
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
            error:alert("Sbagliato MYSANITAPP")
        });  
    }
});


