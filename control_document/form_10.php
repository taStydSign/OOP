<?
	$status['dep'] = false;
	$member_depid = mysql_fetch_array(mysql_query("SELECT dep_id FROM user WHERE username LIKE '".$_SESSION['USER_ID']."'"));
	$doc9_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_09 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1"));
		$dep_list_ = explode('|||', $doc9_data['mslc_01']);
		foreach($dep_list_ as $rs)
		{
			if(!empty($rs))
			{
				$dep_dtl = mysql_fetch_array(mysql_query("SELECT dep_id FROM DEPARTMENTS WHERE DEPARTMENTS LIKE '".$rs."' LIMIT 0, 1"));
				$depid_list[] = $dep_dtl['dep_id'];
				if($member_depid['dep_id'] == $dep_dtl['dep_id']) $status['dep'] = true;
			}
		}
	
	$old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_10 WHERE id_doc1 LIKE '".$_GET['id']."' AND dep_id LIKE '".$member_depid['dep_id']."' LIMIT 0, 1"));
	
	if($status['dep'] == FALSE)
	{
		?>
		<script>alert("การเข้าถึงไม่ถูกต้องกรุณาตรวจสอบ"); history.back();</script>
		<?
	}
?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ลงเลขหนังสือ</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">


<? if($form_type != 'VIEW') { ?><form method='post' action='process_10.php'><? } ?>
	<input type='hidden' name='id' value='<?=$_GET["id"];?>'>
	<input type='hidden' name='dep_id' value='<?=$member_depid['dep_id'];?>'>
	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
    	<tr>
        	<th style='width:240px;'>ชื่อสำนัก/กอง/กลุ่มรายงานตรง รับที่*</th>
            <td><input type='text' name='txt_01' style='width:220px;' value='<?=$old_data['txt_01'];?>'/></td>
        </tr>
    	<tr>
        	<th style='width:240px;'>ลงวันที่</th>
        	<td>
				<? $old_date = ($old_data['date'] != '0000-00-00 00:00:00')?$old_data['date']:'';
				set_input_date('date', $old_date); ?>
			</td>
          </tr>
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
                <? if($doc1_dtl['index_control'] == 10) { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on'> ส่งไปยังขั้นตอนถัดไป
                <? } ?>
			</td>
  	  </tr>
    </table>
<? if($form_type != 'VIEW') { ?></form><? } ?>


</td></tr>
</table>