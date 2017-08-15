<?php

/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/15
 * Time: 下午5:57
 */
class Roleuser extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => array()];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('dao');
    }

    public function index()
    {
        try {
            $raw_data = $this->input->raw_input_stream;
            $data_arr = json_decode($raw_data, true);
            $this->valid_params($data_arr);

            $ret = $this->dao->insert_role_user($data_arr);
            $this->msg['data']['result'] = $ret;

            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params($arr)
    {
        if (!isset($arr['user_id']))
        {
            throw new Exception('user_id is empty', -1);
        }
        if (!is_numeric($arr['user_id']))
        {
            throw new Exception('user_id is not numeric', -2);
        }

        if (!isset($arr['role_id']))
        {
            throw new Exception('role_id is empty', -1);
        }
        if (!is_numeric($arr['role_id']))
        {
            throw new Exception('role_id is not numeric', -2);
        }
        if ($arr['role_id'] == 1 && (!isset($_SESSION['su']) || $_SESSION['su'] !== 1))
        {
            throw new Exception('administrator accounts can only be created by administrators', -3);
        }
    }
}