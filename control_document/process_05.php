<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '5' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

	$ref_doc2 = mysql_fetch_array(mysql_query("SELECT rdo_01, rdo_02 FROM dex2_new_document_04 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1"));

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$str_query = 'INSERT INTO dex2_new_document_05 (`id_doc1`, `rdo_01`, `rdo_02`, `txta_01`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['rdo_01'].'", "'.$_POST['rdo_02'].'", "'.$_POST['txta_01'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "5", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "';
		if($_POST['rdo_01'] == 'on') { $sub_query .= '- รอง ผอ. สท. สมคิด สมศรี อยู่'; } else if($_POST['rdo_01'] != '') { $sub_query .= '- รอง ผอ. สท. สมคิด สมศรี ไม่อยู่'; } $sub_query .= '<BR>';
		if($_POST['rdo_02'] == 'on') { $sub_query .= '- รอง ผอ. สท. สามารถชาย จอมวิญญา อยู่'; } else if($_POST['rdo_02'] != '') { $sub_query .= '- รอง ผอ. สท. สามารถชาย จอมวิญญา ไม่อยู่';} 
	$sub_query .= '")';
	//Sub query string	
	
} else { 
	//Main query string
	$str_query = 'UPDATE dex2_new_document_05 SET `rdo_01` = "'.$_POST['rdo_01'].'", `rdo_02` = "'.$_POST['rdo_02'].'", `txta_01` = "'.$_POST['txta_01'].'", `date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `attribute` = "';
		if($_POST['rdo_01'] == 'on') { $sub_query .= '- รอง ผอ. สท. สมคิด สมศรี อยู่'; } else if($_POST['rdo_01'] != '') { $sub_query .= '- รอง ผอ. สท. สมคิด สมศรี ไม่อยู่'; } $sub_query .= '<BR>';
		if($_POST['rdo_02'] == 'on') { $sub_query .= '- รอง ผอ. สท. สามารถชาย จอมวิญญา อยู่'; } else if($_POST['rdo_02'] != '') { $sub_query .= '- รอง ผอ. สท. สามารถชาย จอมวิญญา ไม่อยู่';} 

	$sub_query .= '", `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "5" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
	$upd_doc1 = 'UPDATE dex2_new_document_01 SET `index_control` = "';
		if($_POST['rdo_01'] == 'on' || $_POST['rdo_02'] == 'on') $upd_doc1 .= '6';
		else $upd_doc1 .= '8';
	$upd_doc1 .= '" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1';
	mysql_query($upd_doc1);
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
mysql_query($sub_query);
mysql_query($str_query);

?>
<script language="javascript">
window.location='../home/';
</script>