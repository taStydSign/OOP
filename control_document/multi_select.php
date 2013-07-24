<?	
	include '../script/config_database.php';

	$multi_select = new multi_select;
	$multi_select->set_id(@$_GET['id']);
	$multi_select->set_query(@$_GET['query']);
	$multi_select->set_odata(@$_GET['old_data']);
	$multi_select->get_multi_select();
	
	
?>