<?php

/*
  classname :  Deduction
  Date      : 12-12-2017 02:31:46
 
 */
class Deduction extends Abstract_model {

    public $table           = 'deduction';
    public $pkey            = 'deduction_id';
    public $alias           = '';

    public $fields          = array(
								'deduction_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Deduction Id' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'deductiontype_id'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Deduction type' ),
 								'deduct_amount'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Deduct Amount' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'valid_from'=> array (  'type' => 'date' , 'nullable' => false , 'unique' => false , 'display' =>  'Valid From' ),
 								'valid_until'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Valid Until' )
                            );

    public $selectClause    =   " * ";
    public $fromClause      = " v_deduction ";

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
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);

            if($this->record['valid_from'] != "") {
                $this->db->set('valid_from',"to_date('".$this->record['valid_from']."','yyyy-mm-dd')",false);
            }

            if($this->record['valid_until'] != "") {
                $this->db->set('valid_until',"to_date('".$this->record['valid_until']."','yyyy-mm-dd')",false);
            }
            
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['update_by'] = $userdata['user_name'];

            unset($this->record['valid_from']);
            unset($this->record['valid_until']);
            
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception

            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);

            if($this->record['valid_from'] != "") {
                $this->db->set('valid_from',"to_date('".$this->record['valid_from']."','yyyy-mm-dd')",false);
            }

            if($this->record['valid_until'] != "") {
                $this->db->set('valid_until',"to_date('".$this->record['valid_until']."','yyyy-mm-dd')",false);
            }

            $this->record['update_by'] = $userdata['user_name'];

            unset($this->record['valid_from']);
            unset($this->record['valid_until']);
        }
        return true;
    }

    function comboDeductionType(){
        $sql = "SELECT   deductiontype_id, code || '-' || description AS description
                    FROM   deductiontype";
        $query = $this->db->query($sql);
        $items = $query->result_array();
        return $items;
    }

}

/* End of file Icons.php */