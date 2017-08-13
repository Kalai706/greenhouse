<?php
 

class CommonClass
	{
		/**
		 * @var		string common error messsage
		 */
		protected $common_error_message = '';
		/**
		 * @var		string common success messsage
		 */
		protected $common_success_message = '';
		/**
		 * @var		string common alert messsage
		 */
		protected $common_alert_message = '';
		/**
		 * @var		array array of form fields
		 */
		protected $fields_arr = array();
		/**
		 * @var		array array of error tips for fields
		 */
		protected $fields_err_tip_arr = array();
		/**
		 * @var		array array of form block show status
		 */
		protected $page_block_show_stat_arr = array();	//Array of Page Block show status
		/**
		 * @var		array array of css class
		 */
		protected $css_class_arr = array();
		
		

	   /**
		* Constructor
		*
		* When object is initiated, constructor method is called immediately.
		*
		* @return 		void
		* @access 		public
		*/
		public function __construct()
			{
				global $CFG, $db;
				if (isset($CFG))
					{
						$this->CFG = $CFG;
					}
				if (isset($db))
					{
						$this->setDBObject($db);						
					}
				
			} 

	   /**
		* To set the form fields
		*
		* Before using form fields, set the form field using this method.
		* we can set the default value to the form fields
		*
		* @param 		string $field_name Form field name
		* @param 		string $field_value Form field value
		* @param		int $validation_scheme number having bits set for the required validation
		* @return 		void
		* @access 		public
		*/
		public function setFormField($field_name, $field_value, $validation_scheme = null, $custom_validation_fun_name = null)
			{	
				$this->fields_arr[$field_name] = $field_value;
				if (isset($validation_scheme))
					{
						$this->validation_scheme_arr[$field_name] = $validation_scheme;
						$this->custom_validation_fun_name[$field_name] = $custom_validation_fun_name;
					}
			}

	   /**
		* To get the form field
		*
		* To get the form field value after setting the form field value
		*
		* @param 		string $field_name Form field name
		* @return 		string $this->fields_arr[$field_name] Form field value
		* @access 		public
		*/
		public function getFormField($field_name)
			{
				return $this->fields_arr[$field_name];
			}
			
		/**
		 * CommonClass::setDBObject()
		 * To connect database
		 *
		 * @param $dbObj
		 * @return
		 **/
		public function setDBObject($dbObj)
			{
				$this->dbObj = $dbObj;
			}
			
		/**
        * To check whether the form is posted
        *
        * @param 		array $post_arr
		* @param 		string $form_submit_name submit field name
        * @return 		array Array posted variables
		* @access 		public
        */
		public function isFormPOSTed($post_arr, $form_submit_name='')
			{
				return $form_submit_name ? isset($post_arr[$form_submit_name]) : $post_arr;
			}

	/**
        * To santize the form fields
        *
        * @param 		array $request_arr GET/ POST
        * @return 		void
		* @access 		public
        */
		public function sanitizeFormInputs($request_arr) //GET or POST
			{	
				foreach($this->fields_arr as $field_name=>$default_value)
					{
						if (isset($request_arr[$field_name]))
							{
								if (is_string($request_arr[$field_name]))
									{
										//$this->fields_arr[$field_name] =htmlspecialchars( urldecode(trim($request_arr[$field_name])));
										if(isset($this->regexarray) AND in_array($field_name,$this->regexarray))
											{
												$this->fields_arr[$field_name] =htmlspecialchars( trim($request_arr[$field_name]));
											}
										else
											{
												$this->fields_arr[$field_name] =htmlspecialchars( urldecode(trim($request_arr[$field_name])));
											}
									}
								  else if (is_array($request_arr[$field_name]))
									{
										foreach($request_arr[$field_name] as $sub_key=>$sub_value)
											{
												$this->fields_arr[$field_name][$sub_key] =htmlspecialchars( urldecode(trim($sub_value)));
											}
									}
								  else //unexpected as of now. if occurred, make a note so as to fix.
								  		trigger_error('Developer Notice: Unexpected field type ('.gettype($request_arr[$field_name]).'). FormHandler needs fix.', E_USER_ERROR);
							}
						  else
						  	{
								$this->fields_arr[$field_name] = $default_value;
							}
					}
			}	
			
		/**
		 * To get the records from table
		 * @param $table
		 * @param $limit
		 * @param $fields
		 * @param $orderbyfield
		 * @param $order
		 * @param $cond
		 * @param $groupby
		 * @access public  
		 *
		 */
		public function getTabelRecords($table,$limit,$fields=false,$orderbyfield=false,$order="DESC",$cond=false,$groupby=false)
			{	
				$fields = ($fields) ? $fields : '*';
				$sql = "SELECT ".$fields." FROM ".$this->CFG['db']['tbl'][$table];
				if($cond)
					$sql .= " WHERE ".$cond; 
				if($groupby)	
					$sql .= " GROUP BY ".$groupby;
				if($orderbyfield)	
					$sql .= " ORDER BY ".$orderbyfield." ".$order;
				if($limit)
					$sql .= " LIMIT ".$limit;
				//echo $sql;
				$result = mysqli_query($this->dbObj,$sql);
				$row = false;
				while($results=mysqli_fetch_assoc($result))
					{
						$row[]=$results;
					}				
				return $row;
			}
	}


 
?>