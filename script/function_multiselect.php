<style type='text/css'>
	.mselect_style_01
	{
	}
	
	.mselect_style_01 li
	{
		padding-left:10px;
		line-height:30px;
		border-bottom:solid 1px #CCC;
		cursor:pointer;
	}
	
	.mselect_style_01 li:hover
	{
		background:#EEE;
		color:#333;
	}
	
	
	.mselect_mark
	{
		background:#555; 
		color:#EEE;
	}
	.mselect_mark:hover
	{
		background:#F00; 
		color:#EEE;
	}
</style>
<?
class multi_select {
	private $id_val;
	private $query_val;
	private $old_data;
	
	function set_id($value) { $this->id_val = $value; }
	function set_query($value) { $this->query_val = $value; }
	function set_odata($value) { $this->old_data = $value; }
	
	function get_multi_select() {
		$odata_exp = explode('|||', $this->old_data);
		$left_data_ = mysql_query($this->query_val);

		?><div style='border:solid 1px #CCC; display:inline-block; width:250px; height:150px; float:left; overflow-y:scroll;  border-radius:3px;'>
        	<ul class='mselect_style_01' id='<?=$this->id_val.'_LEFT';?>'>
				<? for($i=0; $left_data = mysql_fetch_array($left_data_); $i++) {
					
					$chk_r = in_array($left_data[1], $odata_exp);
					if($chk_r == false) { ?><li onclick='mselect_mark($(this));'><?=$left_data['departments']?></li><? }
				} ?>
            </ul>
        </div>
        
        <div style='display:inline-block; float:left; margin:10px; margin-top:50px;'>
        	<input type='button' class='btn_style_01' style='padding:5px; font-size:10px;' value='<<' onclick='mselect_move("<?=$this->id_val;?>", "LEFT");'>
            <input type='button' class='btn_style_01' style='padding:5px; font-size:10px;' value='>>' onclick='mselect_move("<?=$this->id_val;?>", "RIGHT");'/>
        </div>
        
        <div style='border:solid 1px #CCC; display:inline-block; width:250px; height:150px; float:left; overflow-y:scroll;  border-radius:3px;'>
        	<ul class='mselect_style_01' id='<?=$this->id_val.'_RIGHT';?>'>
            	<? for($i=0; $i <= count(@$odata_exp); $i++) { if(@$odata_exp[$i]) { ?>
					<li onclick='mselect_mark($(this))'><?=$odata_exp[$i];?></li>
                <? } } ?>
            </ul>
        </div>
        <input type='hidden' name='<?=$this->id_val;?>' id='<?=$this->id_val;?>' value='<?=$this->old_data;?>'/>
		<?
	}
}
?>


<script language="javascript">

function mselect_move(id, way) {
	if(way == 'RIGHT' && $('#'+id+'_LEFT .mselect_mark').text()) {
		$('#'+id).val($('#'+id).val()+$('#'+id+'_LEFT .mselect_mark').text()+'|||');
	
		$('#'+id+'_RIGHT').append('<li onclick="mselect_mark($(this));">'+$('#'+id+'_LEFT .mselect_mark').text()+'</li>');
		$('#'+id+'_LEFT .mselect_mark').remove();
	} else if(way == 'LEFT' && $('#'+id+'_RIGHT .mselect_mark').text()) {
		content_res = '';
		val_exp = $('#'+id).val().split('|||');
		for(i=0; val_exp[i]; i++) { if($('#'+id+'_RIGHT .mselect_mark').text() != val_exp[i]) { content_res += val_exp[i]+'|||'; } }
		$('#'+id).val(content_res);
		
		$('#'+id+'_LEFT').append('<li onclick="mselect_mark($(this));">'+$('#'+id+'_RIGHT .mselect_mark').text()+'</li>');
		$('#'+id+'_RIGHT .mselect_mark').remove();
}
		
	//Left
}
function mselect_mark(value)
{
	$('.mselect_mark').attr('class', '');
	value.attr('class', 'mselect_mark');
}
</script>