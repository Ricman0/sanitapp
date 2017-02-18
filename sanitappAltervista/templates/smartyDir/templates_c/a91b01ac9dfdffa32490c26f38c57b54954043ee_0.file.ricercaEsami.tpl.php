<?php
/* Smarty version 3.1.29, created on 2017-02-18 21:32:22
  from "/membri/sanitapp/templates/smartyDir/templates/ricercaEsami.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_58a8af567f10b9_04521380',
  'file_dependency' => 
  array (
    'a91b01ac9dfdffa32490c26f38c57b54954043ee' => 
    array (
      0 => '/membri/sanitapp/templates/smartyDir/templates/ricercaEsami.tpl',
      1 => 1487443622,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58a8af567f10b9_04521380 ($_smarty_tpl) {
?>
<h3 class="grigio" >RICERCA ESAME</h3>
<hr>
<br>
<form id="formRicercaEsami" method="POST">
    <div  id="inputRicercaEsami">
        <input type="hidden" name="controller" class ='controllerFormRicercaEsami' value="esami" id="controllerFormRicercaEsami"/> 
        <label for="esame" class="ricerca">Nome Esame</label>
        <input type="text" name="esame" class="ricerca"  target="_blank" id="nomeEsameFormRicercaEsami"
               placeholder="Raggi"/>
        <label for="clinica" class="ricerca">Clinica</label>
        <input type="text" name="clinica" class="ricerca" target="_blank" id="nomeClinicaFormRicercaEsami"
               placeholder="Villa Serena"/>
        <label for="luogo" class="ricerca">Luogo</label>
        <input type="text" name="luogo" class="ricerca" target="_blank" id="luogoClinicaFormRicercaEsami"
               placeholder="Roma"/>
        <br>
        <input type="button" id="ricercaEsamiCerca" class="ricercaEsamiCerca"  value="Cerca">
        
    </div>
</form>
<?php }
}
