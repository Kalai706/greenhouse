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
class Info extends CommonClass
	{
		public function insertTextRecord(){
			$text = $this->getFormField('user_info');
			$sql = "INSERT INTO `info` (`info_desc`, `created_date`) VALUES ('$text', CURRENT_TIMESTAMP)";
			$this->insertTabelRecords($sql);
		}
		
		public function getTextTableRecord(){
			$row = $this->getTabelRecords('info',$this->CFG['site']['home']['limit'],false,'created_date','DESC');
			return $row;
		}
	}
//---------------------------------index end------------------->>>>>>//
$obj = new Info();
$obj->setFormField('user_info','');
$obj->sanitizeFormInputs($_REQUEST);
//Header Include
getMetaTags('metatitle','Home');
getMetaTags('metadescription','Home'); 
getMetaTags('metakeyword','Home');


if(!isMember())
{
	Redirect2URL(getUrl('index'));	
}

if($obj->isFormPOSTed($_POST,'submit'))
{
	$obj->insertTextRecord();
}
//------------------------------------HTML code start from here -------->>>>>>>>//
//Headr include
require_once($CFG['site']['project_path'].'includes/header.php'); 
?>
<?php /* Top referesh start from here*/?> 
<div class="header">
	<div class="container1">
		<div class="logo text-center">
			<a href="#"><img src="images/logo.png"/></a>
			<span style="float:right"><a href="<?php echo getUrl('logout');?>">Logout</a></span>
		</div>		
	</div>
</div>
<?php /* Load the grid*/?> 
	<div class="main">
	<div class="container1">
		<div class="col-md-12 audittable">
		<table class="table table-responsive table-bordered grid-table">
					<thead>
						<tr>
							<th>Sno</th>
							<th>Text Description</th>
							<th>Created On</th>
						</tr>
					</thead>
					<tbody class="dynamicdata" id="watchlist_div"> 
						<?php $record = $obj->getTextTableRecord();	
						if(count($record) == 0){
							echo "<tr><td colspan='3'>No Record Found</td></tr>";
						}else{
							$j = 1;
							foreach($record as $key => $value){
						?>				
						<tr>
							<td><?php echo $j;?></td>
							<td><?php echo $value['info_desc'];?></td>
							<td><?php echo $value['created_date'];?></td>
						</tr>
							<?php 
							$j++;
							}
							} ?>
					</tbody>
				</table>
				</div>
		<div>	
			<form id="user_form" name="user_form" method="post">
				<textarea name="user_info" id="user_info" style="width:80%" rows="8"></textarea>
				<input type="submit" name="submit" id="submit" value="Add New Record"/>
			</form>
		</div>
	</div>
</div>
<?php /* assign table names*/?>
<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> 
<script type="text/javascript">
//<![CDATA[
	bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>
</script>
<?php
//Include Footer
require_once($CFG['site']['project_path'].'includes/footer.php');
?>

