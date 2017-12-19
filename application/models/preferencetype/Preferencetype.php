<?php

/*
  classname :  Preferencetype
  Date      : 13-12-2017 11:53:35
 
 */
class Preferencetype extends Abstract_model {

    public $table           = 'preferencetype';
    public $pkey            = 'p_reference_type_id';
    public $alias           = 'preferencetype';

    public $fields          = array(
								'p_reference_type_id'=> array (  'pkey' => true,  'type' => 'int' , 'nullable' => false , 'unique' => false , 'display' =>  'P Reference Type Id'),
 								'code'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => true , 'display' =>  'Code' ),
 								'reference_name'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Reference Name' ),
 								'description'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Description' ),
 								'creation_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Creation Date' ),
 								'created_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Created By' ),
 								/*'updated_date'=> array (  'type' => 'date' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated Date' ),*/
 								'updated_by'=> array (  'type' => 'str' , 'nullable' => true , 'unique' => false , 'display' =>  'Updated By' )
                            );

    public $selectClause    =   " 
									preferencetype.p_reference_type_id,
 									preferencetype.code,
 									preferencetype.reference_name,
 									preferencetype.description,
 									preferencetype.creation_date,
 									preferencetype.created_by,
 									preferencetype.updated_date,
 									preferencetype.updated_by
                                ";
    public $fromClause      = " preferencetype preferencetype ";

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