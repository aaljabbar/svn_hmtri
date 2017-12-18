<?php

/*
  classname :  Allowancetype
  Date      : 18-12-2017 03:57:21
 
 */
class Allowancetype extends Abstract_model {

    public $table           = 'allowancetype';
    public $pkey            = 'allowance_type_id';
    public $alias           = 'allowancetype';

    public $fields          = array(
								'allowance_type_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Allowance Type Id' ),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Code' ),
 								'desc_allowance'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Desc Allowance' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' )
                            );

    public $selectClause    =   " 
									allowancetype.allowance_type_id,
 									allowancetype.code,
 									allowancetype.desc_allowance,
 									allowancetype.created_date,
 									allowancetype.update_date,
 									allowancetype.update_by,
 									allowancetype.created_by
                                ";
    public $fromClause      = " allowancetype allowancetype ";

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