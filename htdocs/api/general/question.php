<?php
	if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK', '1');			// Do not check anti CSRF attack test
	if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL', '1');		// Do not check anti POST attack test
	if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU', '1');		// If there is no need to load and show top and left menu
	if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML', '1');		// If we don't need to load the html.form.class.php
	if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX', '1');       // Do not load ajax.lib.php library
	if (! defined("NOLOGIN"))        define("NOLOGIN", '1');				// If this page is public (can be called outside logged session)

	require '../../main.inc.php';
	require_once DOL_DOCUMENT_ROOT.'/core/class/questionnaire.class.php';
	
	$questionnaire = new Questionnaire($db);
	
	$json = array();
	
	$bankData = $questionnaire->getQuestions();
	
	$status_code = '1';
	$message = 'Question Listing';
		
	$json = array('status_code' => $status_code, 'message' => $message, 'passing_score' => '8', 'question_data' => $bankData);
	
	$headers = 'Content-type: application/json';
	header($headers);
	echo json_encode($json);