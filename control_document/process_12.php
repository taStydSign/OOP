<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '12' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$str_query = 'INSERT INTO dex2_new_document_12 (`id_doc1`, `txta_01`, `txta_02`, `slc_01`, `mslc_01`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['txta_01'].'", "'.$_POST['txta_02'].'", "'.$_POST['slc_01'].'", "'.$_POST['mslc_01'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "12", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "';
	if($_POST['mslc_01']) {
		$sub_query .= "- เลือก (";
		$sub_query .= substr_replace(str_replace('|||', ', ', $_POST['mslc_01']), '', -2);
		$sub_query .= ")";
	}
	$sub_query .= '")';
	//Sub query string	
	
} else { 
	//Main query string
	$str_query = 'UPDATE dex2_new_document_12 SET `txta_01` = "'.$_POST['txta_01'].'", `txta_02` = "'.$_POST['txta_02'].'", `slc_01` = "'.$_POST['slc_01'].'", `mslc_01` = "'.$_POST['mslc_01'].'", `date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `date` = NOW() ';
		$sub_query .= ', `attribute` = "';
		if($_POST['mslc_01']) {
			$sub_query .= '- เลือก (';
			$sub_query .= substr_replace(str_replace('|||', ', ', $_POST['mslc_01']), '', -2);
			$sub_query .= ')';
		}
		$sub_query .= '"';
	$sub_query .= ' WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "12" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "13" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
}

// มีใน log ไหม
	// มี INSERT
	// ไม่มี UPDATE

// Send เลยไหม?
	// Y : Update doc 1 to 12[index_control]

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