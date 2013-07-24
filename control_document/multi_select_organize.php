<?	include '../script/config_database.php';

	$multi_select = new multi_select;
	$multi_select->set_id($_GET['id']);
	$multi_select->set_query('SELECT * FROM departments WHERE parent_id LIKE "'.$_GET['parent_id'].'" ');
	$multi_select->set_odata(@$_GET['old_data']);
	$multi_select->get_multi_select();
?>