<?php
require "top_and_bottom.php";

class View {

function __construct($table, $fields, $cur_page, $total_pages) {
	print_top('Тестовое задание BeeJee', 'Список задач');
?>
		<!-- Sorting form -->
	<p> </p>
	<form name="form_sort" method="GET" action="controller.php">
		Сортировать по столбцу&nbsp;&nbsp;
		<select name="field">
			<?php  // Setting fields in drop-down list and activate the previously selected
			foreach($fields as $key => $val){
				if ($_GET['field'] == $key) $opt = '<option selected';
				else $opt = '<option';
				echo $opt.' value="'.$key.'">'.$val.'</option>';
			}?>
		</select>
		&nbsp;&nbsp;по&nbsp;
		<select name="direction">
			<?php  // Setting drop-down list for sorting direction
			if ($_GET['direction'] == 'asc') $opt = '<option selected'; else $opt = '<option';
			echo $opt.' value="asc">возрастанию</option>';					
			if ($_GET['direction'] == 'desc') $opt = '<option selected'; else $opt = '<option';
			echo $opt.' value="desc">убыванию</option>';
			?>
		</select>
		&nbsp;&nbsp;
		<input type="hidden" name="page" value = <? echo $cur_page; ?>> <!-- to save current page number -->
		<input type="submit" value="Применить сортировку">
	</form>	
	<p> </p>
		
		<!-- Generating the main table -->
	<table border="1" cellpadding="4" cellspacing="0"><thead><tr>	
	<?php
	foreach($fields as $key => $val){		// table headers
		echo '<td align="center"><b>'.$val.'</b></td>';
	}
	if ($_SESSION['access'] == 'admin') echo '<td> </td>';
	echo '</tr></thead><tbody>';
	echo '<script>let emails=[]; let texts=[]; let statuses=[];</script>';
	for ($i=0; $i<count($table); $i++){		// table body
		echo '<tr><td>'.$table[$i]['username'].'</td><td>'.$table[$i]['email'].'</td><td>'.$table[$i]['text'].'</td><td>';
		switch($table[$i]['flag_status']) {
			case 0: echo 'Новая задача'; break;
			case 1: echo 'Отредактировано администратором'; break;
			case 2: echo 'Выполнено'; break;
			case 3: echo 'Выполнено. Отредактировано администратором'; break;
		}
		echo '</td>';
		if ($_SESSION['access'] == 'admin'){
			echo '<td><a href="" onClick="fillForEditing('.$i.'); return false">Редактировать</a></td>';
			echo '<script>';
			echo 'emails['.$i.'] = "'.$table[$i]['email'].'";';
			echo 'texts['.$i.'] = "'.$table[$i]['text'].'";';
			echo 'statuses['.$i.'] = "'.$table[$i]['flag_status'].'";';
			echo '</script>';
		}
		echo '</tr>';
	}
	echo '</tbody></table><br>';
	
		// Display Pagination links
	if ($total_pages > 1) {
		echo 'Страницы&nbsp;&nbsp;';
		for ($i=1; $i<=$total_pages; $i++){
			if ($i == $cur_page) echo $i.'&nbsp;&nbsp;';
			else echo '<a href= ./controller.php?field='.$_GET['field'].'&direction='.$_GET['direction'].'&page='.$i.'>'.$i.'</a>&nbsp;&nbsp;';
		}
	}
	?>	

	<script>
		<!-- Function displays hidden blocks when buttons are pressed -->
		function showBlock(numBlock){  
			document.getElementById("block"+numBlock).style.display = "block";
		}
		<!-- Function set flag in checkbox Job Done -->
		function setChecked(){
			document.getElementById("edited").checked = true;
		}
		<!-- Function put data into editing form from massives -->
		function fillForEditing(index){
			document.getElementById("areaForEdit").value = texts[index];			
			document.getElementById("email").value = emails[index];			
			if (statuses[index] > 1) document.getElementById("flag_done").checked = true;
			else document.getElementById("flag_done").checked = false;
			if ((statuses[index] == 1) || (statuses[index] == 3)) document.getElementById("edited").checked = true;
			else document.getElementById("edited").checked = false;
			showBlock(1);
		}
	</script>

		<!-- Form for editing record -->
	<form name="form_edit" method="POST" action="controller.php">		
		<input type="hidden" name="type" value = "edit_task">
		<div id="block1" style="display: none; background-color: #CEECF5; padding: 10px;">
			&nbsp;
			E-Mail: <input type="text" id="email" name="email" readonly><br><br>
			Редактирование задачи: <br>
			<textarea rows="6" cols="63" name="text" id="areaForEdit" onChange="setChecked()"></textarea><br><br>
			<input type="checkbox" name="flag_done" id="flag_done">Выполнено&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Сохранить">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="flag_edited" id="edited" onclick="return false">Задача редактировалась
		</div>
	</form>
	
		<!-- Form for adding a new record -->
	<p>&nbsp;</p>
	<form name="form_add" method="POST" action="controller.php">
		<input type="hidden" name="type" value = "add_task">
		<input type="button" value="Добавить задачу" onClick="showBlock(2)">
		<div id="block2" style="display: none; background-color: #F2F5A9; padding: 10px;">
			Имя: <input type="text" name="username">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			E-Mail: <input type="text" name="email" required>*<br><br>
			Текст задачи: <br>
			<textarea rows="6" cols="63" name="text"></textarea><br><br>
			<input type="submit" value="Сохранить">
		</div>
	</form>
	<p>&nbsp;</p>

	<?php	// Redirect to login page or Logout
	if ($_SESSION['access'] == 'admin') {
		echo '<form name="form_logot" method="POST" action="controller.php">';
		echo '<input type="hidden" name="type" value = "logout">';
		echo '<input type="submit" value="Выйти из Администратора">';
		echo '</form>';
	} else{
		echo '<form name="form_login" method="POST" action="login.php">';
		echo '<input type="submit" value="Страница входа">';
		echo '</form>';
	}
	print_bottom();
	
}	

}
?>