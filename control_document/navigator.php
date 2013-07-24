<?
	$_GET['form_no'] = (empty($_GET['form_no']) == 1)?'':$_GET['form_no'];
	$_GET['form_no'] = ($_GET['form_no'])?$_GET['form_no']:1;
	$control_list = mysql_fetch_array(mysql_query('SELECT * FROM dex2_new_document_control WHERE id_doc1 LIKE "'.$_GET['id'].'" LIMIT 0, 1'));
	for($i=1; $i<=13; $i++) {
			$acc_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_new_access_layer_detail WHERE id LIKE "'.$i.'" LIMIT 0, 1'));	
			if($i<$_GET['form_no']) { //ฟอร์มก่อนหน้า ?>
					<img src="../image/route/<?=$i;?>_pass.jpg" width="36" height="36" class="vtip" title="<?=$acc_dtl['name'];?>" style='cursor:pointer;' onclick='window.location="<?='index.php?form_no='.$i.'&id='.$_GET['id'];?>"	'/>
			<? } else if($i == $_GET['form_no']) { // ฟอร์มนี้ ?>
					<img src="../image/route/<?=$i;?>_here.jpg" width="36" height="36" class="vtip" title="<?=$acc_dtl['name'];?>" />
			<? } else { //กรณีที่ยังไม่ถึง ?>
					<img src="../image/route/<?=$i;?>.jpg" width="36" height="36" class="vtip" title="<?=$acc_dtl['name'];?>" />
			<? }
	}
?>
