function insertOperation()
{
	//$( "#watchlist_status_div" ).slideDown( 300 ).delay( 800 ).slideUp( 1000 );
	
	$("#watch_grid_popup").html('<img src="images/loading.gif"/>');
	$("#watch_grid_popup").show();
	var msg = getWatchTemplate();
	$("#watch_grid_popup").html(msg);
	$("#watch_symbol").focus();
}

function updateOperation(watch_id){
	
	$("#watch_grid_popup").html('<img src="images/loading.gif"/>');
	$("#watch_grid_popup").show();
	$.ajax({					
			type: "POST",
			url: "ciasdata.php",
			data: { 'keywords': 'getWatchData','watch_id':watch_id},
			success: function(json_data){
				var msg = getWatchTemplate('update',json_data,watch_id);	
				$("#watch_grid_popup").html(msg);
				$("#watch_symbol").focus();
			}
		});	
}

function cancelPopup(){
	$("#watch_grid_popup").html('');
	$("#watch_grid_popup").hide();
}

function getWatchTemplate(actionType='',json_data='',watch_id=''){
	if(actionType == 'update')
	{
		var t = JSON.parse(json_data);
		var Symbol = t['Symbol'];
		var KeyInfo = t['KeyInfo'];
		var Price = t['Price'];
		var Start_date = t['Start_date'];
		var Partners = t['Partners'];
		var EntryPoint = t['EntryPoint'];
		var ExitPoint = t['ExitPoint'];
		var Email = t['Email'];
		var Action_needed = t['Action_needed'];
		var watch_id = watch_id;
	}else{
		var Symbol = KeyInfo = Price = Start_date = Partners = "";
		var EntryPoint = ExitPoint = Email = Action_needed = watch_id = "";
	}
	
	
	var content = '';
	content += '<div class="container1">';
	content += '<div class="row">';
	content += '<form class="form form-inline form-multiline" id="watchList_form">';
	content += '<input type="hidden" name="watch_id" id="watch_id" value="'+watch_id+'"/>';
	content += '<div class="col-md-12">';
	content += '<span class="pull-left close-symbol required_class" style="font-size:14px">* field(s) are Required.</span>';
	content += '<span class="pull-right close-symbol" onclick="return cancelPopup()">X</span>';
	content += '<div> <div style="clear:both"></div>';
	content += '<div class="col-md-6 col-sm-6 col-xs-12">';
	
	content += '<div class="form-group">';	
	content += '<label for="Symbol">Symbol <span class="required_class">*</span></label>';		
	content += '<input type="text" name="Symbol" id="watch_symbol" value="'+Symbol+'"/>';
	content += '</div>';
	
	content += '<div class="form-group">';	
	content += '<label for="KeyInfo">KeyInfo</label>';		
	content += '<input type="text" name="KeyInfo" id="watch_keyinfo" value="'+KeyInfo+'"/>';
	content += '</div>';	
	
	content += '<div class="form-group">';	
	content += '<label for="Price">Price</label>';		
	content += '<input type="text" name="Price" id="watch_price" value="'+Price+'"/>';
	content += '</div>';

	content += '<div class="form-group">';	
	content += '<label for="Start_date">Start Date</label>';		
	content += '<input type="text" name="Start_date" id="watch_Start_date" value="'+Start_date+'" placeholder="YYYY-MM-DD"/>';
	content += '</div>';


	content += '<div class="form-group">';	
	content += '<label for="Partners">Partners</label>';		
	content += '<input type="text" name="Partners" id="watch_partners" value="'+Partners+'"/>';
	content += '</div>';	
	
	content += '</div>';
	
	
	
	content += '<div class="col-md-6 col-sm-6 col-xs-12">';	
	
	content += '<div class="form-group">';	
	content += '<label for="EntryPoint">EntryPoint</label>';		
	content += '<input type="text" name="EntryPoint" id="watch_entryPoint" value="'+EntryPoint+'"/>';
	content += '</div>';
	
	content += '<div class="form-group">';	
	content += '<label for="ExitPoint">ExitPoint</label>';		
	content += '<input type="text" name="ExitPoint" id="watch_exitPoint" value="'+ExitPoint+'"/>';
	content += '</div>';
	
	content += '<div class="form-group">';	
	content += '<label for="Email">Email</label>';		
	content += '<input type="text" name="Email" id="watch_email" value="'+Email+'"/>';
	content += '</div>';
	
	content += '<div class="form-group">';	
	content += '<label for="Action_needed">Action_needed</label>';		
	content += '<textarea name="Action_needed" id="watch_action_needed">'+Action_needed+'</textarea>';
	content += '</div>';
	
	content += '</div>';
	
	content += '<div class="form-group">';
	content += '<input type="button" name="watch_submit" onclick="validateWatchInputAndSubmit()" class="btn btn-success" value="Submit"/>';
	content += '<input type="button" name="watch_popup_cancel" onclick="return cancelPopup()" class="btn btn-warning"  value="cancel"/>';
	content += '</div>';
	
	content += '</form>';
	
	content += '</div>';
	content += '</div>';
	return content;
}


function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function isValidDate(dateString) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  return regEx.test(dateString);
  /*if(!dateString.match(regEx)) return false;  // Invalid format
  var d = new Date(dateString);
  if(!d.getTime()) return false; // Invalid date (or this could be epoch)
  return d.toISOString().slice(0,10) === dateString;*/
return false;
}

