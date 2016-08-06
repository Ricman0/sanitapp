
/*
 * Quando il DOM è pronto, mando in run questa funzione.
 * Tale funzione si pone in attesa di un evento click sull'elemento con 
 * id = registrazione.
 * Quando avviene il click su registrazione, viene eseguita la funzione inviaControllerTask
 */
$(document).ready(function () {

        $("#registrazioneUtente").click(function () {
            inviaControllerTask('registrazione', 'utente', '#main' );
        });
        
        $("#registrazioneMedico").click(function () {
            inviaControllerTask('registrazione', 'medico', '#main' );
        });
        
        $("#registrazioneClinica").click(function () {
            inviaControllerTask('registrazione', 'clinica', '#main' );
        });
});


/*
 * 
 * @param string controller
 * @param string task1
 * @param string ajaxdiv
 * @returns {undefined}
 */
function inviaControllerTask(controller1, task1, ajaxdiv) 
{
    $.ajax({
        // definisco il tipo della chiamata
        type: 'GET' ,
        
        // specifico la URL della risorsa 
        url: controller1 + '/' + task1,

        
//        data:{
//            controller:controller1, 
//            task: task1
//            
//        },

        // imposto azione per il caso di successo
        success: function (datiRisposta) 
                {
                        alert(datiRisposta);
                        $(ajaxdiv).html(datiRisposta);

                }
    });
}

