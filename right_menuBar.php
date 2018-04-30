<?php
$select = explode("/", $_SERVER['REQUEST_URI']);
$select = $select[(count($select)-1)];

function selectDisp($name){
	if(strcmp($name, "index.php")==0){
		if(empty($GLOBALS['select']) || strpos($GLOBALS['select'], $name) !== false){
			return "list-group-item-danger";
		}
	}

	if(strpos($GLOBALS['select'], $name) !== false){
		return "list-group-item-danger";
	}
}
?>
				<br><br>
            	<ul class="list-group">
	                <li class="list-group-item active">メニュー</li>
	                <li class="list-group-item <?php printf(selectDisp("index.php")); ?>"><a href="./">機種情報(INFO)</a></li>
	                <li class="list-group-item <?php printf(selectDisp("file_list.php")); ?>"><a href="./file_list.php">カメラ内ファイル</a></li>
	                <li class="list-group-item <?php printf(selectDisp("control.php")); ?>"><a href="./control.php">撮影モード</a></li>
            	</ul>