<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/20
 * Time: 下午4:11
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

            $ret = $this->dao->insert_admin_todo($data_arr);
            $this->msg['data']['result'] = $ret;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params(&$arr)
    {
        if (!isset($arr['type']))
        {
            throw new Exception('type is empty', -1);
        }
        if (!in_array($arr['type'], ['注册', '商品上架']))
        {
            throw new Exception('illegal type', -2);
        }

        if (!isset($arr['from']))
        {
            throw new Exception('from is empty', -1);
        }
        if (!is_numeric($arr['from']))
        {
            throw new Exception('from is not numeric', -2);
        }

        if (!isset($arr['func']))
        {
            throw new Exception('func is empty', -1);
        }
        if (!is_string($arr['func']))
        {
            throw new Exception('func is not a string', -2);
        }

        if (!isset($arr['param']))
        {
            throw new Exception('param is empty', -1);
        }
        if (!is_array($arr['param']))
        {
            throw new Exception('param is not array', -2);
        }

        if (!isset($arr['detail']))
        {
            throw new Exception('detail is empty', -1);
        }
        if (!is_array($arr['detail']))
        {
            throw new Exception('detail is not array', -2);
        }

        $arr['param'] = json_encode($arr['param'], JSON_UNESCAPED_UNICODE);
        $arr['detail'] = json_encode($arr['detail'], JSON_UNESCAPED_UNICODE);
    }
}