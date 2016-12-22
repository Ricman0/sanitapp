$(document).ready(function() {
    
    
    $('#headerMain').on("click","#cliniche", function(event){
        event.preventDefault();
        inviaController('ricercaCliniche', '#main');
    });
    
    $('#headerMain').on("click","#bottoneRicercaCliniche", function(){
        inviaDati();
    });
    
});


function inviaDati(){
    
    var controller = $("#controllerFormRicercaCliniche").val();
//    controller = controller.replace(" ", ""); 

    var nome = (($("#nomeClinicaFormRicercaCliniche").val()).toLowerCase()).trim(); 
    nome = nome.replace(" ", "_"); 
    
    var luogo = (($("#luogoClinicaFormRicercaCliniche").val()).toLowerCase()).trim(); 
    luogo = luogo.replace(" ", "_"); 
    
    var url;
    if (nome.length===0 && luogo.length===0)
    {
        url = controller;
    }
    else
    {
         if(nome.length===0 || luogo.length===0)
        {
            if(luogo.length===0)
            {
                url = controller + "/" + nome + "/all";
            }
            else
            {
                url = controller + "/all/"+ luogo;
            }
            
        }
        else
        {
            url = controller +"/"+ nome + "/" +luogo  ;
        }
    }
    $.ajax({
      //type: "POST",
      type: "GET",
      url: url,
      //data: "nome=" + nome + "&luogo=" + luogo + "&controller=" + controller,
      dataType: "html",
      success: function(msg)
      {
        $("#main").html(msg);
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
}

function validainput()
{
    jQuery.validator.addMethod();
    
    $("#formRicercaCliniche").validate({
        rules:
                {
                    nomeClinicaFormRicercaCliniche:
                    {
                        maxlength:30
                    },
                    luogoClinicaFormRicercaCliniche:
                    {
                        maxlength:40
                    }  
                },
        messages:
                {
                    nomeClinicaFormRicercaCliniche:
                    {
                        maxlength:"La sequenza di caratteri può essere massimo 30"
                    },
                    luogoClinicaFormRicercaCliniche:
                    {
                        maxlength:"La sequenza di caratteri può essere massimo 40"
                    } 
                },
        submitHandler:function(form){}
     });
}
/*
function inviaController($controller, ajaxdiv, id)
{
    var dati = $(id).serialize();
    $.ajax({
        type: 'POST',
//        url:$controller,
        url: "cliniche", 
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
*/ 

