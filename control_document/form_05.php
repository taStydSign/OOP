<? $old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_05 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); 

	$ref_doc4 = mysql_fetch_array(mysql_query("SELECT slc_01 FROM dex2_new_document_04 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1"));
	$sec_director = array('รอง ผอ. สท. สมคิด สมศรี', 'รอง ผอ. สท. สามารถชาย จอมวิญญา');
?>

<script language='javascript'>
	$(function(){
		if($('input[type="radio"][name="rdo_01"]:checked').val()=='off')
		{
			$('#set_rdo_02').show();
		}
		
		$('input[type="radio"][name="rdo_01"]').click(function(){
			if($(this).val() == 'on') { $('#set_rdo_02').hide(); $('input[type="radio"][name="rdo_02"]').removeAttr('checked'); }
			else { $('#set_rdo_02').show(); }
		});
	});
</script>


<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>กำหนดสถานะการปฏิบัติงาน</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">

<? 
	$_GET['tform'] = (!empty($_GET['tform']))?$_GET['tform']:'';
	if($form_type != 'VIEW') { ?> <form method='post' action='process_05.php'> <? } ?>
    <input type='hidden' name='tform' value='<?=$_GET["tform"];?>'>
    <input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
        <tr id='set_rdo_01'>
            <th valign="top" style='width:240px;'><?=$sec_director[0];?></th>
            <td>
                <input type="radio" id='rdo_01_on' name="rdo_01" value="on" <? if($old_data['rdo_01'] == 'on') { echo 'checked'; } ?>/> อยู่ 
                <input type="radio" id='rdo_01_off' name="rdo_01" value="off" <? if($old_data['rdo_01'] == 'off') { echo 'checked'; } ?>/>ไม่อยู่/ไม่ว่าง
            </td>
            </tr>
        <tr style='display:none;' id='set_rdo_02'>
            <th style='width:240px;'><?=$sec_director[1];?></th>
            <td>
                <input type="radio" id='rdo_02_on' name="rdo_02" value="on" <? if($old_data['rdo_02'] == 'on') { echo 'checked'; } ?>/> อยู่
                <input type="radio" id='rdo_02_off' name="rdo_02" value="off" <? if($old_data['rdo_02'] == 'off') { echo 'checked'; } ?>/>  ไม่อยู่/ไม่ว่าง
            </td>
        </tr>
    	<tr>
    	  <th valign="top">หมายเหตุ</th>
    	  <td> 
    	    <textarea name='txta_01' style='width:500px; height:60px;'><?=$old_data['txta_01'];?></textarea>
    	    </td>
  	  </tr>
      
        <? if($old_data['date_save'] != '0000-00-00 00:00:00' && $old_data['date_save']) { ?><tr> <th>วันที่</th> <td> บันทึกล่าสุด : <?=$old_data['date_save'];?></td> </tr> <? } ?>
    	<tr>
    	  <td>&nbsp;</td>
    	  <td>
				<? if($form_type != 'VIEW') { ?> <input type='submit' value='บันทึก' class='btn_style_01' /> <? } ?>
                <input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/";' />
                <? if($doc1_dtl['index_control'] == 5) { ?> <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on' /> ส่งไปยังขั้นตอนถัดไป <? } ?>
            </td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?> </form> <? } ?>

</td></tr>
</table>
