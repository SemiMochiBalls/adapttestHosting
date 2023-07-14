<?php
function logger ($log){
	if(!file_exists('../log.txt')){
		file_put_contents('../log.txt', '');
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	date_default_timezone_set('Asia/Manila');
	$time = date('H:i, jS F Y', TIME());
	$contents = file_get_contents('../log.txt');
	$contents .="$ip\t$time\t$log\r";
	file_put_contents('../log.txt',$contents);
	
}
?>