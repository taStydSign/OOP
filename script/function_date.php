<? 
class f_date {
	public $str_month = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');	
	function date_th_l($time_value=FALSE)
	{
		$time_value = ($time_value)?$time_value:strtotime(date('Y-m-d'));
		$result = date('d', $time_value);
		$result .= ' '.$this->str_month[(date('m', $time_value)*1)];
		$result .= ' '.(date('Y', $time_value)+543);
		return $result;
	}
}


		
	function set_input_date($id, $old_data){ ?>
		<div style='display:inline-block; '>
			<div style='float:left;'><input name='<?=$id;?>' id='<?=$id;?>' type='text' style='text-align:center; width:70px;' readonly="readonly" value='<?=$old_data;?>'/></div>
            <div style='float:left;'>
                <input type='button' style='margin-left:5px; background-image:url(../script/path_fdate/btn_calendar.png); background-repeat:no-repeat;  cursor:pointer; width:17px; height:18px; border:solid 1px #777; border-radius:2px;' onclick='toggle_Calendar("<?=$id;?>");'/>
                <div id='<?=$id.'_calendar';?>' style='display:none; margin-top:-25px; margin-left:25px; position:absolute; width:280px; border:solid 1px #AAA; border-radius:3px; background:#FFF;'></div>
			</div>
		</div>
        <script language="javascript">set_calendar('<?=$id;?>');</script>
	<? }

$month_string = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
?>

<script language="javascript">
function toggle_Calendar(id) {
	$("#"+id+"_calendar").fadeToggle("fast"); set_calendar(id);
}


function set_calendar(id, month, year) {
	urlLink = '../script/path_date.php'; //เปลี่ยนพาร์ทตามที่อยู่
	urlLink += '?id='+id;
	
	if(month){ urlLink += '&month='+month; }
	if(year) { urlLink += '&year='+year; }

	$('#'+id+'_calendar').load(urlLink);
}
function get_calendar_res(id, value) {
	hvalue = ($('#'+id+'_h_value').val())?$('#'+id+'_h_value').val():'00';
	ivalue = ($('#'+id+'_i_value').val())?$('#'+id+'_i_value').val():'00';
	svalue = ($('#'+id+'_s_value').val())?$('#'+id+'_s_value').val():'00';
	time_val = hvalue+':'+ivalue+':'+svalue;
	time_val = '';
	value = value;
	$('#'+id).val(value);
}
</script>