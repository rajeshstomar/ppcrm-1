<script>

var targetpage = "<?=$targetpage;?>";
$(document).ready(function()
{
	$("#checkall").click(function()				
	{
		var checked_status = this.checked;
		$("input[id=chkme]").each(function()
		{
			this.checked = checked_status;
		});
	});
	
	var norecord = document.getElementById("hidediv").value;
	
	//alert(norecord);
	
    if(norecord < 24 )
	
	   {
	   
	   $("#selectdiv").css("display","none");
	   	   
	   }
	
        
});

function doaction()
{
	var val = $("#action").val();
	if(val == "")
	{
		alert("Please Select Action");
		return false;
	}
	var flag = false;	
	$("input[id=chkme]").each(function()
	{
		if(this.checked)
		{
			flag = true;
		}
	});
	if(!flag)
	{
		alert("Please Select Records to "+val);
		return false;
	}
	$("#mode").val(val);
	var con=confirm('Are you sure you want to delete this Records?');
	
	//alert(con);
	
	
	if(con == true)
	{
		$("#frmlist").submit();
	}
	
}
function searchrec()
{
	var keyword = $("#keyword").val();
	/*	
	if(keyword == "")
	{
		alert("Please Enter Keyword");
		return false;
	}
	*/
	var search_option = $("#search_option").val();
	
	/*added for refine search */
	
	var refine_search = $("#refine_search").val();
	
	var serchurl = targetpage+'&keyword='+keyword+'&search_option='+search_option+'&refine_search='+refine_search;
	
	window.location = serchurl;
}
function checkcode(e)
{
	var code;
	if (!e) var e = window.event;
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	if(code == 13)
	{
		searchrec();
		return false;
	}
	return true;
}
$("#search_option").change(function () {
	autopopulate();
});
$( document ).ready(function() {
  	autopopulate();
});
function autopopulate()
{
	var table_name = '<?php echo $tablename; ?>';
	var vals = '<?php echo $columns; ?>';
	var url = 'search_result.php?col_name='+vals+'&table_name='+table_name;
	$( "#keyword" ).autocomplete({
		source: url,
	});
}

function doactionForlimit()
{
	$("#numofPagevalue").submit();
}



function doactionForadvsearch()

{
      //alert("vikas");
	  var keyword = $("#keyword").val();
	  alert(keyword);
      $("#advasearch").submit();

}


$("#alphaBtn_<?php echo $_GET['alpha_serach']?>").removeClass("searchAlph").addClass( "searchAlphselected" );
 /*setTimeout(function() {
      $("#alphaBtn_<?php echo $_GET['alpha_serach']?>").removeClass("searchAlph").addClass( "searchAlphselected" );
}, 100);*/

$('#refine_search option')
     .removeAttr('selected')
     .filter('[value=<?php echo trim($_GET['refine_search']);?>]')
         .attr('selected', true);
$('#show_max_row option')
     .removeAttr('selected')
     .filter('[value=<?php echo trim($show);?>]')
         .attr('selected', true);
</script>
<script>
var show_id = function(id){
	$('#'+id).show();
}
</script>
<script type="text/javascript">
$(function() {
	var scntDiv = $('#mastertable');
	var i = $('#mastertable #master_row').size() + 1;

	$('#addScnt').on('click', function() {
		$("#mastertable tr:last-child").clone().appendTo(scntDiv);
		i++;
		if(i>2){
			$("#mastertable tr:nth-last-child(2) td:last-child").show();
		}
		return false;
	});

	$('#remScnt').on('click', function() { 
		if( i > 2 ) {
			$('#mastertable tr:last-child').remove();
			i--;
		}
		return false;
	});
});
</script>