<?php

function replaceNbspWithSpace($content){
	$string = htmlentities($content, 0, 'utf-8');
	$content = str_replace("&nbsp;", " ", $string);
	$content = html_entity_decode($content);
	return $content;
}

$content = replaceNbspWithSpace("Besoins de l’assemblée (10 min)");
$regx = '/\([\d]{1,2}.min\)/';
$content = preg_replace($regx, "",$content);

echo $content;

