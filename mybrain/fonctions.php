<?php
function shortenUrl($url, $max_size){

	$url = str_ireplace("http://", "", $url);

	if (strlen($url) > $max_size){
		return substr($url, 0, $max_size-3) . "...";
	}
	else{
		return $url;
	}
}
?>