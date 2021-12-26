<?php

function preparar_enlace_imprimir($arg){

// funcion para ventana pop-up centrada en la pantalla
$javascript_centrar_imprimir = "<script type=\"text/javascript\">
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
		$logo = find_in_path('impresora.gif');
		$url = generer_url_public('',$arg);

// prepara el enlace completo
		$enlace = $javascript_centrar_imprimir."
<a href=\"javascript:;\" onclick=\"centrarVentana('$url','fotora','scrollbars=yes,resizable=yes','800','600','true')\" title=\"Printable Version\" class='gh_articletool' style=\"background-image:url('squelettes/igihe_imgs/gh_icons_print.gif');background-repeat:no-repeat;background-position:left top;\">PRINT</a>";
		return $enlace;

}

// la baliza a llamar como #ENVIAR_EMAIL** (importante los dos asteriscos para que funcione el javascript anterior de centrar la ventan por-up)

function balise_IMPRIMIR_DOCUMENTO($p) {

// numero y enlace al art?ulo o breve
  	$_id_article = champ_sql('id_article', $p);
	$arg = "'page=fotora&amp;id_article='.".$_id_article;
	$url = generer_url_public('',$arg);
	if (!$_id_article){
		$_id_breve = champ_sql('id_breve', $p);
		$arg = "'page=imprimir_breve&amp;id_breve='.".$_id_breve;
		$url = generer_url_public('',$arg);
	}
   $p->code ="preparar_enlace_imprimir($arg)";
   $p->statut = 'html';
   return $p;
}

?>