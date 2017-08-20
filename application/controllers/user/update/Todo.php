<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/20
 * Time: 下午9:11
 */

class Todo extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => array()];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('dao');
        $this->output->set_content_type('application/json', 'utf-8');
    }

    public function index()
    {
        try {
            $raw_data = $this->input->raw_input_stream;
            $data_arr = json_decode($raw_data, true);
            $this->valid_params($data_arr);

            if ($data_arr['status'] == 1)
            {
                $ret = $this->dao->query_admin_todo(array('id' => $data_arr['id']))->row_array();
                $func = $ret['func'];
                $param = json_decode($ret['param'], true);
                $this->dao->$func($param);
            }

            $ret = $this->dao->update_admin_todo($data_arr);
            $this->msg['data']['result'] = $ret;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params($arr)
    {
        if (!isset($arr['status']))
        {
            throw new Exception('status is empty', -1);
        }
        if (!in_array($arr['status'], ['0', '1', '2', '3', '4']))
        {
            throw new Exception('illegal status', -2);
        }

        if (!isset($arr['id']))
        {
            throw new Exception('id is empty', -1);
        }
        if (!is_numeric($arr['id']))
        {
            throw new Exception('id is not numeric', -2);
        }
    }
}