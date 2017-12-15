<?php

/**
 * Groups Model
 *
 */
class Process_billing extends Abstract_model {

    public $table           = "job_control";
    public $pkey            = "job_control_id";
    public $alias           = "jb";
    public $fields          = array();

    public $selectClause    = "jb.*";
    public $fromClause      = "v_job_control jb";

    public $refs            = array();

    function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
        $this->db->_escape_char = ' ';
    }

    function validate() {
        $ci =& get_instance();

        if($this->actionType == 'CREATE') {
            //do something
            // example :
            //$this->record['created_date'] = date('Y-m-d');
            //$this->record['updated_date'] = date('Y-m-d');

            $this->record[$this->pkey] = $this->generate_id($this->table);
        }else {
            //do something
            //example:
            //$this->record['updated_date'] = date('Y-m-d');
            //if false please throw new Exception
        }
        return true;
    }

    function action_submit($name, $input_data_control_id, $username){
        try {

            $sql = "SELECT f_submit_job('".$name."', ".$input_data_control_id.", '".$username."') as status_job FROM dual";
            $query = $this->db->query($sql);

            $items = '';
            if($query->num_rows() > 0){
                $result = $query->row_array();
                $items = $result['status_job'];   
            }

            return $items;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function action_force(){
        try {

            $sql = "SELECT pack_background_scheduler.force_scheduler as status_job FROM dual";
            $query = $this->db->query($sql);

            $items = '';
            if($query->num_rows() > 0){
                $result = $query->row_array();
                $items = $result['status_job'];   
            }

            return $items;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    function cekInputDataClass($id){
        try {

            $sql = "select p_input_file_desc_id from input_data_control where input_data_control_id = ".$id;
            $query = $this->db->query($sql);

            $items = '';
            if($query->num_rows() > 0){
                $result = $query->row_array();
                $items = $result['p_input_file_desc_id'];   
            }

            return $items;

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}

/* End of file Groups.php */