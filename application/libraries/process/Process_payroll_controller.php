<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Json library
* @class Period_controller
* @version 07/05/2015 12:18:00
*/
class Process_billing_controller {

    function read() {

        $page = getVarClean('page','int',1);
        $limit = getVarClean('rows','int',5);
        $sidx = getVarClean('sidx','str','job_control_id');
        $sord = getVarClean('sord','str','desc');
        $input_data_control_id = getVarClean('input_data_control_id','int', 0);

        $data = array('rows' => array(), 'page' => 1, 'records' => 0, 'total' => 1, 'success' => false, 'message' => '');

        try {

            $ci = & get_instance();
            $ci->load->model('process/process_billing');
            $table = $ci->process_billing;
            
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
            $req_param['where'] = array('input_data_control_id = '.$input_data_control_id);
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

    function submit_dekomposisi(){
        $ci = & get_instance();
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $input_data_control_id = getVarClean('input_data_control_id','int', 0);
        
        $status = $table->action_submit('DEKOMPOSISI', $input_data_control_id, $userinfo->username);

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function submit_rerating(){
        $ci = & get_instance();
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $input_data_control_id = getVarClean('input_data_control_id','int', 0);
        $input_data_class_id = $table->cekInputDataClass($input_data_control_id);

        if($input_data_class_id == 1){
            $name = 'EVENT_RERATING_BILM4L'; //rating
        }else{
            $name = 'EVENT_REBILL_M4L'; //billing
        }
        // var_dump($name);
        // exit;
        $status = $table->action_submit($name, $input_data_control_id, $userinfo->username);

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function submit_prabilling(){
        $ci = & get_instance();
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $input_data_control_id = getVarClean('input_data_control_id','int', 0);
        
        $status = $table->action_submit('M4L_BILL_PREPARATION', $input_data_control_id, $userinfo->username);

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function cancel_all_prabilling(){
        $ci = & get_instance();
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $input_data_control_id = getVarClean('input_data_control_id','int', 0);

        $status = $table->action_submit('CANCEL_ALL_BILL_PREPARATION', $input_data_control_id, $userinfo->username);

        if($status == 'SUCCESS'){
            $items['success'] = true;            
        }else{
            $items['success'] = false;
        }

        echo json_encode( $items );
        exit;
    }

    function cancel_last_job_prabilling(){
        $ci = & get_instance();
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $input_data_control_id = getVarClean('input_data_control_id','int', 0);

        $status = $table->action_submit('CANCEL_LAST_JOB_PREPARATION', $input_data_control_id, $userinfo->username);

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
        $ci->load->model('process/process_billing');
        $userinfo = $ci->ion_auth->user()->row();
        $table = $ci->process_billing;

        $status = $table->action_force();

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