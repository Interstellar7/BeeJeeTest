<?php
require ('model.php');
require ('config.php');
require ('view.php');

session_start();
$config = new Config();

// initial parameters
if (count($_GET) == 0) {
	$_GET['field'] = 'username';
	$_GET['direction'] = 'asc';
	$_GET['page'] = 1;
}
$page = $_GET['page']; // current page
if (!isset($_POST['type'])) $_POST['type'] = 'main'; // $_POST['type'] is a switcher
if ($_SESSION['access'] == 'admin') $access = 'admin'; else $access='user'; 
echo 'Уровень доступа: '.$access;

// receive the table and field names
$tbl = get_data($page, $_GET['field'], $_GET['direction'], $config);
$flds = get_fields();
$pages = how_many_pages($config);

// POST event handling and view generation
switch($_POST['type']) {
	case 'main': $view = new View($tbl, $flds, $page, $pages);
		break;
	case 'add_task': {	// create a new task
		$email = $_POST['email'];
		$text = $_POST['text'];
		$text = str_replace('<script>', '', $text);		// it is for safety
		$text = str_replace('</script>', '', $text);
		echo $text;
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			save_new_task($_POST['username'], $email, $text, $config);
			header("Refresh:0");		
		}
		else {
			echo '<script>alert("E-Mail не корректен! Задача не добавлена в базу.")</script>';
			header("Refresh:0");		
		}
	}	break;
	case 'edit_task': {	// edit selected task
		$email = $_POST['email'];
		$text = $_POST['text'];
		$status = 0;
		if (isset($_POST['flag_edited'])) $status += 1;
		if (isset($_POST['flag_done'])) $status += 2;	
		if ($_SESSION['access'] == 'admin') {
			save_changed_task($email, $text, $status, $config);
			header("Refresh:0");		
		}	else {	// redirect to Login page
			header("Location: login.php");		
		}
	} 	break;
	case 'logout': {	// close admin session
		unset($_SESSION['access']);
		session_destroy();
		header("Refresh:0");		
	}	break;
}

?>