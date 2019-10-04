<?php
require "top_and_bottom.php";
require "config.php";
print_top('Тестовое задание BeeJee', 'Авторизация');

session_start();
$_SESSION['access'] = 'user';	// define access level
$config = new Config();
if (isset($_POST['login']))		// if auth is successful then we grant admin access level
	if ($config->check_authorization($_POST['login'], md5($_POST['password']))) $_SESSION['access'] = 'admin';
		else echo '<h4>Неверный логин или пароль!</h4>';

// authorization form
echo '<form name="authorization" method="POST">';
echo 'Логин:&nbsp;&nbsp;&nbsp;<input type="text" name="login" required><br><br>';
echo 'Пароль: <input type="password" name="password" required><br><br>';
echo '<input type="submit" value="Войти">';
echo '</form>';

print_bottom();

if ($_SESSION['access'] == 'admin') {
	header("Location: controller.php");
	exit;
}
?>
