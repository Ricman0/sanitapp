<div class="header" id="header">

    <img id="logoSanitApp" class='logoBig' src="Immagini/logoSanitApp.png" alt="logoSanitApp">

    {$log}
    {$navigationBar}    <!-- Navigation bar della pagina-->
</div>
<br>
<!-- Main della pagina-->

<div id="main">
    {if isset ($main)}
        {$main}
    {/if}    
</div> 