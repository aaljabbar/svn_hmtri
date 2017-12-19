<?php

/*
  classname :  Deductiontype
  Date      : 18-12-2017 04:08:50
 
 */
class Deductiontype extends Abstract_model {

    public $table           = 'deductiontype';
    public $pkey            = 'deductiontype_id';
    public $alias           = 'deductiontype';

    public $fields          = array(
								'deductiontype_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Deductiontype Id' ),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Code' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'action'=> array (  'type' => 'int' , 'nullable' => true , 'unique' => false , 'display' =>  'Action' )
                            );

    public $selectClause    =   " 
									deductiontype.deductiontype_id,
 									deductiontype.code,
 									deductiontype.description,
 									deductiontype.created_by,
 									deductiontype.update_by,
 									deductiontype.created_date,
 									deductiontype.update_date,
 									deductiontype.action
                                ";
    public $fromClause      = " deductiontype deductiontype ";

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
			
			$this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];

            unset($this->record['created_date']);
            unset($this->record['updated_date']);
			
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception
			
			$this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Icons.php */