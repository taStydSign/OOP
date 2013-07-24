<?
class f_page {
	public $str_query;
	public $data_amount = 10;
	public $this_page = 1;
	public $paramiter;


	function set_query($value) { $this->str_query = $value; }
	function set_amount($value) { $this->data_amount = ($value*1); }
	function set_page($value) { $this->this_page = ($value*1); }
	function set_paramiter($value) { $this->paramiter .= $value; }
		function get_no() { return ($this->this_page-1)*$this->data_amount; }
		
	function get_pagination() //รับค่า ตัวแบ่งหน้า
	{
		$chk_amount = mysql_num_rows(mysql_query($this->str_query));
		$page_amount = ceil($chk_amount/$this->data_amount);
		$this_page = $this->this_page;


		if($this_page <= $page_amount && $this_page >= 1 && $page_amount != 1) {
				if(($this_page-1) > 0) { 	?><div class='pagination' onclick='window.location="?page=<?=($this_page-1).$this->paramiter;?>"'>Prev</div><? } 
				if($this_page >= 4) { ?><div class='pagination' onclick='window.location="?page=1<?=$this->paramiter;?>"'>1</div> ...<? }

				for($i=($this_page-2); $i<=($this_page+2); $i++) { 		
					if(($i<=$page_amount) && ($i>0)) { ?>
					<div class='pagination <?=($this_page == $i)?'pagination_mark':'';?>' onclick='window.location="?page=<?=$i.$this->paramiter;?>"'><?=$i;?></div>
				<? }
				}
		
				if($this_page <= ($page_amount-3)) { ?>...<div class='pagination' onclick='window.location="?page=<?=$page_amount.$this->paramiter;?>"'><?=$page_amount;?></div> <? } 
				if($this_page < $page_amount) { ?><div class='pagination' onclick='window.location="?page=<?=($this_page+1).$this->paramiter;?>"'>Next</div><? } ?>
		<? } ?>            
            <div class='pagination' style='border:none;'><?=$chk_amount.' record';?></div>
		<?
	}
	
	function get_data() //รับค่าข้อมูล
	{	$limit_val = ' LIMIT '.(($this->this_page-1)*$this->data_amount).', '.$this->data_amount;
		return mysql_query($this->str_query.$limit_val);		
	}
	
	function get_help()
	{
		echo '(1) new f_page<BR>';
		echo '(2) set_page(x)<BR>';
		echo '(3) set_amount(y)<BR>';
		echo '(4) set_paramiter(z)<BR>';
		echo '(5) set_query("query string (No LIMIT!)")<BR>';
		echo '(6) $value = $function->get_data()<BR>';
		echo '(7) use $value for list data<BR>';
	}
}
?>