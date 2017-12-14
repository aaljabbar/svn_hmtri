<?php

/*
  classname :  Preferencetype
  Date      : 13-12-2017 11:53:35
 
 */
class P_global_param extends Abstract_model {

    public $table           = 'p_global_param';
    public $pkey            = 'p_global_param_id';
    public $alias           = 'glob';

    public $fields          = array(
								'p_global_param_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'P global param id' ),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Code' ),
 								'value'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Value' ),
 								'type_1'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Type 1' ),                                
                                'is_range'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Is range' ),
                                'value_2'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Value 2' ),
                                'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'creation_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Creation Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								/*'updated_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated Date' ),*/
 								'updated_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated By' )
                            );
    

    public $selectClause    =   " 
									glob.p_global_param_id,
                                    glob.code,
                                    glob.value,
                                    glob.type_1,
                                    glob.is_range,
                                    glob.value_2,
                                    glob.description,
                                    glob.creation_date,
                                    glob.created_by,
                                    glob.updated_date,
                                    glob.updated_by
                                ";
    public $fromClause      = " p_global_param glob ";

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
            $this->db->set('creation_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

            unset($this->record['creation_date']);
            unset($this->record['updated_date']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            /* $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userdata['user_name']; */
            //if false please throw new Exception

            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];
        }
        return true;
    }

}

/* End of file Icons.php */