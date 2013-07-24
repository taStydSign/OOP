<?	$doc1_dtl = mysql_fetch_array(mysql_query('SELECT * FROM dex2_new_document_01 WHERE id LIKE "'.$_GET['id'].'" LIMIT 0, 1')); 
		$level1_date = new f_date;
		$level1_date_ = $level1_date->date_th_l(strtotime($doc1_dtl['book_date']));
		$level2_dtl = mysql_fetch_array(mysql_query('SELECT rdo_03 FROM dex2_new_document_02 WHERE id_doc1 LIKE "'.$_GET['id'].'" LIMIT 0, 1'));
?>
<div style='border:dashed 1px #F00; background:#fff2ec; padding:15px; padding-left:20px; padding-right:20px; margin-bottom:15px;'>
        <div class='head_style_01'>เลขที่หนังสือ </div>	<div class='normal_style_01'><?=$doc1_dtl['book_no'];?></div>
        <div class='head_style_01'>วันที่ </div>				<div class='normal_style_01'><?=$level1_date_;?></div><BR />
        <div class='head_style_01'>เรื่อง</div> <div class='normal_style_01'><?=$doc1_dtl['book_no'];?></div><br />
        <div class='head_style_01'>เรียน</div> <div class='normal_style_01'><?=$doc1_dtl['send'];?></div><br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div class='normal_style_01'><?=$doc1_dtl['detail'];?></div><Br />
        <div class='head_style_01'>รับจาก</div> <div class='normal_style_01'><?=$doc1_dtl['from'];?></div><br />
        <div class='head_style_01'>ความเร่งด่วน</div> <div class='normal_style_01'><?=$doc1_dtl['haste'];?></div>
        <div class='head_style_01'>ความลับ</div> <div class='normal_style_01'><?=$doc1_dtl['secrecy'];?></div>
<? if($level2_dtl['rdo_03']) { ?>
<div class='head_style_01'>หนังสือเวียน</div> <div class='normal_style_01'><? if($level2_dtl['rdo_03'] == 'off') { ?>ไม่แจ้งเวียน<? } else if($level2_dtl['rdo_03'] == 'on') { ?>แจ้งเวียน<? } ?></div><br /> <? }?>
        <div class='head_style_01'>หมายเหตุ</div> <div class='normal_style_01'>&nbsp;<?=$doc1_dtl['comment'];?></div><br />
        
        <?
			$attach_list_ = mysql_query('SELECT* FROM dex2_new_attach WHERE id_parent LIKE "'.$_GET['id'].'"');


		?>
        <div class='head_style_01'>ไฟล์แนบ</div> <div class='normal_style_01'>
        <? for($i; $attach_list = mysql_fetch_array($attach_list_);) { 
		?>
        		<a href='../file_attach/data/<?=$attach_list['name'];?>' target="_blank">
				<div style='display:inline-block; padding:5px; padding-right:10px; font-size:12px; font-weight:bold;'>
					<?=$attach_list['title'];?>
				</div>
                </a>
		<? } ?>
        </div><br />
</div>
