<?php

/**
 * Groups Model
 *
 */
class Log_payroll extends Abstract_model {

    public $table           = "log_background_job";
    public $pkey            = "job_control_id";
    public $alias           = "log";

    public $fields          = array();

    public $selectClause    = "log.job_control_id, log.counter_no, to_char(log.log_date, 'DD/MM/YYYY HH24:MI:SS PM') as log_date, log.log_message";
    public $fromClause      = "log_background_job log";

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

}

/* End of file Groups.php */