<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '3' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$str_query = 'INSERT INTO dex2_new_document_03 (`id_doc1`, `comment`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['comment'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "3", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "-")';
	//Sub query string	
	
} else { 
	//Main query string
	$str_query = 'UPDATE dex2_new_document_03 SET `comment` = "'.$_POST['comment'].'", `date_save` = NOW()';
	$str_query .= ' WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "3" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
	mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "4" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
		mysql_query('UPDATE dex2_new_document_control SET `status` = "END" WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "3"  LIMIT 1');
}

mysql_query($sub_query);
mysql_query($str_query);
?>
<script language="javascript">
window.location='../home/';
</script>