<?	$old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_09 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); 
		$ref_doc_4 = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_04 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1"));
		echo $ref_doc_4['condition'];
?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ลงนาม/ข้อสั่งการ เลือกสำนัก/กอง/กลุ่มรายงานตรง</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">


<? if($form_type != 'VIEW') { ?><form method='post' action='process_09.php'><? } ?>
	<input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
        <tr>
            <th valign="top" style='width:240px;'>ผอ. สท.</th>
            <td>
            	<input type='radio' name='rdo_01' value='1' onclick='call_subcontent("ON");' <? if($old_data['rdo_01'] == '1' || !$old_data['rdo_01']) { echo 'checked'; } ?>/> ว่าง ปกติ
                <input type='radio' name='rdo_01' value='2' onclick='call_subcontent("OFF");' <? if($old_data['rdo_01'] == '2') { echo 'checked'; } ?>/> ติดภาระกิจ
            </td>
        </tr>
        <tr id='sub_content_1'>
          <th valign="top" style='width:240px;'>ส่งมอบให้รอง ผอ. สท.</th>
          <td><select name='slc_01' id='slc_01'>
            <option value=''>เลือกผู้รักษาการแทน</option>
            <option>รอง ผอ. สท. สมคิด สมศรี</option>
            <option>รอง ผอ. สท. สามารถชาย จอมวิญญา</option>
          </select></td>
        </tr>
        <tr id='sub_content_2'>
          <th>ข้อสั่งการ ผอ. สท.</th>
          <td> <textarea name='txta_01' id='txta_01' style='width:500px; height:60px;'><?=$old_data['txta_01'];?></textarea>  กรณีว่างปกติ  </td>
        </tr>
        <tr id='sub_content_3'>
          <th valign="top" style='width:240px;'>เลือกสำนัก / กอง / กลุ่มรายงานตรง</th>
          <td id='org_sub_sector_01'>กรณีว่างปกติ แสดงเฉพาะขั้นตอนที่ 7 ลงนาม (เลขารองฯ ผอ.สท.) หรือขั้นตอนที่ 9 ลงนาม (เลขา ผอ.สท.) สามารถส่งได้ทีละหลายสำนัก</td>
        </tr>
		<? if($ref_doc_4['condition'] == 4) { 
			?>
			<tr>
				<th>ผู้เชี่ยวชาญ</th>
				<td>
					<input type='radio' name='rdo_02' value='1' <?=($old_data['rdo_02']==1)?'checked="checked"':'';?>> ผู้เชี่ยวชาญด้านเด็ก
					<input type='radio' name='rdo_02' value='2' <?=($old_data['rdo_02']==2)?'checked="checked"':'';?>> ผู้เชี่ยวชาญด้านเยาวชน
					<input type='radio' name='rdo_02' value='3' <?=($old_data['rdo_02']==3)?'checked="checked"':'';?>> ผู้เชี่ยวชาญด้านผู้สูงอายุ
				</td>
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
                <? if($doc1_dtl['index_control'] == 9) { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on' /> ส่งไปยังขั้นตอนถัดไป <? } ?>
            </td>
		</tr>
    </table>
<? if($form_type != 'VIEW') { ?></form><? } ?>


</td></tr>
</table>
<script language="javascript">
$(function(){
	call_subcontent('<?=($old_data['slc_01']==2)?'OFF':'ON';?>');

	$('#slc_01').val("<?=$old_data['slc_01'];?>");
	<? if($old_data['rdo_01'] == '2') { ?>
		call_subcontent('OFF');
	<? } 
			$org_list = array(21, 26, 28, 29, 33, 36, 38, 39, 49, 53, 64, 77, 78, 79);
			$mslc_01_qry = "SELECT * FROM departments WHERE (";
				foreach($org_list as $key=>$org_rs) { $mslc_01_qry .= ($key==0)?'':'OR '; $mslc_01_qry .= "dep_id LIKE '".$org_rs."' "; }
			$mslc_01_qry .= ")";
				/* 
		if($ref_doc_4['condition'] == 4) 
		{
		}
		else { $mslc_01_qry = "SELECT * FROM dex2_tblorganize WHERE ParentId LIKE '0'"; }
				 *
				 */
	?>
	
	org_sub_call_01('mslc_01', "<?=$mslc_01_qry;?>", "<?=$old_data['mslc_01'];?>");
});
function org_sub_call_01(id, query, old_data) {
	
	urlLink = 'multi_select.php';
	urlLink += '?id='+id;

	if(query) { urlLink += '&query='+query; }
	if(old_data) { urlLink += '&old_data='+old_data; }
	
	urlLink = encodeURI(urlLink);
	$('#org_sub_sector_01').load(urlLink);
}

function call_subcontent(value) { 
	if(value == 'ON') {
		$('#sub_content_1').hide();
		$('#sub_content_2').show();
		$('#sub_content_3').show();
	} else if(value == 'OFF') {
		$('#sub_content_1').show();
		$('#sub_content_2').hide();
		$('#sub_content_3').hide();
		
		$('#slc_01').val('');
		$('#txta_01').val('');
	}
}
</script>