<?php
if(strlen($password)<5)
		array_push($errorCollector, $errors[5]);
	if(strlen($password)>16)
		array_push($errorCollector, $errors[6]);