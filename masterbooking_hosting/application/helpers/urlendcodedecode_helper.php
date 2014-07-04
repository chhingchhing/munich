<?php

// Helper: application/helpers/urlendcodedecode_helper.php
function base64url_encode($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data, $key = false) {
  $decode = base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
  if($key == false){
  	return $decode;
  }else{
  	return preg_replace(sprintf('/%s/', $key), '', $decode);  	
  }
}