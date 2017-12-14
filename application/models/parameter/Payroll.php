<?php

/**
 * Icons Model
 *
 */
class Payroll extends Abstract_model {

    public $table           = "pyrcode";
    public $pkey            = "pyr_code_id";
    public $alias           = "a";

    public $fields          = array(
                                'pyr_code_id'            => array('pkey' => true, 'type' => 'int', 'nullable' => true, 'unique' => true, 'display' => 'ID'),
                                'pyr_ext_id'           => array('nullable' => false, 'type' => 'str', 'unique' => false, 'display' => 'Payroll Name'),
                                'pyr_code_type'    => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'Payroll'),

                                'created_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'created date'),
                                'create_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'created by'),
                                'updated_date'          => array('nullable' => true, 'type' => 'date', 'unique' => false, 'display' => 'updated date'),
                                'update_by'            => array('nullable' => true, 'type' => 'str', 'unique' => false, 'display' => 'updated by'),

                            );

    public $selectClause    = "a.* ,
                             b.pyrtype_code || ' - ' || b.pyrtype_desc pyr_code,
                             (case
                                 when a.pyr_code_type = 2
                                 then
                                    (select   c.code || ' - ' || c.description
                                       from   deductiontype c
                                      where   a.pyr_ext_id = c.deductiontype_id)
                                 when a.pyr_code_type = 1
                                 then
                                    (select   d.code || ' - ' || d.desc_allowance
                                       from   allowancetype d
                                      where   a.pyr_ext_id = d.allowance_type_id)
                                 when a.pyr_code_type = 3
                                 then
                                    (select   e.code || ' - ' || e.desc_adjtype
                                       from   adjtype e
                                      where   a.pyr_ext_id = e.adjtype_id)
                              end)
                                pyr_name";
    public $fromClause      = " pyrcode a
                                LEFT JOIN pyrcodetype b
                                ON a.pyr_code_type = b.pyr_code_type
                                ";

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
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->db->set('created_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['create_by'] = $userdata['user_name'];
            $this->record['update_by'] = $userdata['user_name'];

            $this->record[$this->pkey] = $this->generate_id($this->table, $this->pkey);

        }else {
            //do something
            //example:
            $this->db->set('updated_date',"to_date('".date('Y-m-d')."','yyyy-mm-dd')",false);
            $this->record['update_by'] = $userdata['user_name'];
            //if false please throw new Exception
        }
        return true;
    }

    function combo(){
        try {
            $sql = "SELECT pyr_code_type, 
                        pyrtype_code || ' - ' || pyrtype_desc code  
                    FROM PYRCODETYPE
                    WHERE pyr_code_type != 4";
            $query = $this->db->query($sql);

            $items = $query->result_array();
            echo '<select id="pyr_code_type" class="form-control " name="pyr_code_type" onchange="getval(this);">';
            echo '<option value="">-- Select Payroll Code --</option>';
            foreach($items  as $item ){
                echo '<option value="'.$item['pyr_code_type'].'">'.$item['code'].'</option>';
            }
            echo '</select>';
            exit;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        
    }

}

/* End of file Icons.php */