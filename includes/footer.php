<?php
/*
 * Template footrt file
 * date 27-07-2015
 * @Author Joe
 * 
 */ 
?>
<!-- <script type="text/javascript" src="<?php echo $CFG['site']['js']['path'];?>jquery.js"></script>--> 

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo $CFG['site']['js']['path'];?>ciasdata.js"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.9/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $CFG['site']['js']['path'];?>jquery.slimscroll.js"></script>
<link href="<?php echo $CFG['site']['css']['path'];?>jquery-ui.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
		function loaddata(table_name,newcount,search_val,db='1')
			{
			    $.ajax
			    ({
					
			        type: "POST",
			        //url: "ciasdata.php",
			        url: <?php echo '"'.basename($_SERVER['PHP_SELF']).'"';?>,
			        data: { 'keywords': search_val,'table_name':table_name,'grid_count':newcount,'db':db  },
			        success: function(msg)
				        {   
				            $("#"+table_name).html(msg);
							$('.testDiv2').slimScroll({
				        		railVisible: true,
				        		railColor: '#1ccb6b'
				      		});
				        }
			    });
			}
		
		function refreshrecords(table_name,newcount)
			{
			    $.ajax
			    ({					
			        type: "POST",
			        url: "ciasdata.php",
			        data: { 'keywords': '','table_name':table_name,'grid_count':newcount  },
			        success: function(msg)
			        	{
			        		$("#garden"+newcount).html(msg);
							$('.testDiv2').slimScroll({
			        			railVisible: true,
			        			railColor: '#1ccb6b'
			      			});
			        	}
			    });
			}    


		function loadallrecords(newcount,db='1')		
			{	
				var search_val = $('#plantname'+newcount).val();
			    var tabel_name_arr = tabel_name.split(',');
			    for(i=0;i<tabel_name_arr.length;i++)
			    	{	
			    		var coun = i+1;
			    		$('#plantname'+coun).val(search_val);
			    		loaddata(tabel_name_arr[i],coun,search_val,db);
			    	}
			}

 		function loadsearchdata(newcount,newval)
			{  
			    $.ajax
			    ({					
			        type: "POST",
			        url: "ciasdata.php",
			        data: { 'keywords': newval,'gardencount':newcount  },
			        success: function(msg)
			        	{
			            	$("#garden"+newcount).html(msg);
			             	$("#plantname"+newcount).val(newval);
						    $('.testDiv2').slimScroll({
			        			railVisible: true,
			        			railColor: '#1ccb6b'
			      			});
			        	}
			    });
			}
		function fetchrecords(table_name)
			{
				var search_query = $("#alert_list_input").val();				
				$("#sel_option").val(table_name);
			    $.ajax
			    ({					
			        type: "POST",
			        url: "ciasdata.php",
			        data: { 'keywords': 'fetch_grid_record','grid_table_name':table_name,'search_query':search_query},
			        success: function(msg)
			        	{
			        		$(".dynamicdatagrid").html(msg);
			        	}
			    });
			}    
			
		function optionSearch()
		{
			fetchrecords($('#sel_option').val());
		}
		
		
		function watchSearch()
		{
			var search_query = $("#watch_list_input").val();
			$.ajax
			    ({					
			        type: "POST",
			        url: "ciasdata.php",
			        data: { 'keywords': 'fetch_wtachlist_record','search_query':search_query},
			        success: function(msg)
			        	{
			        		$("#watchlist_div").html(msg);
			        	}
			    });
		}
		
		$(document).ready(function() {
			setTimeout(function() {
			    $("#refreshrecord1").trigger('click');
			}, 30*60*1000);
			setTimeout(function() {
				$("#refreshrecord2").trigger('click');
			}, 30*60*1000);
			setTimeout(function() {
			    $("#refreshrecord3").trigger('click');
			}, 30*60*1000);
			setTimeout(function() {
			    $("#refreshrecord4").trigger('click');
			}, 30*60*1000);
			setTimeout(function() {
			    $("#refreshrecord5").trigger('click');
			}, 30*60*1000);
			setTimeout(function() {
			    $("#refreshrecord6").trigger('click');
			}, 30*60*1000);
		});

	$(function () {
    	$('.btnShow').live("click", function (event) {  
			var idc=$(this).attr('data');			 
            $('.dialog'+idc).dialog('open');
			$(".dialog"+idc).dialog({
            	modal: true,
            	autoOpen: true,
            	title: "DESCRIPTION",
            	width: 600,
            	height: 500
    		});
		});
    });
    
    
    $(function () {   
    	$('.btnShow1').live("click", function (event) {
			 var idc1=$(this).attr('data');
			 //alert(idc1);
       		$('.dialog1'+idc1).dialog('open');
			$(".dialog1"+idc1).dialog({
            modal: true,
            autoOpen: true,
            title: "TITLE",
            width: 600,
            height: 500
    		});
		});
    });

    $(function(){
      $('.testDiv2').slimScroll({
          railVisible: true,
          railColor: '#1ccb6b'
      });
    });
</script>




</body>