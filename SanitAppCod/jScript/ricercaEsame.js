/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $('#headerMain').on("click","#ricercaEsamiCerca", function() {
        inviaDatiForm();
    });
});

function inviaDatiForm()
{
    var controller = $("#controllerFormRicercaEsami").val();
    var nome = $("#nomeClinicaFormRicercaEsami").val();
    
    var nomeEsame = $("#nomeEsameFormRicercaEsami").val();
    var luogo = $("#luogoClinicaFormRicercaEsami").val();
    var url;
    
    url = controller;
    //nome esame !=0
    if(nomeEsame.length!==0)
    {
        //nome e luogo = 0
        if( nome.length===0)
        {
            if(luogo.length===0)
            {
                url = url + "/" + nomeEsame;
            }
            else
            {
                url = url + "/" + nomeEsame + "/all/" + luogo;
            }           
        }
        else
        {
            if(luogo.length===0)
            {
                url = url + "/" + nomeEsame + "/" + nome;
            }
            else
            {
                url = url + "/" + nomeEsame + "/"+nome + "/" + luogo;
            } 
        }    
    }
    //nome esame =0
    else
    {
        if(nome.length!==0)
        {
            if(luogo.length===0)
            {
                url = url + "/all/" + nome;
            }
            else
            {
                url = url + "/all/" + nome + "/" + luogo;
            }
        }
        else
        {
            url = url + "/all/all/" + luogo;
        }
    }
    
    $.ajax({
        
        
        //url della risorsa alla quale viene inviata la richiesta
        // url:  "index.php",
        url: url,
        
        //il tipo di richiesta HTTP da effettuare, di default è GET
        type: 'GET',        
        dataType: "html",
        success: function(msg)
        {
            alert("Dati ricerca esame inviati per effettuare la registrazione");
            $("#main").html(msg);
        },
        error: function()
        {
            alert("Chiamata fallita, si prega di riprovare...  ");
            
        }   
    });
}
