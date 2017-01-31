<form name="aggiungiReferto" enctype="multipart/form-data" id="formUploadReferto"> 
    <br>

    <h3>AGGIUNTA REFERTO</h3>

    <br>

    <br>
    <h5>Seleziona un file pdf da associare all'esame</h5>
   <!-- <input type="hidden" name="controller" value="referto" />
    <input type="hidden" name="task" value="upload" />-->
    <input type="hidden" name="idPrenotazione" value="{$idPrenotazione}"/>
    <input type="hidden" name="idEsame" value="{$idEsame}"/>
    <input type="hidden" name="partitaIva" value="{$partitaIva}"/>
    <input type="hidden" name="medicoEsame" value="{$medicoEsame}"/>    
    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
    <br>
    <input type="file" name="referto" id="refertoPath" accept=".pdf" class="elementiForm custom-file-input required" required/>
    <br>
    
    <span>
        <input type="button" name="upload" value="Upload" id="uploadReferto" />
    </span>
    
    <span>
        <input type="button" value="Annulla" id="annullaAggiungiReferto" />
    </span>
</form>