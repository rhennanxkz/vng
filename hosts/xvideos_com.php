<?php
#xVideos

	$ch = curl_init();
	$timeout = 0;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$pag = curl_exec ($ch);
	curl_close($ch);
	
	preg_match("#flv_url=(.*?)&amp;#", $pag, $resultado);
	preg_match("#<h2>(.*?)<span class=\"duration\">#", $pag, $nome);
	$pag = get_headers(urldecode($resultado['1']));
	
	foreach($pag as $head)
	{
		$pag .= $head."\r\n";
	}

	preg_match("#Content-Length: (.*?)\r\n#", $pag, $tamanho);
	
	$link = urldecode($resultado['1']);
	$filename = trim($nome[1]).".flv";
	$filesize = $tamanho[1];

?>