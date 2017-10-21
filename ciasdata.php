<?php
/**
 * 
 *
 * 
 * 
 * 
 *
 * PHP version 5.5+
 *
 * @category	###Framework###
 * @package		###Index###
 * @author		Joseph
 * @copyright 	Joseph
 * @license		Joseph
 * @version		
 * @since 		2017-06-25
 */
error_reporting(E_ERROR | E_PARSE);
require_once('config/config.inc.php');
require_once($CFG['site']['project_path'].'commons/class_common.php');
//---------------------------------------------------------------------------// 
class Index extends CommonClass
	{
		/**
		 * To get Grid head
		 * @param $link_id 
		 */
		public function getGridHead($link_id,$val)
			{	
				?>
				<div class=" col-md-4 col-sm-4 col-xs-12">
					<div class="tab-top-sec">		 
						<span class="title-gar">Garden<?php echo $link_id;?></span>
						<button class="links-btn" value="Link" onclick="loadallrecords('<?php echo $link_id;?>');" >Link</button>			
						<div class="serch-sec">
							<input class="serch-input" type="text" placeholder="Plant Name" name="plantname<?php echo $link_id;?>" id="plantname<?php echo $link_id;?>" />
							<input type="button" class="serch-btn" value="Search Plant" onclick="loaddata('<?php echo $val;?>','<?php echo $link_id;?>',$('#plantname<?php echo $link_id;?>').val());" />
						</div>
					</div>		
					<div id="<?php echo $val;?>">						
				<?php 
			}
			
		/**
		 * To load Grid footer
		 */
		public function getGridFooter()
			{
				?>		
					</div>
				</div>
				<?php 	
			}

		/**
		 * To get data from tabel
		 */
		public function getDataFromTable()
			{	
				$link_id = 1;				
				foreach($this->CFG['site']['grid']['home'] as $key=>$val)
					{
						$row = $this->getTabelRecords($val,$this->CFG['site']['home']['limit'],false,false,'DESC',false,false,'dbObj','home');	
						if($row == ''){
							$this->getGrid($row,$val,$link_id,"No Record Found");
						}else{
							$this->getGrid($row,$val,$link_id);
						}
						
						$link_id++;
					}
			}
		
		/**
		 * Display the alert and predict data from the table
		 */
		public function displayAlertPredictData($table_name =''){
			
			$whr_condition = '`Target_date` > date_sub(now(), interval 5 day)';
			$search_query = $this->getFormField('search_query');
			if($search_query !=''){
				$whr_condition .= " AND ( UPPER (`Symbol`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= " UPPER (`Partners`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= " UPPER (`Prediction`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= " UPPER (`Detail`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= " UPPER (`Link`) LIKE UPPER('%$search_query%')";
				$whr_condition .= " )";
			}
			
			$table_name = ($table_name != '')?$table_name:$this->CFG['site']['alert_grid']['default'];
			$row = $this->getTabelRecords($table_name,$this->CFG['site']['home']['limit'],false,'Target_date','ASC',$whr_condition,false,'dbObj','home');
			$this->getAlertGridTemplate($row);
		}
		
		/**
		 * Display the alert and predict data from the table
		 */
		public function displayWatchListData($table_name ='',$search_query){
			
			//$whr_condition = '`Target_date` > date_sub(now(), interval 5 day)';
			$whr_condition = '';
			if($search_query != ''){
				$whr_condition .= "UPPER (`Symbol`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= "UPPER (`KeyInfo`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= "UPPER (`Partners`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= "UPPER (`Email`) LIKE UPPER('%$search_query%') OR ";
				$whr_condition .= "UPPER (`Action_needed`) LIKE UPPER('%$search_query%')";
			}
			
			$table_name = ($table_name != '')?$table_name:$CFG['db']['tbl']['watch_list'];
			$row = $this->getTabelRecords($table_name,$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$whr_condition,false,'dbObj','home');
			$this->getWatchListTemplate($row);
		}
		
		/**
		 * form the content for the alert grid based on the record given
		 */
		 public function getWatchListTemplate($records){
			 $content = '';
			 if($records!='' && count($records) >0){
				 $content .= '<input type="hidden" name="delete_watchList" id="delete_watchList" value=""/>';	
				foreach ($records as $key=>$val){	
					$content .= '<tr>';	
					$content .= '<td  style="min-width: 59px; cursor:pointer"><input type="checkbox" name="watch_list[]" class="watch_list" value="'.$val['IdWatchList'].'" onclick="addToWatchDeleteList()"/> <span onclick="return updateOperation('.$val['IdWatchList'].');"><img src="images/edit-icon.png"/> </span></td>';	
					$content .= '<td><span onclick="return updateOperation('.$val['IdWatchList'].');">'.$val['Symbol'].'</span></td>';	
					$content .= '<td>'.$val['KeyInfo'].'</td>';	
					$content .= '<td>'.$val['Price'].'</td>';	
					$content .= '<td>'.$val['Start_date'].'</td>';	
					$content .= '<td>'.$val['Partners'].'</td>';
					$content .= '<td>'.$val['EntryPoint'].'</td>';		
					//$content .= '<td>'.$val['EntryDeviation'].'</td>';
					$content .= '<td>'.$val['ExitPoint'].'</td>';
					//$content .= '<td>'.$val['ExitDeviation'].'</td>';
					$content .= '<td>'.$val['Email'].'</td>';	
					$content .= '<td>'.$val['Action_needed'].'</td>';	
					$content .= '<td>'.$val['CRE_ON'].'</td>';	
					$content .= '<td>'.$val['CRE_BY'].'</td>';	
					$content .= '<td>'.$val['LAST_UPDT_ON'].'</td>';	
					$content .= '<td>'.$val['LAST_UPDT_BY'].'</td>';	
					$content .= '</tr>';		
				}
			 }else{
				 $content .= '<tr><td colspan="13">No Record Found</td></tr>';
			 }
			 echo $content;
		 }
		
		
		/**
		 * form the content for the alert grid based on the record given
		 */
		 public function getAlertGridTemplate($records){
			 $content = '';
			 if($records!='' && count($records) >0){
				foreach ($records as $key=>$val){					
					$content .= '<tr>';	
					$content .= '<td>'.$val['Symbol'].'</td>';	
					$content .= '<td>'.$val['Partners'].'</td>';	
					$content .= '<td>'.$val['Prediction'].'</td>';
					$content .= '<td>'.$val['EntryPoint'].'</td>';	
					$content .= '<td>'.$val['ExitPoint'].'</td>';					
					$content .= '<td>'.$val['Target_date'].'</td>';	
					$content .= '<td>'.$val['Detail'].'</td>';	
					$content .= '<td>'.$val['Link'].'</td>';	
					$content .= '<td>'.$val['CRE_ON'].'</td>';	
					$content .= '<td>'.$val['CRE_BY'].'</td>';	
					$content .= '<td>'.$val['LAST_UPDT_ON'].'</td>';	
					$content .= '<td>'.$val['LAST_UPDT_BY'].'</td>';	
					$content .= '</tr>';		
				}
			 }else{
				 $content .= '<tr><td colspan="13">No Record Found</td></tr>';
			 }
			 echo $content;
		 }
		
		/**
		 * To Load the grid data
		 * @param $link_id
		 * @param $mydata
		 * @param $msg 
		 */
		public function loadGridData($link_id,$mydata,$msg=false)
			{
				?>
				<table class="table table-responsive table-bordered scroll">
					<thead>
						<tr>
							<th class="th-head">Plant</th>
							<th class="th-head2">Title</th>
							<th class="th-head3">Note</th>
						</tr>
					</thead>
					<tbody class="testDiv2"> 
				<?php 
				if($msg)
					{
				?>
						<tr><td class="th-head"><?php echo $msg;?></td></tr>
				<?php 		
					}
				else
					{	
						$x=1;
						if($mydata !="" && count($mydata)>0){
						foreach ($mydata as $myresult)
				 			{ 	
				 			?>
								<tr>
									<td class="th-head"><?php echo $myresult['plant_code'];?></td>
					                <?php
					                $y1 = '1_'.$link_id;
					                ?>                
									<td class="th-head2">
										<?php  																			
										echo '<a target="_blank" href="'.$myresult['link'].'">'.preg_replace($this->CFG['site']['home']['desc_pattern'], ' ', substr($myresult['description'], 0, $this->CFG['site']['home']['desc'])).'&nbsp;&nbsp; </a>';?>
									</td>
									<div class="dialog1<?php echo $y1; ?>" style="display: none;text-align: center;">
		                				<?php echo preg_replace($this->CFG['site']['home']['desc_pattern'], ' ', $myresult['description']); ?>
		                			</div>
									<?php									
										$x1 = '1_'.$x;
		 							?>
									<td class="th-head3">
										<?php echo preg_replace($this->CFG['site']['home']['desc_pattern'], ' ', substr($myresult['description'], 0, $this->CFG['site']['home']['desc'])).'&nbsp;&nbsp;<a  href="javascript:void(0)" class="btnShow" data= '.$link_id.' />... </a>';   ?>
									</td>
								</tr>
								<div class="dialog<?php echo $x1; ?>" style="display: none;text-align: center;">
		    						<?php echo preg_replace($this->CFG['site']['home']['desc_pattern'], ' ', $myresult['description']); ?>
								</div>	
							<?php 
				        	$x++; 
				 			}
						}else{
							echo "<tr><td>No Record Found</td></tr>";
						}
					}			
		 		?>
		 			</tbody>
				</table>
		 		<?php 
			}	
			
		/**
		 * To load the grid
		 * @param $mydata
		 * @param $val
		 * @param $link_id
		 */
		public function getGrid($mydata,$val,$link_id)
			{	
				$this->getGridHead($link_id,$val);				
		  		$this->loadGridData($link_id,$mydata);
				$this->getGridFooter();
			}

		/**
		 * To get Ajax search record
		 */
		public function getAjaxSearchPlanet()
			{
				$where_cond = false;
				if($this->fields_arr['keywords'])
					$where_cond = 'plant_code LIKE \'%'.$this->fields_arr['keywords'].'%\' || description LIKE \'%'.$this->fields_arr['keywords'].'%\'';
				if($this->fields_arr['db'] == '2'){
					$row = $this->getTabelRecords($this->fields_arr['table_name'],$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$where_cond,false,'dbobj2','home');
				}else{
					$row = $this->getTabelRecords($this->fields_arr['table_name'],$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$where_cond,false,'dbObj','home');
				}	
				if($row){
					$this->loadGridData($this->fields_arr['grid_count'],$row);
				}	
				else{
					$this->loadGridData($this->fields_arr['grid_count'],false,"No Record Found");	
				}	
			}
		
		public function getWatchListData($watch_id){
			$whr_condition = "IdWatchList =$watch_id";
			$row = $this->getTabelRecords($this->CFG['db']['tbl']['watch_list'],$this->CFG['site']['home']['limit'],false,'IdWatchList','DESC',$whr_condition,false,'dbObj','home');	
			echo json_encode($row[0]);
		}
		
		public function updateWatchList($watch_id){
			$sql = ' UPDATE `watch_list` SET '.
				   ' `Symbol`= "'.$this->getFormField('Symbol').'",'.
				   ' `KeyInfo`= "'.$this->getFormField('KeyInfo').'",'.
				   ' `Price`= "'.$this->getFormField('Price').'",'.
				   ' `Start_date`= "'.$this->getFormField('Start_date').'",'.
				   ' `Partners`= "'.$this->getFormField('Partners').'",'.
				   ' `EntryPoint`= "'.$this->getFormField('EntryPoint').'",'.
				   ' `ExitPoint`= "'.$this->getFormField('ExitPoint').'",'.
				   ' `Email`= "'.$this->getFormField('Email').'",'.
				   ' `LAST_UPDT_ON`= "'.date('y-m-d H:i:s').'",'.
				   ' `LAST_UPDT_BY`= "'.$_SESSION['user']['username'].'",'.
				   ' `Action_needed`= "'.$this->getFormField('Action_needed').'"'.
				   ' WHERE `IdWatchList` >0  AND `IdWatchList` = '.$watch_id;
			$this->updateTabelRecords($sql);
		}
		
		public function insertWatchList(){
			$sql = ' INSERT INTO `watch_list` VALUES ("",'.
				   ' "'.$this->getFormField('Symbol').'",'.
				   ' "'.$this->getFormField('KeyInfo').'",'.
				   ' "'.$this->getFormField('Price').'",'.
				   ' "'.$this->getFormField('Start_date').'",'.
				   ' "'.$this->getFormField('Partners').'",'.
				   ' "'.$this->getFormField('EntryPoint').'",'.
				   ' "'.$this->getFormField('EntryDeviation').'",'.
				   ' "'.$this->getFormField('ExitPoint').'",'.
				   ' "'.$this->getFormField('ExitDeviation').'",'.
				   ' "'.$this->getFormField('Email').'",'.
				   ' "'.$this->getFormField('Action_needed').'",'.
				   ' "'.date('y-m-d H:i:s').'",'.
				   ' "'.$_SESSION['user']['username'].'",'.
				   ' "'.date('y-m-d H:i:s').'",'.
				   ' "'.$_SESSION['user']['username'].'")';
			$this->insertTabelRecords($sql);
				   
		}
		
		public function deleteWatchListData($watch_list){
			$sql = ' DELETE FROM `watch_list` WHERE `IdWatchList` >0 AND IdWatchList IN ('.$watch_list.')';
			$this->deleteTabelRecords($sql);
		}
		
		
		public function loadNoteGridData($mydata)
			{
				$content='';
				if($mydata !="" && count($mydata)>0){
					$content .= '<input type="hidden" name="delete_noteList" id="delete_noteList" value=""/>';	
					foreach ($mydata as $myresult)
					{ 	
						$content .= '<tr>';
						$content .= '<td style="min-width: 59px; cursor:pointer"><input type="checkbox" name="note_list[]" class="note_list" value="'.$myresult['idnotes'].'" onclick="addToNoteDeleteList()"/> <span id="'.$myresult['idnotes'].'" class="editNoteOperation"> <img src="images/edit-icon.png"/> </span></td>';
						$content .= '<td class="th-head3 long-width-tabel"> <span id="'.$myresult['idnotes'].'" class="editNoteOperation">'.substr(html_entity_decode($myresult['NOTES_TEXT']),0, 300).'</span>
						
						<span style="display:none" id="tmp_'.$myresult['idnotes'].'">'.$myresult['NOTES_TEXT'].'</span>
						
						</td>';
						$content .= '<td>'.$myresult['symbol'].' <span style="display:none" id="sym_tmp_'.$myresult['idnotes'].'">'.$myresult['symbol'].'</span></td>';
						$content .= '<td>'.$myresult['CRE_ON'].'</td>';
						$content .= '<td>'.$myresult['CRE_BY'].'</td>';
						$content .= '<td>'.$myresult['LAST_UPDT_ON'].'</td>';
						$content .= '<td>'.$myresult['LAST_UPDT_BY'].'</td>';
						$content .= '</tr>';
					}
				}else{
					$content .='<tr><td colspan="6">No Record Found</td></tr>';
				}
				return $content;
			}	
			
		
		public function getCaptureNote(){
				if($this->fields_arr['search_query'] != '')
					$where_cond = 'NOTES_TEXT LIKE \'%'.$this->fields_arr['search_query'].'%\'';
				else
					$where_cond = '';
				$row = $this->getTabelRecords($this->CFG['db']['tbl']['notes'],$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$where_cond,false,'dbObj','home');				
				return $this->loadNoteGridData($row);					
		}
		
		public function insertCaptureData(){
			$sql = ' INSERT INTO '.$this->CFG['db']['tbl']['notes'].' VALUES ("",'.
				   ' "'.$this->getFormField('Symbol').'",'.
				   ' "'.$this->getFormField('capture_note').'",'.
				   ' "'.date('y-m-d H:i:s').'",'.
				   ' "'.$_SESSION['user']['username'].'",'.
				   ' "'.date('y-m-d H:i:s').'",'.
				   ' "'.$_SESSION['user']['username'].'")';
			$this->insertTabelRecords($sql);
		}
		
		public function updateCaptureData(){
			$sql = ' UPDATE '.$this->CFG['db']['tbl']['notes'].' SET '.
				   ' `symbol`= "'.$this->getFormField('Symbol').'",'.
				   ' `NOTES_TEXT`= "'.$this->getFormField('capture_note').'",'.
				   ' `LAST_UPDT_ON`= "'.date('Y-m-d H:i:s').'",'.
				   ' `LAST_UPDT_BY`= "'.$_SESSION['user']['username'].'"'.
				   ' WHERE `idnotes` = '.$this->getFormField('edit_note_id');
			$this->updateTabelRecords($sql);
		}
		
		public function deleteCaptureData(){
			$sql = ' DELETE FROM '.$this->CFG['db']['tbl']['notes'].				   
				   ' WHERE `idnotes` IN ('.$this->getFormField('note_list').')';
			$this->deleteTabelRecords($sql);
		}
	}
//---------------------------------index end------------------->>>>>>//
$index = new Index();
$index->setFormField('table_name','');
$index->setFormField('keywords','');
$index->setFormField('db','');
$index->setFormField('watch_id','');
$index->setFormField('grid_table_name','');
$index->setFormField('grid_count','');
$index->setFormField('search_query','');
$index->setFormField('watch_list','');

$index->setFormField('note_list','');
$index->setFormField('capture_note','');
$index->setFormField('edit_note_id','');



$index->setFormField('Symbol','');
$index->setFormField('KeyInfo','');
$index->setFormField('Price','');
$index->setFormField('Start_date','');
$index->setFormField('Partners','');
$index->setFormField('EntryPoint','');
$index->setFormField('ExitPoint','');
$index->setFormField('Email','');
$index->setFormField('Action_needed','');



$index->setFormField('grid_table_names',implode(",",$CFG['site']['grid']['home']));
$index->sanitizeFormInputs($_REQUEST);
//Header Include
getMetaTags('metatitle','Home');
getMetaTags('metadescription','Home'); 
getMetaTags('metakeyword','Home');


if(!isMember())
	{
		Redirect2URL(getUrl('index'));	
	}	
	
if($index->isFormPOSTed($_POST,'table_name'))
{
	$index->getAjaxSearchPlanet();
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "fetch_grid_record"){
	$index->displayAlertPredictData($index->getFormField('grid_table_name'));
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "fetch_wtachlist_record"){
	$index->displayWatchListData($CFG['db']['tbl']['watch_list'],$index->getFormField('search_query'));
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "getWatchData"){
	$index->getWatchListData($index->getFormField('watch_id'));
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "getWatchDataDll"){
	if($index->getFormField('watch_id') !=''){
		$index->updateWatchList($index->getFormField('watch_id'));
		echo "Watch List have been updated successfully";
	}else{
		$index->insertWatchList($index->getFormField('watch_id'));
		echo "Watch List have been inserted successfully";
	}
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "deleteWatchData"){
	$index->deleteWatchListData($index->getFormField('watch_list'));
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "insertCaptureData"){
	$index->insertCaptureData();
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "updateCaptureData"){
	$index->updateCaptureData();
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "searchNoteOperation"){
	echo $index->getCaptureNote();
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "deleteNoteData"){
	echo $index->deleteCaptureData();
	exit();
}


//------------------------------------HTML code start from here -------->>>>>>>>//
//Headr include
require_once($CFG['site']['project_path'].'includes/header.php'); 
?>

<?php /* Load the grid*/?> 
	<!-- popup div starts here -->
	<div class="popup_div" id="watch_grid_popup" style="display:none">	
		<img src="images/loading.gif"/>
	</div>
	<!-- popup div ends here -->
	<div class="main">
	<!-- Textarea field starts here -->
	<div class="container1 col-md-12 col-sm-12 col-xs-12">
		<div class="col-md-5 col-sm-5 col-xs-10">
			<div class="col-md-12">
					<span class="grid-heading">Capture Note</span>
					<div class="row-fluid">			
						<div class=" col-md-6 col-sm-6 col-xs-12">
							<div class="tab-top-sec grid-tab-top-sec">
								<div class="serch-sec grid-serch-sec">
										<input class="serch-input grid-search-input" id="note_list_input"  type="text" placeholder="Type Symbol" />
										<input type="button" class="serch-btn grid-serch-btn" value="Find notes" onclick="return searchNoteOperation();" />
									</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">				
							<ul class="dis-line-option">					
								<li><span class="capturenotespan" onclick="$('#capture_note_space').fadeIn().show();$('#noteUpdate_btn').hide();$('#noteInsert_btn').show();$('#edit_note_id').val('');$('div.nicEdit-main').html('');$('div.nicEdit-main').focus();">New Note</span></li>
								<li><span class="capturenotespan" onclick="return deleteNoteOperation();">Delete Note</span></li>
								<li><span class="capturenotespan" onclick="return refreshNoteOperation();">Refresh</span></li>
							</ul>
						</div>
					</div>
					
					<div class="col-md-12 audittable">
					<div id="notelist_status_div" class="status_div" style="display:none"></div>
					<table class="table table-responsive table-bordered grid-table">
								<thead>
									<tr>
										<th style="min-width: 59px;"></th>							
										<th class="th-head3 long-width-tabel">Content</th>							
										<th>Symbol</th>
										<th>Created On</th>
										<th>Created By</th>
										<th>Last Updated on</th>
										<th>Last Updated By</th>							
									</tr>
								</thead>
								<tbody class="dynamicdata" id="notelist_div"> 
									<?php echo $index->getCaptureNote();?>								
								</tbody>
							</table>
					</div>			
			</div>			
		</div>
		<!-- Note capture textarea starts here -->
		<div class="col-md-4 col-sm-4 col-xs-4">
			<div id="capture_note_space" class="sub_block">
				<input type="hidden" name="edit_note_id" id="edit_note_id" value=""/>
				<input type="text" name="symbol" id="symbol" class="pull-left  grid-search-input"  style="margin-right:6px" placeholder="symbol" value="" />
				<span id="noteInsert_btn" onclick="return insertNoteOperation();" class="custom-btn pull-left  margin-right">Insert</span>				
				<span id="noteUpdate_btn" onclick="return updateNoteOperation();" class="custom-btn pull-left margin-right" style="display:none">Update</span>
				<span id="noteInsert_btn" onclick="$('#capture_note_space').fadeOut().hide('500')" class="custom-btn pull-left margin-right">Cancel</span>
				
				<textarea name="capture_note" id="capture_note" cols="45" rows="6"></textarea>
				<!-- <input type="text" name="capture_note" id="capture_note" value=""/> -->
				
			</div>
		</div>
		<!-- Note capture textarea ends here -->
		<div class="col-md-3 col-sm-3 col-xs-3">
			<textarea cols="13" rows="4" style="margin-left: 14px;"></textarea>
			<textarea cols="13" rows="4"></textarea>
			<textarea cols="13" rows="4" style="margin-left: 14px;"></textarea>
			<textarea cols="13" rows="4"></textarea>
		</div>
	</div>
	<div style="clear:both"></div>
	<!-- Textarea field ends here -->
	
	<!-- New Grid starts here -->
	<div class="container1">		
		<div class="col-md-6 col-sm-6 col-xs-12">
		<span class="grid-heading">WatchList</span>
		<div class="row-fluid">			
			<div class=" col-md-6 col-sm-6 col-xs-12">
				<div class="tab-top-sec grid-tab-top-sec">
					<div class="serch-sec grid-serch-sec">
							<input class="serch-input grid-search-input" id="watch_list_input"  type="text" placeholder="Type Symbol" />
							<input type="button" class="serch-btn grid-serch-btn" value="Search Plant" onclick="return watchSearch();" />
						</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<ul class="dis-line-option">
					<li><span onclick="return insertOperation();">Insert</span></li>
					<!-- <li><span>UPDATE</span></li> -->
					<li><span onclick="return deleteOperation();">Delete</span></li>
					<li><span onclick="return watchSearch();">Refresh</span></li>
				</ul>
			</div>
		</div>
		
		<div class="col-md-12 audittable">
		
		<div id="watchlist_status_div" class="status_div" style="display:none"></div>
		<table class="table table-responsive table-bordered grid-table">
					<thead>
						<tr>
							<th style="min-width: 13px;"></th>
							<th>Symbol</th>
							<th>KeyInfo</th>
							<th>Price</th>
							<th>Start Date</th>
							<th>Partners</th>
							<th>Entry Point</th>
							<th>Exit Point</th>
							<th>Email</th>
							<th>Action Needed</th>
							<th>Created On</th>
							<th>Created By</th>
							<th>Last Updated on</th>
							<th>Last Updated By</th>
							
						</tr>
					</thead>
					<tbody class="dynamicdata" id="watchlist_div"> 
						<?php echo $index->displayWatchListData($CFG['db']['tbl']['watch_list']);?>									
					</tbody>
				</table>
				</div>
			
		</div>
		<div class=" col-md-6 col-sm-6 col-xs-12">
			<span class="grid-heading">Alerts and predictions</span>
			<div class="row-fluid">			
			<div class=" col-md-6 col-sm-6 col-xs-12">
				<div class="tab-top-sec grid-tab-top-sec">
					<div class="serch-sec grid-serch-sec">
							<input class="serch-input grid-search-input" id="alert_list_input" type="text" placeholder="Type Symbol" />
							<input type="button" class="serch-btn grid-serch-btn" value="Search Plant" onclick="fetchrecords($('#sel_option').val())"/>
						</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<input type="hidden" name="sel_option" id="sel_option" value=""/>
				<ul class="dis-line-option">
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['alerts'];?>');">Alert</span></li>
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['predictions'];?>');">Predict</span></li>
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['shortideas'];?>');">Short Ideas</span></li>
				</ul>
			</div>
		</div>
		
		<div class="col-md-12 audittable">
		<table class="table table-responsive table-bordered grid-table">
					<thead>
						<tr>
							<th>Symbol</th>
							<th>Partners</th>
							<th>Prediction</th>
							<th>Entry Point</th>
							<th>Exit Point</th>		
							<th>Target_date</th>
							<th>Detail</th>
							<th>Link</th>
							<th>Created On</th>
							<th>Created By</th>
							<th>Last Updated on</th>
							<th>Last Updated By</th>
							
						</tr>
					</thead>
					<tbody class="dynamicdatagrid"> 
						<?php echo $index->displayAlertPredictData();?>									
					</tbody>
				</table>
				</div>
			
		</div>
		
	</div>
	<div style="clear:both"></div>
	<!-- New Grid ends here -->
	<div class="container1">
		<?php $index->getDataFromTable();?>
	</div>
</div>
<?php /* assign table names*/?>
<script type="text/javascript">
<!--
var tabel_name = '<?php echo $index->getFormField('grid_table_names');?>'
//-->
</script>	
<?php
//Include Footer
require_once($CFG['site']['project_path'].'includes/footer.php');
?>
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
<script type="text/javascript">
//<![CDATA[
	bkLib.onDomLoaded(function() {
    nicEditors.editors.push(
        new nicEditor({maxHeight : 150}).panelInstance(
            document.getElementById('capture_note')
        )
    );
});
//]]>
</script>
