<?php

/*
  classname :  Allowancebatchs
  Date      : 19-12-2017 05:33:00
 
 */
class Allowancebatchs extends Abstract_model {

    public $table           = 'allowancebatchs';
    public $pkey            = 'allow_batch_id';
    public $alias           = 'allowancebatchs';

    public $fields          = array(
								'allow_batch_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allow Batch Id' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'period'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Period' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'status'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Status' )
                            );

    public $selectClause    =   " 
									allowancebatchs.allow_batch_id,
 									allowancebatchs.emp_master_id,
 									allowancebatchs.period,
 									allowancebatchs.created_date,
 									allowancebatchs.update_date,
 									allowancebatchs.created_by,
 									allowancebatchs.update_by,
 									allowancebatchs.status
                                ";
    public $fromClause      = " allowancebatchs allowancebatchs ";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {

        $ci =& get_instance();
        $userdata = $ci->session->userdata;

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            /* $this->record['created_date'] = date('Y-m-d');
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name'];
            */
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception
        }
        return true;
    }

}

/* End of file Icons.php */