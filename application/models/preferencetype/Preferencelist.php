<?php

/**
 * Users Model
 *
 */
class Preferencelist extends Abstract_model {

    public $table           = "preferencelist";
    public $pkey            = "p_reference_list_id";
    public $alias           = "prl";

    public $fields          = array(
                                'p_reference_list_id'     => array('pkey' => true,'nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Reference List ID'),
                                'code'    => array('nullable' => false, 'type' => 'str', 'unique' => true, 'display' => 'Code'),
                                'p_reference_type_id'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Reference Type ID'),
                                'reference_name'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Reference Name'),
                                'listing_no'    => array('nullable' => false, 'type' => 'int', 'unique' => false, 'display' => 'Listing No'),
                                 'description'    => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Description'),
                                'creation_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Creation Date'),
                                'created_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Created Date'),
                                'created_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Created By'),
                                'updated_date'      => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'Updated Date'),
                                'updated_by'        => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Updated By'),
                            );

    public $selectClause    = " 
                                prl.p_reference_list_id,
                                prl.code,
                                prl.p_reference_type_id,
                                prl.reference_name,
                                prl.listing_no,
                                prl.description,
                                prl.creation_date,
                                prl.created_by,
                                prl.updated_date,
                                prl.updated_by

                              ";
    public $fromClause      = "preferencelist prl
                               left join preferencetype prt on prl.p_reference_type_id = prt.p_reference_type_id";

    public $refs            = array();

    function __construct() {
        parent::__construct();
    }

    function validate() {
        
        $ci =& get_instance();
        $userdata = $ci->session->userdata;
		
		//$maxprl = $this->db->select('select max(prl.p_reference_list_id)+1');
		//$query = $this->db->get('preferencelist');
					
        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['created_date'] = date('Y-m-d');
            //$this->record['updated_date'] = date('Y-m-d');
			
            //$this->db->set('p_reference_list_id',$maxprl,false);
            $this->db->set('creation_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['created_by'] = $userdata['user_name'];
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];


           /* if (isset($this->record['user_password'])){
                if (trim($this->record['user_password']) == '') throw new Exception('Password Field is Empty');
                if (strlen($this->record['user_password']) < 4) throw new Exception('Mininum password length is 4 characters');
                $this->record['user_password'] = md5($this->record['user_password']);
            }*/
			
            unset($this->record['creation_date']);
            unset($this->record['updated_date']);
			//unset($this->record['p_reference_list_id']);

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
           /* if(empty($this->record['user_password'])){
                unset($this->record['user_password']);    
            }*/
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['updated_by'] = $userdata['user_name'];

        }
        return true;
    }

}

/* End of file Users.php */