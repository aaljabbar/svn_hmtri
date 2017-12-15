<?php

/**
 * Groups Model
 *
 */
class Background_job extends Abstract_model {

    public $table           = "user_jobs";
    public $pkey            = "job_control_id";
    public $alias           = "jb";
    public $fields          = array();

    public $selectClause    = "jb.*";
    public $fromClause      = "v_user_jobs jb";

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

    function start_daemon(){
        try {

            $sql = "SELECT PACK_BACKGROUND_SCHEDULER.START_DAEMON as status_job FROM dual";
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

    function force_scheduler(){
        try {

            $sql = "SELECT PACK_BACKGROUND_SCHEDULER.FORCE_SCHEDULER as status_job FROM dual";
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

    function stop_daemon(){
        try {

            $sql = "SELECT PACK_BACKGROUND_SCHEDULER.STOP_DAEMON as status_job FROM dual";
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

}

/* End of file Groups.php */