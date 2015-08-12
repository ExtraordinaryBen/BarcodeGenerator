<?php
include('bcpdf.php');

$form_errors = array();
$form_errorlist = false;



function add_error($error){
	global $form_errorlist, $form_errors;
	$form_errorlist = true;
	$form_errors[] = $error;
}


$value = &$_GET;

if(isset($value['submit']))
  include('table.php');	
else
  include('bcform.php');


?>