<?php

function preparar_enlace_enviar($arg){

// funcion para ventana pop-up centrada en la pantalla
$javascript_centrar_enviar = "<script type=\"text/javascript\">

	function centrarVentana(theURL,winName,features, myWidth, myHeight, isCenter) { //v3.0
		if(window.screen)if(isCenter)if(isCenter==\"true\"){
		var myLeft = (screen.width-myWidth)/2;
		var myTop = (screen.height-myHeight)/2;
		features+=(features!='')?',':'';
		features+=',left='+myLeft+',top='+myTop;
	}
	window.open(theURL,winName,features+((features!='')?',':'')+'width='+myWidth+',height='+myHeight);
	}
</script>";

// prepara logo
		$logo = find_in_path('sobre.gif');
		$url = generer_url_public('',$arg);
		
// prepara el enlace completo
		$enlace = $javascript_centrar_enviar."
		<a href=\"javascript:;\" onclick=\"centrarVentana('$url','Enviar_documento','scrollbars=yes,resizable=yes','580','500','true')\" title=''  class=\"gh_articletool\" style=\"background-image:url('squelettes/igihe_imgs/gh_icons_send.gif');background-repeat:no-repeat;background-position:left top;\">SEND</a>";
		return $enlace;

}

// la baliza a llamar como #ENVIAR_EMAIL** (importante los dos asteriscos para que funcione el javascript anterior de centrar la ventan por-up)


function balise_ENVIAR_EMAIL($p) {

	if ($GLOBALS['contexte']['id_breve'] == "") { 
	$arg = "'page=enviar_email_articulo&amp;id_article='.".champ_sql('id_article', $p);
	}
	else {
	$arg = "'page=enviar_email_breve&amp;id_breve='.".champ_sql('id_breve', $p);
	}

   $p->code ="preparar_enlace_enviar($arg)";
   $p->statut = 'html';

   return $p;
}

?>
