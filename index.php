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
		 * To get Top Referesh
		 */
		public function getRefresh()
			{
				$i = 1;
				foreach($this->CFG['site']['grid']['home'] as $key=>$val)
					{
					?>
						<li><span>Garden<?php echo $i?></span><a href="javascript:void(0)" id="refreshrecord<?php echo $i;?>" onclick="refreshrecords('<?php echo $val;?>');">REFRESH</a></li>
					<?php
						$i++; 
					}
			}

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
						$row = $this->getTabelRecords($val,$this->CFG['site']['home']['limit']);						
						$this->getGrid($row,$val,$link_id);
						$link_id++;
					}
			}
		
		/**
		 * Display the alert and predict data from the table
		 */
		public function displayAlertPredictData($table_name =''){
			$table_name = ($table_name != '')?$table_name:$this->CFG['site']['alert_grid']['default'];
			$row = $this->getTabelRecords($table_name,$this->CFG['site']['home']['limit']);	
			$this->getAlertGridTemplate($row);
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
					$content .= '<td> - </td>';	
					$content .= '<td> - </td>';	
					$content .= '<td>'.$val['Target_date'].'</td>';	
					$content .= '<td>'.$val['Partners'].'</td>';
					$content .= '<td>'.$val['EntryPoint'].'</td>';		
					$content .= '<td>'.$val['ExitPoint'].'</td>';
					//$content .= '<td>'.$val['Prediction'].'</td>';
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
				$row = $this->getTabelRecords($this->fields_arr['table_name'],$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$where_cond);
				if($row){
					$this->loadGridData($this->fields_arr['grid_count'],$row);
				}	
				else{
					$this->loadGridData($this->fields_arr['grid_count'],false,"No Record Found");	
				}	
			}	
	}
//---------------------------------index end------------------->>>>>>//
$index = new Index();
$index->setFormField('table_name','');
$index->setFormField('keywords','');
$index->setFormField('grid_table_name','');
$index->setFormField('grid_count','');
$index->setFormField('grid_table_names',implode(",",$CFG['site']['grid']['home']));
$index->sanitizeFormInputs($_REQUEST);
//Header Include
getMetaTags('metatitle','Home');
getMetaTags('metadescription','Home'); 
getMetaTags('metakeyword','Home');
if($index->isFormPOSTed($_POST,'table_name'))
{
	$index->getAjaxSearchPlanet();
	exit();
}else if($index->isFormPOSTed($_POST,'keywords') && $index->getFormField('keywords') == "fetch_grid_record"){
	$index->displayAlertPredictData($index->getFormField('grid_table_name'));
	exit();
}
//------------------------------------HTML code start from here -------->>>>>>>>//
//Headr include
require_once($CFG['site']['project_path'].'includes/header.php'); 
?>
<?php /* Top referesh start from here*/?> 
<div class="header">
	<div class="container">
		<div class="logo col-md-12 col-sm-12 col-xs-12 text-center">
			<a href="#"><img src="images/logo.png"/></a>
		</div>
		<div class="menu-bar-sec col-md-12 col-sm-12 col-xs-12 text-center">
			<nav class="navbar">
				<ul class="dis-inline">
					 <?php $index->getRefresh();?>
				</ul>
			</nav>
		</div>
	</div>
</div>
<?php /* Load the grid*/?> 
<div class="main">
	<!-- New Grid starts here -->
	<div class="container1">		
		<div class=" col-md-6 col-sm-6 col-xs-12">
		<span class="grid-heading">WatchList</span>
		<div class="row-fluid">			
			<div class=" col-md-6 col-sm-6 col-xs-12">
				<div class="tab-top-sec grid-tab-top-sec">
					<div class="serch-sec grid-serch-sec">
							<input class="serch-input grid-search-input" type="text" placeholder="Type Symbol" />
							<input type="button" class="serch-btn grid-serch-btn" value="Search Plant" />
						</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<ul class="dis-line-option">
					<li><span>INSERT</span></li>
					<li><span>UPDATE</span></li>
					<li><span>DELETE</span></li>
					<li><span>REFRESH</span></li>
				</ul>
			</div>
		</div>
		
		<div class="col-md-12" style="overflow-x:scroll">
		<table class="table table-responsive table-bordered grid-table">
					<thead>
						<tr>
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
					<tbody class="dynamicdata"> 
						<?php echo $index->displayAlertPredictData($CFG['db']['tbl']['watch_list']);?>									
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
							<input class="serch-input grid-search-input" type="text" placeholder="Type Symbol" />
							<input type="button" class="serch-btn grid-serch-btn" value="Search Plant" />
						</div>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<ul class="dis-line-option">
					<!-- <li><a href="#" onclick="fetchrecords('<?php echo $CFG['db']['tbl']['alerts'];?>');">Alert</a></li>
					<li><a href="#" onclick="fetchrecords('<?php echo $CFG['db']['tbl']['predictions'];?>');">Predict</a></li>
					<li><a href="#" onclick="fetchrecords('<?php echo $CFG['db']['tbl']['shortideas'];?>');">Short Ideas</a></li> -->
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['alerts'];?>');">Alert</span></li>
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['predictions'];?>');">Predict</span></li>
					<li><span onclick="fetchrecords('<?php echo $CFG['db']['tbl']['shortideas'];?>');">Short Ideas</span></li>
				</ul>
			</div>
		</div>
		
		<div class="col-md-12" style="overflow-x:scroll">
		<table class="table table-responsive table-bordered grid-table">
					<thead>
						<tr>
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
					<tbody class="dynamicdatagrid"> 
						<?php echo $index->displayAlertPredictData();?>									
					</tbody>
				</table>
				</div>
			
		</div>
		
	</div>
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

