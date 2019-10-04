<?php
	// set table field names
	function get_fields() {
		return array (
			'username' => 'Имя пользователя',
			'email' => 'E-Mail',
			'text' => 'Текст задачи',
			'flag_status' => 'Статус'
		);
	}

	// define how many pagination pages
	function how_many_pages($config) {
		$query = 'select count(*) from '.$config->tablename.';';
		$result_query = mysqli_query($config->link, $query);
		if (!$result_query) printf("%s\n", mysqli_error($config->link));
		$num_records = mysqli_fetch_row($result_query);
		$records = $num_records[0];
		$pages = ceil($records / $config->records_per_page);
		return $pages;
	}

	// get data from the database
	function get_data($page, $sortingField, $sortingDirection, $config) {	
		$start_record = ($page-1)*$config->records_per_page;		
		$query = 'select * from '.$config->tablename.' order by '.$sortingField.' '.$sortingDirection.' limit '.$start_record.', '.$config->records_per_page.';';
		$result_query = mysqli_query($config->link, $query);
		if (!$result_query) printf("%s\n", mysqli_error($config->link));
		$data = array(); 
		$i = 0;
		while ($row = mysqli_fetch_assoc($result_query)) {
			$data[$i] = $row;
			$i++;
		}
		return $data;		
	}
	
	// save a new task in the database
	function save_new_task($username, $email, $text, $config) {
		$query_add = 'insert into '.$config->tablename.'(username, email, text) values("'.$username.'","'.$email.'","'.$text.'");';
		$result_query_add = mysqli_query($config->link, $query_add);		
		if ($result_query_add != true) echo '<script>alert("Сбой при записи новой задачи в базу (((")</script>';
		else echo '<script>alert("Задача успешно добавлена в базу")</script>';
	}

	// save a changed task in the database
	function save_changed_task($email, $text, $status, $config) {
		$query_save = 'update '.$config->tablename.' set text = "'.$text.'", flag_status = "'.$status.'" where email = "'.$email.'";';		
		echo $query_save;
		$result_query_save = mysqli_query($config->link, $query_save);		
		if ($result_query_save != true) echo '<script>alert("Сбой при сохранении задачи в базу (((")</script>';
	}

?>