<?php

/*
  classname :  Adjustment
  Date      : 12-12-2017 04:01:53
 
 */
class Adjustment extends Abstract_model {

    public $table           = 'adjustment';
    public $pkey            = 'adjusment_id';
    public $alias           = '';

    public $fields          = array(
								'adjusment_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Adjusment Id' ),
 								'adjtype_id'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Adjtype Id' ),
 								'emp_master_id'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Emp Master Id' ),
 								'adj_date'=> array (  'type' => 'date' , 'nullable' => false , 'unique' => false , 'display' =>  'Adj Date' ),
 								'adj_mny'=> array (  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'Adj Mny' ),
 								'created_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Created Date' ),
 								'update_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Update By' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								'update_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Update Date' )
                            );

    public $selectClause    =   " *  ";
    public $fromClause      = " v_adjusment";

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
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);

            if($this->record['adj_date'] != "") {
                $this->db->set('adj_date',"to_date('".$this->record['adj_date']."','yyyy-mm-dd')",false);
            }
            
            $this->record['created_by'] = $userdata['user_name'];
            $this->record['update_by'] = $userdata['user_name'];

            unset($this->record['adj_date']);
            
            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            $this->db->set('update_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            if($this->record['adj_date'] != "") {
                $this->db->set('adj_date',"to_date('".$this->record['adj_date']."','yyyy-mm-dd')",false);
            }
            $this->record['update_by'] = $userdata['user_name']; 

            unset($this->record['adj_date']);

            //if false please throw new Exception
        }
        return true;
    }

    function comboAdjustmentType(){
        $sql = "SELECT adjtype_id,code ||'-'||desc_adjtype AS desc_adjtype FROM adjtype";
        $query = $this->db->query($sql);
        $items = $query->result_array();
        return $items;
    }

}

/* End of file Icons.php */