function validateWatchInputAndSubmit(){
	
	var formdata_Status = true;
	
	if($("#watch_symbol").val() == ''){
		alert("Please enter the symbol");
		formdata_Status = false;
	}
	
	/*if($("#watch_email").val() == ''){
		alert("Please enter the Email Id");
		formdata_Status = false;
	}else */ if($("#watch_email").val() != '' && isEmail($("#watch_email").val()) == false){
		alert("Please enter the valid email Id");
		formdata_Status = false
	}
	
	
	/*if($("#watch_Start_date").val() == ''){
		alert("Please enter the Start date");
		formdata_Status = false;
	}else*/ if($("#watch_Start_date").val() !='' && isValidDate($("#watch_Start_date").val()) == false){
		alert("Please enter the validate date");
		formdata_Status = false;
	}
	
	if(formdata_Status == false){
		return false;
	}else{
		$.ajax({					
			type: "POST",
			url: "ciasdata.php",
			data: $("#watchList_form").serialize()+"&keywords=getWatchDataDll",
			success: function(msg){
				cancelPopup();
				watchSearch();
				$( "#watchlist_status_div" ).html(msg).slideDown( 300 ).delay( 2000 ).slideUp( 1000 );
			}
		});
	}
}

function addToWatchDeleteList(){	
	$("#delete_watchList").val(getListOfCheckedItems('watch_list[]'));
}


function getListOfCheckedItems(FieldName){
	var checkboxes = document.getElementsByName(FieldName);
	var vals = "";
	for (var i=0, n=checkboxes.length;i<n;i++){
		if (checkboxes[i].checked) {
			vals += ","+checkboxes[i].value;
		}
	}
	if (vals) vals = vals.substring(1);
	return vals;
}

function deleteOperation(){
	if($("#delete_watchList").val() == ''){
		alert("Please choose the watch list to delete");
	}else{
		if(confirm("Are you Sure want to delete this watch List?")){
			$.ajax({					
				type: "POST",
				url: "ciasdata.php",
				data: { 'keywords': 'deleteWatchData','watch_list':$("#delete_watchList").val()},
				success: function(msg){
					msg = 'Watch list have been deleted successfully';
					$( "#watchlist_status_div" ).html(msg).slideDown( 300 ).delay( 2000 ).slideUp( 1000 );
					watchSearch();				
				}
			});	
		}
	}
}

function addToNoteDeleteList(){
	$("#delete_noteList").val(getListOfCheckedItems('note_list[]'));
}

function deleteNoteOperation(){
	if($("#delete_noteList").val() == ''){
		alert("Please choose the note to delete");
	}else{
		if(confirm("Are you Sure want to delete this Capture Note?")){
			$.ajax({					
				type: "POST",
				url: "ciasdata.php",
				data: { 'keywords': 'deleteNoteData','note_list':$("#delete_noteList").val()},
				success: function(msg){
					msg = 'Note have been deleted successfully';
					$( "#notelist_status_div" ).html(msg).slideDown( 300 ).delay( 2000 ).slideUp( 1000 );
					searchNoteOperation();				
				}
			});	
		}
	}
}

function searchNoteOperation()	{
	var search_query = $("#note_list_input").val();
	$.ajax
		({					
			type: "POST",
			url: "ciasdata.php",
			data: { 'keywords': 'searchNoteOperation','search_query':search_query},
			success: function(msg)
				{
					$("#notelist_div").html(msg);
				}
		});
	}
			
			
function insertNoteOperation(){	
	var ent_data = $.trim($("div.nicEdit-main").html());	
	//if($("#capture_note").val() == ''){
	//if($("div.nicEdit-main").html() =='' || $("div.nicEdit-main").html() == '<br>' || $("div.nicEdit-main").html() == '&nbsp;'){
	if($("div.nicEdit-main").html() ==''){	
		alert("Please enter the note");
	}else{
		$.ajax({					
			type: "POST",
			url: "ciasdata.php",
			data: { 'keywords': 'insertCaptureData','Symbol':$("#symbol").val(),'capture_note':$("div.nicEdit-main").html()},
			success: function(msg){
				$("#symbol").val('');
				$("div.nicEdit-main").html('');
				msg = "Successfully inserted";
				$( "#notelist_status_div" ).html(msg).slideDown( 300 ).delay( 2000 ).slideUp( 1000 );
				searchNoteOperation();
			}
		});	
	}	
}

function updateNoteOperation(){
	if($("div.nicEdit-main").html() == ''){
		alert("Please enter the note");
	}else{
		$.ajax({					
			type: "POST",
			url: "ciasdata.php",
			data: { 'keywords': 'updateCaptureData','Symbol':$("#symbol").val(),'capture_note':$("div.nicEdit-main").html(),'edit_note_id':$("#edit_note_id").val()},
			success: function(msg){
				$("div.nicEdit-main").html('');
				msg = "Successfully updated";	
				searchNoteOperation();
				$("#symbol").val('');
				//$(".sub_block").hide();	
				$("#noteUpdate_btn").hide();	
				$("#noteInsert_btn").show();	
				$( "#notelist_status_div" ).html(msg).slideDown( 300 ).delay( 2000 ).slideUp( 1000 );
			}
		});	
	}
}

function refreshNoteOperation(){
	searchNoteOperation();
}

$(function () { 
	$(".editNoteOperation").live("click", function () {
		//console.log($("#tmp_"+$(this).attr("id")).text());
		//$("#capture_note").html($(this).text());
		$("div.nicEdit-main").html($("#tmp_"+$(this).attr("id")).text());
		$("#symbol").val($("#sym_tmp_"+$(this).attr("id")).html());
		console.log($(this).attr("id"));
		$("#edit_note_id").val($(this).attr("id"));
		$("div.nicEdit-main").focus();
		$( ".sub_block" ).slideDown( 1000 );
		
		$("#noteUpdate_btn").show();
		$("#noteInsert_btn").hide();
	});
	
});
