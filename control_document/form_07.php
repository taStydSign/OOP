<?
$old_data_ = "SELECT * FROM dex2_";
if($_GET['form_no'] == 9.5) { $old_data_ .= 'new_document_95'; } else { $old_data_ .= 'new_document_07'; } 
$old_data_ .= " WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1";

	$old_data = mysql_fetch_array(mysql_query($old_data_)); 
	$chk_lv5 = mysql_fetch_array(mysql_query("SELECT rdo_01 FROM dex2_new_document_05 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1"));
?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ลงนาม/ข้อสั่งการ เสนอ ผอ. สท.</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">


<? if($form_type != 'VIEW') { ?> <form method='post' action='process_07.php'> <? } ?>
		<input type='hidden' name='id' value='<?=$_GET["id"];?>'>
        <input type='hidden' name='chk_form' value='<? if($_GET['form_no'] == 9.5) { echo 'true'; } else { echo 'false'; } ?>' />
        

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
        <tr>
            <th valign="top" style='width:240px;'>ข้อสั่งการ รองฯ ผอ. สท.</th>
            <td><textarea name='txta_01' style='width:500px; height:60px;'><?=$old_data['txta_01'];?></textarea></td>
        </tr>
<? if($chk_lv5['rdo_01'] == 'off') { ?>
		<tr>
            <th>เลือกสำนัก / กอง / กลุ่มรายงานตรง</th>
            <td ID='org_sub_sector_01'>แสดงเฉพาะขั้นตอนที่ 7 ลงนาม (เลขารองฯ ผอ.สท.) หรือขั้นตอนที่ 9 ลงนาม (เลขา ผอ.สท.) สามารถส่งได้ทีละหลายสำนัก</td>
		</tr>
<? } ?>
    	<tr>
    	  <th valign="top">หมายเหตุ</th>
    	  <td> 
    	    <textarea name='txta_02' style='width:500px; height:60px;'><?=$old_data['txta_02'];?></textarea>
    	    </td>
  	  </tr>
      
        <? if($old_data['date_save'] != '0000-00-00 00:00:00' && $old_data['date_save']) { ?><tr> <th>วันที่</th> <td> บันทึกล่าสุด : <?=$old_data['date_save'];?></td> </tr> <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
    	  <td>
          	<? if($form_type != 'VIEW') { ?><input type='submit' value='บันทึก' class='btn_style_01' /><? } ?>
    	    <input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/";' />
    	    <?
			$chk_box = ($_GET['form_no'] == 7)?7:9.5;
			if($doc1_dtl['index_control'] == $chk_box) { ?>
    	    <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on' />
    	    ส่งไปยังขั้นตอนถัดไป
    	    <? } ?></td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?></form><? } ?>


</td></tr>
</table>
<script language="javascript">
org_sub_call_01('mslc_01', "SELECT * FROM dex2_tblorganize WHERE ParentId LIKE '0'", "<?=$old_data['mslc_01'];?>");
function org_sub_call_01(id, query, old_data) {
	
	urlLink = 'multi_select.php';
	urlLink += '?id='+id;

	if(query) { urlLink += '&query='+query; }
	if(old_data) { urlLink += '&old_data='+old_data; }
	
	urlLink = encodeURI(urlLink);
	$('#org_sub_sector_01').load(urlLink);
}

</script>