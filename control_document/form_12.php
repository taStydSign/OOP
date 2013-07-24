<? $old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_12 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); ?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ลงนาม/ข้อสั่งการ เลือกกลุ่ม/ฝ่าย</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">


<? if($form_type != 'VIEW') { ?>
	<form method='post' action='process_12.php'>
	<input type='hidden' name='id' value='<?=$_GET["id"];?>'>
<? } ?>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
	  <tr>
	    <th style='width:240px;' valign="top">ข้อสั่งการ สำนัก/กอง/กลุ่มรายงานตรง</th>
	    <td><textarea name='txta_01' style='width:500px; height:60px;'><?=$old_data['txta_01'];?></textarea></td>
	    </tr>
	  <tr>
	    <th style='width:240px;' valign="top">เลือก สำนัก/กอง/กลุ่มรายงานตรง</th>
	    <td>
	    	<?
	    		$org_list_ = mysql_query("SELECT dp.dep_id, dp.departments FROM departments as dp WHERE dp.parent_id LIKE '0'");
				for($i=0; $rs = mysql_fetch_array($org_list_); $i++)
				{
					$chk_parent = mysql_query("SELECT * FROM departments WHERE parent_id LIKE '".$rs['dep_id']."'");
					if(mysql_num_rows($chk_parent) != 0)
						$dep_list[] = array('id'=>$rs['dep_id'], 'title'=>$rs['departments']);
				}
	    	?>
        	<select id='slc_01'  name='slc_01' onchange="org_sub_call('mslc_01', $(this).val());">
            	<option value=''>- - กรุณาเลือก สำนัก/กอง/กลุ่มรายงานตรง - -</option>
	        	<? foreach($dep_list as $dep_list_) echo '<option value="'.$dep_list_['id'].'">'.$dep_list_['title'].'</option>'; ?>
			</select>
        </td>
	    </tr>
	  <tr>
	    <th style='width:240px;' valign="top">เลือก กลุ่ม ฝ่าย</th>
	    <td id='org_sub_sector_01'>จะแสดงสำนัก/กอง/กลุ่มรายงานตรง ตาม flow จะแสดงกลุ่มฝ่าย</td>
	    </tr>
    	<tr>
    	  <th style='width:240px;' valign="top">หมายเหตุ</th>
    	  <td><textarea name='txta_02' style='width:500px; height:60px;'><?=$old_data['txta_02'];?></textarea></td>
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
          		<? if($form_type != 'VIEW') { ?><input type='submit' value='บันทึก' class='btn_style_01'> <? } ?>
				<input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/";'>
                <? if($doc1_dtl['index_control'] == 12) { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on'> ส่งไปยังขั้นตอนถัดไป
                <? } ?>
			</td>
  	  </tr>
    </table>
</td></tr>
</table>

<? if($form_type != 'VIEW') { ?></form><? } ?>

<script language="javascript">
$('#slc_01').val(<?=$old_data['slc_01'];?>);
org_sub_call('mslc_01', '<?=$old_data['slc_01'];?>', '<?=$old_data['mslc_01'];?>');
function org_sub_call(id, parent_id, old_data) {
	urlLink = 'multi_select_organize.php';
	urlLink += '?id='+id;
	urlLink += '&parent_id='+parent_id;
	if(old_data) { urlLink += '&old_data='+old_data; } else { $('#'+id).val(''); }
	urlLink = encodeURI(urlLink);
	$('#org_sub_sector_01').load(urlLink);
}
</script>