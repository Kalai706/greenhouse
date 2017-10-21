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
require_once($CFG['site']['project_path'].'commons/gardenDetails_class.php');
//---------------------------------------------------------------------------// 
class Index extends GardenDetails
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
				//pr($this->CFG['site']['grid']['home']);die("test");
				foreach($this->CFG['site']['grid']['home'] as $key=>$val)
					{
						if($link_id == '4'){ break;} // display only 3 table
						
						$row = $this->getTabelRecords($val,$this->CFG['site']['home']['limit'],false,false,'DESC',false,false,'dbObj','garden_details');	
						if($row == ''){
							$this->getGrid($row,$val,$link_id,"No Record Found");
						}else{
							$this->getGrid($row,$val,$link_id);
						}
						
						$link_id++;
					}
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
										echo '<a target="_blank" href="'.$myresult['link'].'">'.strip_tags($myresult['title']).'&nbsp;&nbsp; </a>';?>
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
				$row = $this->getTabelRecords($this->fields_arr['table_name'],$this->CFG['site']['home']['limit'],false,'LAST_UPDT_ON','DESC',$where_cond,false,'dbObj','garden_details');
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
}

//------------------------------------HTML code start from here -------->>>>>>>>//
//Headr include
require_once($CFG['site']['project_path'].'includes/header.php'); 
?>
<?php /* Load the grid*/?> 
	<div class="main">
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
