<div id='temp_sector'>Loading...</div>

<script language="javascript">
    /*Function sector reload*/
    load_temp('<?=$_SESSION['USER_ID'];?>', '<?=$_GET['id']?>');

    function load_temp(user_id, issue_id) {
        urlLink = '../create_document/attch_temp.php';
            urlLink += '?id='+user_id;
			urlLink += '&id_issue='+issue_id;
            
        $('#temp_sector').load(urlLink);
        setTimeout(function(){ load_temp(user_id, issue_id) }, 1000);
	}
</script>