<?	include '../script/config_database.php';

$index_control = ($_POST['chk_form'] == 'true')?9.5:7;
$tbl_database = ($_POST['chk_form'] == 'true')?"new_document_95":"new_document_07";

$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '".$index_control."' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$set_date = ($_POST['date_year']-543).'-'.$_POST['date_month'].'-'.$_POST['date_day'];
	$str_query = 'INSERT INTO dex2_'.$tbl_database.' (`id_doc1`, `txta_01`, `txta_02`, `mslc_01`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['txta_01'].'", "'.$_POST['txta_02'].'", "'.$_POST['mslc_01'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "'.$index_control.'", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "'.$_POST['txt_01'].'", NOW(), "-")';
	//Sub query string	
	
} else { 
	//Main query string
	$set_date = ($_POST['date_year']-543).'-'.$_POST['date_month'].'-'.$_POST['date_day'];
	$str_query = 'UPDATE dex2_'.$tbl_database.' SET `txta_02` = "'.$_POST['txta_02'].'", `txta_01` = "'.$_POST['txta_01'].'",  `mslc_01` = "'.$_POST['mslc_01'].'", `date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `no` = "'.$_POST['txt_01'].'", `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `date` = NOW(), `attribute` = "';
		if($_POST['mslc_01']) {
			$sub_query .= "- เลือก (";
			$sub_query .= substr_replace(str_replace('|||', ', ', $_POST['mslc_01']), '', -2);
			$sub_query .= ") <BR>";
		}
	$sub_query .= '" WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "'.$index_control.'" LIMIT 1';
	//Sub query string
}


if($_POST['status_send'] == 'on') {
	$chk_lv5 = mysql_fetch_array(mysql_query("SELECT rdo_01 FROM dex2_new_document_05 WHERE id_doc1 LIKE '".$_POST['id']."' LIMIT 0, 1"));
	if($chk_lv5['rdo_01'] == 'off' || $_POST['chk_form'] == 'true') {
		$upd_doc1 = 'UPDATE dex2_new_document_01 SET `index_control` = "10" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1';
	} else if($chk_lv5['rdo_01'] == 'on') {
		$upd_doc1 = 'UPDATE dex2_new_document_01 SET `index_control` = "8" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1';
	}
	mysql_query($upd_doc1);
}

// มีใน log ไหม
	// มี INSERT
	// ไม่มี UPDATE

// Send เลยไหม?
	// Y : UPDATE doc1 index_control = 10


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