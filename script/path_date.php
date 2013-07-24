<? $month_string = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'); ?>
<style type="text/css">
	.calendar_style_01 {
		width:100%;
	}
	.calendar_style_01 * {
		padding:0px;
		margin:0px;
		font-size:10px;
	}
	.calendar_style_01 td {
		padding:0px;
		margin:0px;
		border:none;
	}
			.calendar_style_01 td {
				text-align:center;
				line-height:20px;
				width:20px;
			}
			

			
			.calendar_style_01 tr .subhead td {
				background:#CCC;
				font-weight:bold;
			}
			
	.calendar_style_01 th {
		padding:5px;
		margin:0px;
		line-height:10px;
		border:none;
		color:none;
		font-weight:bold;
		border-radius:3px;
	}
			.calendar_style_01 th {
				text-align:center;
				width:50%;
				background:#AAA;
				color:#000;
				font-size:12px;
			}
</style>

<?	$day_cld = 1;
	$month_cld = $month = ($_GET['month'])?$_GET['month']:date('m'); 
	$year = ($_GET['year'])?$_GET['year']:date('Y');
?>

<table class='calendar_style_01'>
    <tr>
        <th style='font-size:10px;'>
				<? if($month != 1) { ?>
                    <div style="float:left; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "<?=($month-1);?>", "<?=$year;?>");'><<</div>
                <? } else { ?>
                    <div style="float:left; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "12", "<?=($year-1);?>");'>>></div>
                <? } ?>
                
            
            <?=$month_string[$month];?>
            
            
				<? if($month != 12) { ?>
                    <div style="float:right; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "<?=($month+1);?>", "<?=$year;?>");'>>></div>
                <? } else { ?>
                    <div style="float:right; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "1", "<?=($year+1);?>");'>>></div>
                <? } ?>
        </th>
        <th style='font-size:10px;'>
		<div style="float:left; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "<?=($month);?>", "<?=$year-1;?>");'><<</div>
        <?=($year+543);?>
		<div style="float:right; cursor:pointer; display:inline-block;" onclick='set_calendar("<?=$_GET['id'];?>", "<?=($month);?>", "<?=$year+1;?>");'>>></div>
        </th>
    </tr>
    <tr>
		<td colspan="2">
        	<table style='width:100%;'>
            	<tr class='subhead'><td>Sun</td><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>
                <?
				$date_cld = strtotime($day_cld.'-'.$month_cld.'-'.$year);
				for($j=0; $month == date('m', $date_cld) && $year == date('Y', $date_cld); $j++) { ?>
                <tr>
					<? for($i=0; $i<7; $i++) { $date_cld = strtotime($day_cld.'-'.$month_cld.'-'.$year);?>
						<td style='cursor:pointer;' onmouseout="$(this).attr('style', 'cursor:pointer; background:#FFF;');" onmouseover="$(this).attr('style', 'cursor:pointer; background:#EEE;');">
                        <? if((date('w', $date_cld) == $i) && $month == date('m', $date_cld) && $year == date('Y', $date_cld)) { ?>
                        	<div style=' <? if(date('d') == date('d', $date_cld)) { ?>background:#AAA;<? } ?> ' onclick="get_calendar_res('<?=$_GET['id'];?>', '<?=date('Y-m-d', $date_cld);?>'); $('#<?=$_GET['id'];?>_calendar').fadeOut('fast');" >
							<?=date('d', $date_cld);?>
                            </div>
                            <? $day_cld++;?>
                       	<? } ?>
                        </td>
                    <? } ?>
                </tr>
                <? } ?>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" align="center";>
    	<div style='display:none; background:#EEE; border:solid 1px #777; width:99%;'>
        	<input type='text' style='width:20px;' id='<?=$_GET['id'];?>_h_value' value='<?=date('H');?>'/> : 
        	<input type='text' style='width:20px;' id='<?=$_GET['id'];?>_i_value' value='<?=date('i');?>'/> : 
        	<input type='text' style='width:20px;' id='<?=$_GET['id'];?>_s_value' value='<?=date('s');?>'/> 
            <input type='button' style='padding:2px; padding-left:5px; padding-right:5px;' value='Now'  onclick="get_calendar_res('<?=$_GET['id'];?>', '<?=date('Y-m-d');?>'); $('#<?=$_GET['id'];?>_calendar').fadeOut('fast');"/>
        </div>
    </td></tr>
</table>
