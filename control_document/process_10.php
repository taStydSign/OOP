<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND dep_id LIKE '".$_POST['dep_id']."' AND index_control LIKE '10' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$set_date = $_POST['date'];
	$str_query = 'INSERT INTO dex2_new_document_10 (`id_doc1`, `txt_01`, `date`, `comment`, `dep_id`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['txt_01'].'", "'.$set_date.'", "'.$_POST['comment'].'", "'.$_POST['dep_id'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `dep_id`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "'.$_POST['dep_id'].'", "10", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "'.$_POST['txt_01'].'", NOW(), "-")';
	//Sub query string	
	
} else { 
	//Main query string
	$set_date = $_POST['date'];
	$str_query = 'UPDATE dex2_new_document_10 SET `txt_01` = "'.$_POST['txt_01'].'", `date` = "'.$set_date.'", `comment` = "'.$_POST['comment'].'", `date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `no` = "'.$_POST['txt_01'].'", `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND dep_id LIKE "'.$_POST['dep_id'].'" AND index_control LIKE "10" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "11" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
}


mysql_query($sub_query);
mysql_query($str_query);
/**/
?>
<script language="javascript">
window.location='../home/';
</script>