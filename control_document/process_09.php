<?	include '../script/config_database.php';

$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '9' LIMIT 0, 1");
$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) { 
	//Main Query string
	$set_date = ($_POST['date_year']-543).'-'.$_POST['date_month'].'-'.$_POST['date_day'];
	$str_query = 'INSERT INTO dex2_new_document_09 (`id_doc1`, `rdo_01`, `rdo_02`, `slc_01`, `txta_01`, `txta_02`, `mslc_01`, `date_create`, `date_save`) VALUE ';
	$str_query .= '("'.$_POST['id'].'", "'.$_POST['rdo_01'].'", "'.$_POST['rdo_02'].'", "'.$_POST['slc_01'].'", "'.$_POST['txta_01'].'", "'.$_POST['txta_02'].'", "'.$_POST['mslc_01'].'", NOW(), NOW())';
	//Main Query string
	
	//Sub query string	
	$sub_query  = 'INSERT INTO dex2_new_document_control (`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "9", "';
	if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", "-", NOW(), "';
		if($_POST['rdo_01'] == '1') { $sub_query .= '- ผอ. สท. ว่างปกติ'; } else if($_POST['rdo_02'] == '2') { $sub_query .= '- ผอ. สท. ติดภารกิจ'; } $sub_query .= '<BR>';
		if($_POST['slc_01'] == '1') { $sub_query .= '- ส่งมอบให้ รอง ผอ. สท. '.$_POST['slc_01']; $sub_query .= '<BR>'; }

		if($_POST['rdo_01'] == '1') { $sub_query .= '- ผอ. สท. ว่างปกติ'; } else if($_POST['rdo_02'] == '2') { $sub_query .= '- ผอ. สท. ติดภารกิจ'; } $sub_query .= '<BR>';
		switch($_POST['rdo_01'])
		{
			case "1": $sub_query .= '- ผู้เชี่ยวชาญด้านเด็ก'; break;
			case "2": $sub_query .= '- ผู้เชี่ยวชาญด้านเยาวชน'; break;
			case "3": $sub_query .= '- ผู้เชี่ยวชาญด้านผู้สูงอายุ'; break;
			default:break;
		}
		$sub_query .= '<BR>';
		
		
		$mslc_01_exp = explode('|||', $_POST['mslc_01']);
		if(count($mslc_01_exp) != 1) {
				$sub_query .= ' - (';
					for($i=0; $i < count($mslc_01_exp); $i++) {
					if($mslc_01_exp[$i] != '') {
							$sub_query .= $mslc_01_exp[$i];
						if($mslc_01_exp[$i+1] != '') {
							$sub_query .= ', ';
					}	}	}
				$sub_query .= ')<BR>';
		}

		
	$sub_query .= '")';
	//Sub query string	
	
} else { 
	//Main query string
	$set_date = ($_POST['date_year']-543).'-'.$_POST['date_month'].'-'.$_POST['date_day'];
	$str_query = 'UPDATE dex2_new_document_09 SET `rdo_01` = "'.$_POST['rdo_01'].'", ';
	$str_query .= '`rdo_02` = "'.$_POST['rdo_02'].'", ';
	$str_query .= '`slc_01` = "'.$_POST['slc_01'].'", ';
	$str_query .= '`txta_01` = "'.$_POST['txta_01'].'", ';
	$str_query .= '`txta_02` = "'.$_POST['txta_02'].'", ';
	$str_query .= '`mslc_01` = "'.$_POST['mslc_01'].'", ';
	$str_query .= '`date_save` = NOW()';
	$str_query .= ' WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string

	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET `attribute` = "';
		if($_POST['rdo_01'] == '1') { $sub_query .= '- ผอ. สท. ว่างปกติ'; } else if($_POST['rdo_01'] == '2') { $sub_query .= '- ผอ. สท. ติดภารกิจ'; } $sub_query .= '<BR>';
		if($_POST['slc_01']) { $sub_query .= '- ส่งมอบให้ รอง ผอ. สท. '.$_POST['slc_01']; $sub_query .= '<BR>'; }

		switch($_POST['rdo_01'])
		{
			case "1": $sub_query .= '- ผู้เชี่ยวชาญด้านเด็ก'; break;
			case "2": $sub_query .= '- ผู้เชี่ยวชาญด้านเยาวชน'; break;
			case "3": $sub_query .= '- ผู้เชี่ยวชาญด้านผู้สูงอายุ'; break;
			default:break;
		}
		$sub_query .= '<BR>';
		

		$mslc_01_exp = explode('|||', $_POST['mslc_01']);
		if(count($mslc_01_exp) != 1) {
				$sub_query .= ' - (';
					for($i=0; $i < count($mslc_01_exp); $i++) {
					if($mslc_01_exp[$i] != '') {
							$sub_query .= $mslc_01_exp[$i];
						if($mslc_01_exp[$i+1] != '') {
							$sub_query .= ', ';
					}	}	}
				$sub_query .= ')<BR>';
		}
		
	$sub_query .= '", `status` = "';
		if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }	
	$sub_query .= '", `date` = NOW() WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "9" LIMIT 1';

	//Sub query string
}


if($_POST['status_send'] == 'on') {
	
	if($_POST['rdo_01'] == '1') {
		$upd_doc1 = 'UPDATE dex2_new_document_01 SET `index_control` = "10" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1';
	} else {
		$upd_doc1 = 'UPDATE dex2_new_document_01 SET `index_control` = "9.5" WHERE id LIKE "'.$_POST['id'].'" LIMIT 1';
	}

	mysql_query($upd_doc1);
}

mysql_query($sub_query);
mysql_query($str_query);
/**/
?>
<script language="javascript">
window.location='../home/';
</script>