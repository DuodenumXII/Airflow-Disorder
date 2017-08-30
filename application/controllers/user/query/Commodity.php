<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/28
 * Time: 上午4:38
 */

class Commodity extends CI_Controller
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

            $ret = $this->dao->query_commodity($data_arr)->result_array();
            $this->msg['data']['result'] = $ret;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params($arr)
    {
        if (isset($arr['id']) && !is_numeric($arr['id']))
        {
            throw new Exception('id is not numeric', -2);
        }

        if (isset($arr['name']) && !is_string($arr['name']))
        {
            throw new Exception('name is not a string', -2);
        }

        if (isset($arr['city']) && !is_string($arr['city']))
        {
            throw new Exception('city is not a string', -2);
        }
    }
}