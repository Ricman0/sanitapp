/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

    $('#main').on("click","#serviziAreaPersonaleClinica", function() {
        inviaControllerTask('servizi', 'visualizza', "#contenutoAreaPersonaleClinica");
    });
});
