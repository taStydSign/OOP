<? $old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_11 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); ?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>กลั่นกรอง/วิเคราะห์เอกสารเสนอ ผอ.สำนัก/กอง ลงนาม</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">


<? if($form_type != 'VIEW') { ?><form method='post' action='process_11.php'><? } ?>
		<input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
		<tr style='display:none;'>
			<th style='width:240px;'>ผอ. กกล.</th>
            <td>
                <input type='radio' name='rdo_01' value='on' <? if($old_data['rdo_01'] == 'on' || !$old_data['rdo_01']) { echo 'checked'; } ?> onclick='set_gear("02", $(this).val());'/> อยู่ 
                <input style='margin-left:20px;' type='radio' name='rdo_01' value='off'  <? if($old_data['rdo_01'] == 'off') { echo 'checked'; } ?> onclick='set_gear("02", $(this).val());'/> ไม่อยู่
                    <input type='hidden' id='gear_02' />
            </td>
        </tr>
        <tr id='sector_02'>
            <th>ผู้รักษาการแทน</th>
            <td>
                <select name='slc_01' id='slc_01'>
                    <option value=''>เลือกผู้รักษาการแทน</option>
                    <option>รอง ผอ. สท. สมคิด สมศรี</option>
                    <option>รอง ผอ. สท. สามารถชาย จอมวิญญา</option>
                </select>
            </td>
            
            
            
    	<tr>
        	<th style='width:240px;' valign="top">หมายเหตุ</th>
            <td><textarea name='comment' style='width:500px; height:60px;'><?=$old_data['comment'];?></textarea></td>
        </tr>
        <? if($old_data['date_save'] != '0000-00-00 00:00:00' && $old_data['date_save']) { ?>
    	<tr>
    	  <th>วันที่</th>
    	  <td>
          	บันทึกล่าสุด : <?=$old_data['date_save'];?>
          </td>
  	  </tr>
      <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
			<td>
          		<? if($form_type != 'VIEW') { ?><input type='submit' value='บันทึก' class='btn_style_01'><? } ?>
				<input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/";'>
                <? if($doc1_dtl['index_control'] == 11) { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on'> ส่งไปยังขั้นตอนถัดไป
                <? } ?>
			</td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?></form><? } ?>


</td></tr>
</table>

<script language="javascript">
$(function(){
	$('#sector_02').hide();
	
	
	set_gear('01', '<?=$old_data['rdo_01'];?>');
	set_gear('02', '<?=$old_data['rdo_02'];?>');
	$('#slc_01').val("<?=$old_data['slc_01'];?>");
});



	function set_gear(id, value) {
		$('#gear_'+id).val(value);
		set_sector();
	}

	function set_sector() {
		
		//gear_01 = $('#gear_01');		
		gear_02 = $('#gear_02');
		if(gear_02.val() == 'off') {
			$('#sector_02').show();
		} else {
			$('#sector_02').hide();
		}
/*
		if(gear_01.val() == 'off') {
		} else {
			$('#sector_02').hide();
		}
		/**/
	}

</script>