<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '13' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$set_date = $_POST['date'];
	$str_query = 'INSERT INTO dex2_new_document_13 (`id_doc1`, `txt_01`, `date`, `txta_01`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['txt_01'].'", "'.$set_date.'", "'.$_POST['txta_01'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "13", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "-")';
	//Sub query string	
	
} else { 
	//Main query string
	$set_date = $_POST['date'];
	$str_query = 'UPDATE dex2_new_document_13 SET `txt_01` = "'.$_POST['txt_01'].'", `date` = "'.$set_date.'", `txta_01` = "'.$_POST['txta_01'].'", `date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "13" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "END" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
}

// มีใน log ไหม
	// มี INSERT
	// ไม่มี UPDATE

// Send เลยไหม?
	// Y 
		//IF rdo_01 == 1
			//UPDATE doc1 index_control = 10
		//IF rdo_02 == 2
			//UPDATE doc1 index_control = 13
		//IF rdo_03 == 3
			//UPDATE doc1 index_control = 5




/*
echo $sub_query;
echo '<HR>';
echo $str_query;
/**/


mysql_query($sub_query);
mysql_query($str_query);
/**/
?>
<script language="javascript">
window.location='../home/';
</script>