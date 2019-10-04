<?php
function print_top($title, $head) {
	echo '<!DOCTYPE html>';
	echo '<html>';
	echo '<head>';
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
	echo '<title>'.$title.'</title>';
	echo '</head>';
	echo '<body>';
	echo '<h2>'.$head.'</h2>';	
}

function print_bottom() {
	echo '</body>';
	echo '</html>';
}

?>