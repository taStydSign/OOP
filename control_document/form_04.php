<? $old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_04 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); ?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>เลือกหน่วยงาน</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php'; ?>
</td></tr>
<tr><td colspan="2">


<?
	$_GET['tform'] = (!empty($_GET['tform']))?$_GET['tform']:'';
	if($form_type != 'VIEW') { ?> <form method='post' action='process_04.php'> <? } ?>
    <input type='hidden' name='tform' value='<?=$_GET["tform"];?>'>
    <input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
    	<tr>
        	<th valign="top" style='width:240px;'>เงื่อนไข</th>
            <td><input type="radio" name="rdo_01" id='rdo_01_1' value="1" onclick='set_condition(1);' checked/> กรณีเรื่องใหม่/เรื่องที่เป็นนโยบาย 
              <input type="radio" name="rdo_01" id='rdo_01_2' value="2" onclick='set_condition(2);'/> กรณีเรื่องเดิม/เรื่องที่มีผู้รับผิดชอบแล้ว/เรื่องทั่วไป 
              <input type="radio" name="rdo_01" id='rdo_01_3' value="3"  onclick='set_condition(3);'/> กรณีเรื่องเดิมเป็นของกองกลาง
              <input type="radio" name="rdo_01" id='rdo_01_4' value="4"  onclick='set_condition(4);'/> กรณีเป็นเรื่องของผู้เชี่ยวชาญ
			</td>
        </tr>
    	<tr id='sector_01'>
    	  <th>รอง ฯ ผอ. สท. ที่กำกับดูแล</th>
		<td>
    	  	<select name='slc_01' id='slc_01'>
                <option value=''>รองฯ ผอ. สท. ที่กำกับ ดูแล</option>
                <option>รอง ผอ. สท. สมคิด สมศรี</option>
                <option>รอง ผอ. สท. สามารถชาย จอมวิญญา</option>
  	    	</select>
  	    </td>
  	  </tr>
    	<tr id='sector_02'>
    	  <th>เลือก สำนัก/กอง/กลุ่มรายงานตรง</th>
    	  <td id='org_sub_sector_01'>กรุณาเลือก รองฯ ผอ. สท. ที่กำกับดูแล </td>
  	  </tr>
    	<tr id='sector_03'>
    	  <th>เลือก สำนัก/กอง/กลุ่มรายงานตรง</th>
    	<td>
    		<? $org_list_ = mysql_query("SELECT * FROM departments WHERE parent_id LIKE '0' "); ?>
			<select name='slc_02' id='slc_02' onchange="org_sub_call_02('mslc_02', $(this).val());">
				<option value=''>- - กรุณาเลือก สำนัก/กอง/กลุ่มรายงานตรง - -</option>
				<?
					for($i=0; $org_list = mysql_fetch_array($org_list_);) { 
					$child_list = mysql_query("SELECT * FROM departments WHERE parent_id LIKE '".$org_list['dep_id']."'");
				?>
					<option value='<?=$org_list['dep_id'];?>'><?=$org_list['departments'];?></option>
				<? } ?>
			</select>
		</td>
  	  </tr>
    	<tr id='sector_04'>
    	  <th>เลือก กลุ่ม ฝ่าย</th>
    	  <td id='org_sub_sector_02'>กรุณาเลือก สำนัก/กอง/กลุ่มรายงานตรงก่อนการดำเนินการ </td>
  	  </tr>
    	<tr>
    	  <th valign="top">หมายเหตุ</th>
    	  <td> 
          <textarea name='comment' style='width:500px; height:60px;'><?=$old_data['comment'];?></textarea>
          </td>
  	  </tr>
        <? if($old_data['date_save'] != '0000-00-00 00:00:00' && $old_data['date_save']) { ?>
    	<tr>
    	  <th>วันที่</th>
    	  <td> บันทึกล่าสุด :
    	    <?=$old_data['date_save'];?></td>
  	  </tr>
      <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
    	  <td>
			<? if($form_type != 'VIEW') { ?><input type='submit' value='บันทึก' class='btn_style_01' /><? } ?>
    	    <input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/";' />
    	    <? if($doc1_dtl['index_control'] == 4) { ?>
    	    <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on' />
    	    ส่งไปยังขั้นตอนถัดไป
    	    <? } ?></td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?></form> <? } ?>


</td></tr>
</table>


<script language="javascript">
$(function(){
	$('#rdo_01_<?=$old_data['condition'];?>').attr('checked', 'checked');
	set_condition(<?=$old_data['condition']=($old_data['condition'])?$old_data['condition']:1;?>);

	$('select[name=slc_01]').val("<?=$old_data['slc_01'];?>");

	<? if($old_data['mslc_01']) { ?>
			org_sub_call_01('mslc_01', '<?=$old_data['mslc_01'];?>');
	<? } ?>
	<? if($old_data['slc_02']) {?>
			$('#slc_02').val(<?=$old_data['slc_02'];?>);
			org_sub_call_02('mslc_02', '<?=$old_data['slc_02'];?>', '<?=$old_data['mslc_02'];?>');
	<? } /* */?>

});

function set_condition(value) {
	
	if(value == 1) {
		$('#sector_01').show();
		$('#sector_02').hide();
		$('#sector_03').hide();
		$('#sector_04').hide();
			$('#slc_01').val('');
			$('#org_sub_sector_01').html('กรุณาเลือก รองฯ ผอ. สท. ที่กำกับดูแล');
			$('#slc_02').val('');
			$('#org_sub_sector_02').html('กรุณาเลือก สำนัก/กอง/กลุ่มรายงานตรงก่อนการดำเนินการ');
	} else if(value == 2) {
		$('#sector_01').hide();
		$('#sector_02').show();
		$('#sector_03').hide();
		$('#sector_04').hide();
			$('#slc_02').val('');
			$('#org_sub_sector_02').html('กรุณาเลือก สำนัก/กอง/กลุ่มรายงานตรงก่อนการดำเนินการ');
		org_sub_call_01('mslc_01');
	} else if(value == 3) {
		$('#sector_01').hide();
		$('#sector_02').hide();
		$('#sector_03').show();
		$('#sector_04').show();
			$('#slc_01').val('');
			$('#org_sub_sector_01').html('กรุณาเลือก รองฯ ผอ. สท. ที่กำกับดูแล');
	} else if(value==4) {
		$('#sector_01').hide();
		$('#sector_02').hide();
		$('#sector_03').hide();
		$('#sector_04').hide();
	}
}


function org_sub_call_01(id, old_data) {
	urlLink = 'multi_select.php';
	urlLink += '?id='+id;
		if(old_data) { urlLink += '&old_data='+old_data; }
	<?
		$org_list = array(21, 26, 28, 29, 33, 36, 38, 39, 49, 53, 64, 77, 78, 79);
		$mslc_01_qry = "SELECT * FROM departments WHERE (";
			foreach($org_list as $key=>$org_rs) { $mslc_01_qry .= ($key==0)?'':'OR '; $mslc_01_qry .= "dep_id LIKE '".$org_rs."' "; }
		$mslc_01_qry .= ")";
	?>
	urlLink += "&query=<?=$mslc_01_qry;?>";

	urlLink = encodeURI(urlLink);
	$('#org_sub_sector_01').load(urlLink);
	
}


function org_sub_call_02(id, parent_id, old_data) {
	urlLink = 'multi_select_organize.php';
	urlLink += '?id='+id;
	urlLink += '&parent_id='+parent_id;
		if(old_data) { urlLink += '&old_data='+old_data; }
	urlLink = encodeURI(urlLink);
	$('#org_sub_sector_02').load(urlLink);
}
/* */
</script>
