<? $old_data = mysql_fetch_array(mysql_query("SELECT * FROM dex2_new_document_03 WHERE id_doc1 LIKE '".$_GET['id']."' LIMIT 0, 1")); ?>
<table style='width:100%; padding:5px;'>
<tr><td colspan="2">
	<div style='color:#630; font-weight:bold; font-size:20px; line-height:40px;'>ลงนาม/ข้อสั่งการ</div>
	<div style='padding:10px;'><? include '../control_document/navigator.php'; ?></div>
</td></tr>
<tr><td>
	<? include 'level1_detail.php';?>
</td></tr>
<tr><td colspan="2">

<? 
	$_GET['tform'] = (!empty($_GET['tform']))?$_GET['tform']:'';
	if($form_type != 'VIEW') { ?> <form method='post' action='process_03.php'> <? } ?>
    <input type='hidden' name='tform' value='<?=$_GET["tform"];?>'>
    <input type='hidden' name='id' value='<?=$_GET["id"];?>'>

	<table cellpadding="0" cellspacing="0" style='width:100%;' class='tbl_style_02'>
    	<tr>
        	<th valign="top" style='width:240px;'>หมายเหตุ</th>
            <td><textarea name='comment' style='width:500px; height:60px;'><?=$old_data['comment'];?></textarea></td>
        </tr>
        <? if($old_data['date_save'] != '0000-00-00 00:00:00' && $old_data['date_save']) { ?>
    	<tr>
    	  <th>วันที่</th>
    	  <td> บันทึกล่าสุด : <?=$old_data['date_save'];?> </td>
  	  </tr>
      <? } ?>
        <tr>
            <td>&nbsp;</td>
            <td>
				<? if($form_type != 'VIEW') { ?> <input type='submit' value='บันทึก' class='btn_style_01'> <? } ?>
                <input type='button' value='ยกเลิก' class='btn_style_01' onclick='window.location="../home/"'>
                <? if($doc1_dtl['index_control'] == 3) { ?>
                <input style='margin-left:20px; ' type='checkbox' name='status_send' value='on'> ส่งไปยังขั้นตอนถัดไป
                <? } ?>
            </td>
        </tr>
    </table>
<? if($form_type != 'VIEW') { ?> </form> <? } ?>

</td></tr>
</table>