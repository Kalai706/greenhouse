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
require_once($CFG['site']['project_path'].'config/config.user.php');
require_once($CFG['site']['project_path'].'commons/class_common.php');
//---------------------------------------------------------------------------// 
class Index extends CommonClass
	{
		public function chkUser()
			{
				$is_ok = false;
				if($this->CFG['user']['pass'] == $this->fields_arr['password'] && $this->CFG['user']['name'] == $this->fields_arr['username'])
					{
						$is_ok = true;
					}
				else
					{	
				     	$is_ok = false;
						$this->setCommonErrorMsg('Invalid Login Details');				
					}
				return $is_ok;		
			}

	}
//---------------------------------index end------------------->>>>>>//

$index = new Index();
$index->setFormField('username','');
$index->setFormField('password','');
$index->setFormField('grid_table_name','');
$index->sanitizeFormInputs($_REQUEST);

//Header Include
getMetaTags('metatitle','Home');
getMetaTags('metadescription','Home'); 
getMetaTags('metakeyword','Home');
if($index->isFormPOSTed($_POST,'username'))
{
	if($index->chkUser()){
		$index->saveUserVarsInSession();
		Redirect2URL(getUrl('ciasdata'));
		exit();
	}	
}
//------------------------------------HTML code start from here -------->>>>>>>>//
//Headr include
require_once($CFG['site']['project_path'].'includes/header.php'); 
?>
<?php /* Top referesh start from here*/?> 
<div class="header">
	<div class="container1">
		<div class="logo col-md-12 col-sm-12 col-xs-12 text-center">
			<a href="#"><img src="images/logo.png"/></a>
		</div>		 
	</div>
</div>	
<div class="container">
<div class="row">
	<div class="col-md-6">
  <form class="form-signin" role="form" method="post" name="form-signin" id="form-signin">
	<h2 class="form-signin-heading">Please sign in</h2>
	<?php if($index->getCommonErrorMsg()){?>
		<div class="alert alert-warning"><?php echo $index->getCommonErrorMsg();?></div>
	<?php } ?>
	<!--input type="email" class="form-control" placeholder="Email address" required autofocus-->
	<input type="text" class="form-control" placeholder="Username" required autofocus id="username" name="username" value="<?php echo $index->getFormField('eusername')?>">
	<br/>
	<input type="password" class="form-control" placeholder="Password" required id="password" name="password" value="<?php echo $index->getFormField('password')?>">
	<br/>
	<!--  label class="checkbox">
	  <input type="checkbox" value="remember-me"> Remember me&nbsp;&nbsp;   
	  <a href="register.php">Register</a>
	</label-->
	<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
  </form>
  </div>
  </div>
</div>
<?php
//Include Footer
require_once($CFG['site']['project_path'].'includes/footer.php');
?>

