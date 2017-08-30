<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/28
 * Time: 上午6:22
 */

class Order extends CI_Controller
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

            $ret = $this->dao->update_order($data_arr);
            $this->msg['data']['result'] = $ret;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params(&$arr)
    {
        if (!isset($arr['money']))
        {
            throw new Exception('money is empty', -1);
        }
        if (!is_numeric($arr['money']))
        {
            throw new Exception('money is not numeric', -2);
        }

        if (!isset($arr['order_id'])) {
            throw new Exception('order_id is empty', -1);
        }
        if (!is_string($arr['order_id'])) {
            throw new Exception('order_id is not a string', -2);
        }

        if (!isset($arr['status'])) {
            throw new Exception('status is empty', -1);
        }
        if (!in_array($arr['status'], ['1', '2'])) {
            throw new Exception('status format error', -2);
        }
    }
}