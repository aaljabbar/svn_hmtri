<?php

/*
  classname :  Allowancedetail
  Date      : 19-12-2017 05:33:42
 
 */
class Allowancedetail extends Abstract_model {

    public $table           = 'allowancedetail';
    public $pkey            = 'allowancedet_id';
    public $alias           = 'allowancedetail';

    public $fields          = array(
								'allowancedet_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allowancedet Id' ),
 								'allow_batch_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allow Batch Id' ),
 								'allowance_type_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowance Type Id' ),
 								'allowance_dat'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowance Dat' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'allowancetrf_id'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Allowancetrf Id' )
                            );

    public $selectClause    =   " 
									allowancedetail.allowancedet_id,
 									allowancedetail.allow_batch_id,
 									allowancedetail.allowance_type_id,
 									allowancedetail.allowance_dat,
 									allowancedetail.description,
 									allowancedetail.created_date,
 									allowancedetail.created_by,
 									allowancedetail.update_by,
 									allowancedetail.update_date,
 									allowancedetail.allowancetrf_id
                                ";
    public $fromClause      = " allowancedetail allowancedetail ";

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