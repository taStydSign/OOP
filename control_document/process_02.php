<?	include '../script/config_database.php';
$chk_log_ = mysql_query("SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE '".$_POST['id']."' AND index_control LIKE '2' LIMIT 0, 1");

$chk_log = mysql_fetch_array($chk_log_);

if(mysql_num_rows($chk_log_) != 1) {
	//Sub query string
	$sub_query = 'INSERT INTO dex2_new_document_control ';
	$sub_query .= '(`id_doc1`, `index_control`, `status`, `no`, `date`, `attribute`) VALUE ';
	$sub_query .= '("'.$_POST['id'].'", "2", ';
		if($_POST['status_send'] == 'on') { $sub_query .= '"END"'; }
		else { $sub_query .= '"WAITE"'; }
	$sub_query .= ', "-", NOW(), "';
	
			if($_POST['rdo_01'] == 'on') { $sub_query .= '- มีผู้รับผิดชอบชัดเจน'; }
			else {
				$sub_query .= '- ไม่มีผู้รับผิดชอบชัดเจน'; 
				if($_POST['rdo_02'] == 'on') { $sub_query .= '<BR>- ผอ. กกล. อยู่'; }	
				else {
					$sub_query .= '<BR>- ผอ. กกล. ไม่อยู่';
					if($_POST['slc_01']) { $sub_query .= '<BR>- ให้'.$_POST['slc_01'].' รัษาการแทน <BR>'; }
			}	}
		
	$sub_query .= '")';
	//Sub query string
	
	//Main query string
	if($_POST['rdo_01'] == 'on') {
		$_POST['rdo_02'] = '';
		$_POST['slc_01'] = '';
	} else {
		if($_POST['rdo_02'] == 'on') {
			$_POST['slc_01'] = '';
		}
	}
	
	$str_query = 'INSERT INTO dex2_new_document_02 ';
	$str_query .= '(`id_doc1`, `rdo_01`, `rdo_02`, `slc_01`, `rdo_03`, `comment`, `date_create`, `date_save`) VALUE (';
	$str_query .= '"'.$_POST['id'].'" , "'.$_POST['rdo_01'].'", "'.$_POST['rdo_02'].'", "'.$_POST['slc_01'].'", "'.$_POST['rdo_03'].'", "'.$_POST['comment'].'", NOW(), NOW()';
	$str_query .= ')';
	//Main query string

} else {
	//Sub query string
	$sub_query = 'UPDATE dex2_new_document_control SET ';
	$sub_query .= '`status` = "';
		if($_POST['status_send'] == 'on') { $sub_query .= 'END'; } else { $sub_query .= 'WAITE'; }
	$sub_query .= '", ';
	$sub_query .= '`date` = NOW(), ';
	$sub_query .= '`attribute` = "';
	if($_POST['rdo_01'] == 'on') { $sub_query .= '- มีผู้รับผิดชอบชัดเจน'; }
	else {
		$sub_query .= '- ไม่มีผู้รับผิดชอบชัดเจน'; 
		if($_POST['rdo_02'] == 'on') { $sub_query .= '<BR>- ผอ. กกล. อยู่'; }	
		else {
			$sub_query .= '<BR>- ผอ. กกล. ไม่อยู่';
			if($_POST['slc_01']) { $sub_query .= '<BR>- ให้'.$_POST['slc_01'].' รัษาการแทน <BR>'; }
	}	}
	$sub_query .= '" WHERE id_doc1 LIKE "'.$_POST['id'].'" AND index_control LIKE "2" LIMIT 1';
	//Sub query string


	//Main query string
	if($_POST['rdo_01'] == 'on') {
		$_POST['rdo_02'] = '';
		$_POST['slc_01'] = '';
	} else {
		if($_POST['rdo_02'] == 'on') {
			$_POST['slc_01'] = '';
		}
	}

	$str_query = 'UPDATE dex2_new_document_02 SET';
	$str_query .= '`rdo_01` = "'.$_POST['rdo_01'].'", `rdo_02` = "'.$_POST['rdo_02'].'", `slc_01` = "'.$_POST['slc_01'].'", `rdo_03` = "'.$_POST['rdo_03'].'", `comment` = "'.$_POST['comment'].'", `date_save` = NOW()';
	$str_query .= ' WHERE id_doc1 LIKE "'.$_POST['id'].'" LIMIT 1';
	//Main query string
}

if($_POST['status_send'] == 'on') {
	//Edit doc1
	if($_POST['rdo_01'] == 'on') {
		mysql_query("UPDATE dex2_new_document_01 SET `index_control` = '4' WHERE id LIKE '".$_POST['id']."' LIMIT 1");
	} else {
		mysql_query("UPDATE dex2_new_document_01 SET `index_control` = '3' WHERE id LIKE '".$_POST['id']."' LIMIT 1");
	}
	//Edit doc1
}

mysql_query($sub_query);
mysql_query($str_query);
echo $str_query;
?>
<script language="javascript">
window.location='../home/';
</script>