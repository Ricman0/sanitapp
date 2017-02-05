<div id="divContatti" class="affiancato">
     <h3>CONTATTI</h3>
    <hr>
    <br>
    <i class="fa fa-user fa-5x sanitAppColor centrato block" id="iconaContatti" aria-hidden="true"></i>
   <div id="contattiTelefonici" class="affiancato verticalmenteAllineato margine40" >
        <i class="fa fa-phone fa-4x sanitAppColor affiancato margine20 verticalmenteAllineato" id="iconaContattiTelefonici" aria-hidden="true"></i>
        <span class="affiancato">
            <p> {if isset($telefono)}<h4>Telefono: </h4> {$telefono} {/if}</p>
        <p> {if isset($fax)} <h4>Fax: </h4> {$fax} {/if}</p>
        </span>
    </div>
    <div id="contattiMail" class="affiancato verticalmenteAllineato margine40">
        <i class="fa fa-envelope fa-4x sanitAppColor affiancato margine20 verticalmenteAllineato" id="iconaContattiMail" aria-hidden="true"></i>
        <span class="affiancato verticalmenteAllineato">
            <p> {if isset($eMail)}<h4>E-Mail: </h4> {$eMail} {/if}</p>
        <p> {if isset($pec)}<h4>PEC: </h4> {$pec} {/if}</p>
        </span>
    </div>
        <br>
</div>