<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '4' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);


if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$str_query = 'INSERT INTO dex2_new_document_04 (`id_doc1`, `condition`, `comment`, `mslc_01`,  `mslc_02`, `slc_01`, `slc_02`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['rdo_01'].'", "'.$_POST['comment'].'", "'.$_POST['mslc_01'].'",  "'.$_POST['mslc_02'].'", "'.$_POST['slc_01'].'", "'.$_POST['slc_02'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "4", "'; 
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "';
		if($_POST['rdo_01'] == 1) { $sub_query .= '- กรณีเรื่องใหม่/เรื่องที่เป็นนโยบาย '; }
		else if($_POST['rdo_01'] == 2) { $sub_query .= '- กรณีเรื่องเดิม/เรื่องที่มีผู้รับผิดชอบแล้ว/เรื่องทั่วไป '; }
		else if($_POST['rdo_01'] == 3) { $sub_query .= '- กรณีเรื่องเดิมเป็นของกองกลาง'; }
		else if($_POST['rdo_01'] == 4) { $sub_query .= '- กรณีเป็นเรื่องของผู้เชี่ยวชาญ'; }
			$sub_query .= '<BR>';
		if($_POST['slc_01']) {
			$sub_query .= '- '.$_POST['slc_01'].' เป็นผู้กำกับดูแล'; 
			$sub_query .= ' (';
			$sub_query .= substr_replace(str_replace('|||', ', ', $_POST['mslc_01']), '', -2);
			$sub_query .= ') <BR>';
		}
		
		if($_POST['slc_02']) {
			$org_dtl = mysql_fetch_array(mysql_query('SELECT Organize FROM dex2_tblorganize WHERE OrganizeId LIKE "'.$_POST['slc_02'].'" LIMIT 0, 1'));
			$sub_query .= '- เลือก'.$org_dtl['Organize'].' ('.substr_replace(str_replace('|||', ', ', $_POST['mslc_02']), '', -2).')';
			$sub_query .= '<BR>';
		}
		$sub_query .= '")';
	//Sub query string
} else { 
	//Main query string
	$str_query = 'UPDATE dex2_new_document_04 SET ';
	$str_query .= '`condition` = "'.$_POST['rdo_01'].'", ';
	$str_query .= '`slc_01` = "'.$_POST['slc_01'].'", ';
	$str_query .= '`slc_02` = "'.$_POST['slc_02'].'", ';
	$str_query .= '`comment` = "'.$_POST['comment'].'", ';
	$str_query .= '`mslc_01` = "'.$_POST['mslc_01'].'", ';
	$str_query .= '`mslc_02` = "'.$_POST['mslc_02'].'", ';
	$str_query .= '`date_save` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `status` = "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `attribute` = "';
		if($_POST['rdo_01'] == 1) { $sub_query .= '- กรณีเรื่องใหม่/เรื่องที่เป็นนโยบาย '; }
		else if($_POST['rdo_01'] == 2) { $sub_query .= '- กรณีเรื่องเดิม/เรื่องที่มีผู้รับผิดชอบแล้ว/เรื่องทั่วไป '; }
		else if($_POST['rdo_01'] == 3) { $sub_query .= '- กรณีเรื่องเดิมเป็นของกองกลาง'; }
		else if($_POST['rdo_01'] == 4) { $sub_query .= '- กรณีเป็นเรื่องของผู้เชี่ยวชาญ'; }
			$sub_query .= '<BR>';
		if($_POST['slc_01']) {
			$sub_query .= '- '.$_POST['slc_01'].' เป็นผู้กำกับดูแล'; 
			$sub_query .= ' (';
			$sub_query .= substr_replace(str_replace('|||', ', ', $_POST['mslc_01']), '', -2);
			$sub_query .= ') <BR>';
		}
		
		if($_POST['slc_02']) {
			$org_dtl = mysql_fetch_array(mysql_query('SELECT Organize FROM tblorganize WHERE OrganizeId LIKE "'.$_POST['slc_02'].'" LIMIT 0, 1'));
			$sub_query .= '- เลือก'.$org_dtl['Organize'].' ('.substr_replace(str_replace('|||', ', ', $_POST['mslc_02']), '', -2).')';
			$sub_query .= '<BR>';
		}
		
	$sub_query .= '", `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "4" LIMIT 1';
	

	//Sub query string
}


if($_POST['status_send'] == 'on' && $_POST['rdo_01']) {
	if($_POST['rdo_01'] == '1') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "5" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
	} else if($_POST['rdo_01'] == '2') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "10" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
	} else if($_POST['rdo_01'] == '3') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "13" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
	} else if($_POST['rdo_01'] == '4') {
		mysql_query('UPDATE dex2_new_document_01 SET `index_control` = "8" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1');	
	}
}

mysql_query($sub_query);
mysql_query($str_query);

?>
<script language="javascript">
window.location='../home/';
</script>