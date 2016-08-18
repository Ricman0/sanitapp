$(document).ready(function(){
    $('#mySanitApp').click(function(){
       inviaController('mySanitApp', '#contenutiAjax');
    });
    $('#prenotazioniAreaPersonaleUtente').click(function(){
       inviaControllerTask('mySanitApp','prenotazioni', '#contenutiAjax');
    });
    
    $('#refertiAreaPersonaleUtente').click(function(){
       inviaControllerTask('mySanitApp','referti', '#contenutiAjax');
    });
    
    $('#impostazioniiAreaPersonaleUtente').click(function(){
       inviaControllerTask('mySanitApp','impostazioni', '#contenutiAjax');
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
            error:function(){
                alert("Sbagliato MYSANITAPP");
            }
        });  
    }
    
    function inviaControllerTask(controller1, task1, ajaxdiv) 
    {
        $.ajax({
            type: 'GET' ,
            url: controller1 + '/' + task1,
            success: function (datiRisposta) 
                    {
                            alert(datiRisposta);
                            $(ajaxdiv).html(datiRisposta);
                    },
            error: function(){
                alert("errore in area personale");
            }
        });
    }

});


