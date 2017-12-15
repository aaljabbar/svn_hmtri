<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Period_controller
* @version 07/05/2015 12:18:00
*/
class Background_job_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',10);
        $sidx = getVarClean('sidx','str','job_control_id');
        $sord = getVarClean('sord','str','asc');

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('process/background_job');
            $table = $ci->background_job;
            
            $req_param = array(
                "sort_by" => $sidx,
                "sord" => $sord,
                "limit" => null,
                "field" => null,
                "where" => null,
                "where_in" => null,
                "where_not_in" => null,
                "search" => $_REQUEST['_search'],
                "search_field" => isset($_REQUEST['searchField']) ? $_REQUEST['searchField'] : null,
                "search_operator" => isset($_REQUEST['searchOper']) ? $_REQUEST['searchOper'] : null,
                "search_str" => isset($_REQUEST['searchString']) ? $_REQUEST['searchString'] : null
            );

            // Filter Table
            $req_param['where'] = array();
            //print_r($input_data_control_id);exit;
            $table->setJQGridParam($req_param);
            $count = $table->countAll();

            if ($count > 0) $total_pages = ceil($count / $limit);
            else $total_pages = 1;

            if ($page > $total_pages) $page = $total_pages;
            $start = $limit * $page - ($limit); // do not put $limit*($page - 1)

            $req_param['limit'] = array(
                'start' => $start,
                'end' => $limit
            );

            $table->setJQGridParam($req_param);

            if ($page == 0) $data['page'] = 1;
            else $data['page'] = $page;

            $data['total'] = $total_pages;
            $data['records'] = $count;

            $data['rows'] = $table->getAll();
            $data['success'] = true;

        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    function crud() {

        $data = array();
        $oper = getVarClean('oper', 'str', '');
        switch ($oper) {
            case 'add' :

            break;

            case 'edit' :
                
            break;

            case 'del' :
               
            break;

            default :
               // permission_check('view-batch-billing');
                $data = $this->read();
            break;
        }

        return $data;
    }

    function read_daemon() {
        $ci =& get_instance();
        $ci->load->model('process/background_job');
        $table = $ci->background_job;

        $items = array();
        $sql = "SELECT job, 
                       schema_user, 
                       to_char(last_date, 'DD-MON-YYYY HH24:MI:SS') as last_date, 
                       to_char(next_date, 'DD-MON-YYYY HH24:MI:SS') as next_date, 
                       total_time, 
                       broken, 
                       failures, 
                       procedure_name 
                FROM v_daemon";
        $query = $table->db->query($sql);

        if( $query->num_rows() > 0 ){
            $items['success'] = true;
            $items['data'] = $query->row_array();
        }else{
            $items['success'] = false;
            $items['data'] = array();
        }


        echo json_encode( $items );
        exit;
    }

    function start_daemon(){
        $ci = & get_instance();
        $ci->load->model('process/background_job');
        $table = $ci->background_job;

        $items = array();
        $status = $table->start_daemon();

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function force_scheduler(){
        $ci = & get_instance();
        $ci->load->model('process/background_job');
        $table = $ci->background_job;

        $items = array();
        $status = $table->force_scheduler();

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function stop_daemon(){
        $ci = & get_instance();
        $ci->load->model('process/background_job');
        $table = $ci->background_job;

        $items = array();
        $status = $table->stop_daemon();

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

}

/* End of file Period_controller.php */