<?

/*
$host = "db1.favouritehosting.com";
$user = "c1system_doc";
$pass = "sys@fd";
$database = "c1system_doc";


$host = '11.11.11.131';
$user = 'root';
$pass = 'intranet.opp.thai';
$database = 'intranet_opp';

$host = '61.47.127.212';
$user = 'oppnew';
$pass = '@oppnew';

$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'system_document';
*/


#Connect : Server
#$con_data = array('host'=>'61.47.127.212', 'user'=>'oppnew', 'pass' => '@oppnew', 'db'=>'intranet_opp');

#Connect : Localhost
$con_data = array('host'=>'localhost', 'user'=>'root', 'pass'=>'', 'db'=>'system_document');


/**/
if(!@$db_link)
{
	header("Content-Type: text/html; charset=utf-8"); 	
	function encode_password($value, $status)
	{	$result = '';
	
		if($status == 'OUT') {
			for($i=0; @$value[$i] !='';) 
				{
					$result .= chr((($value[$i].$value[$i+1].$value[$i+2])-4));  $i+=3; 
				}
		} else if($status == 'IN') {
			for($i=0; $value[$i] != ''; $i++) 
				{ 
					$result .= substr('0'.(ord($value[$i])+4), -3, 3);
				}
		}
		return $result;
	}
	
	$db_link = mysql_connect($con_data['host'], $con_data['user'], $con_data['pass']);
	mysql_select_db($con_data['db'], $db_link);
	mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
	
	include '../script/function_date.php';
	include '../script/function_pagination.php';
	include '../script/function_multiselect.php';
}
?>