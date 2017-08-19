<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/19
 * Time: 下午2:23
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

            $ret = $this->dao->insert_order($data_arr)->result_array();
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
        if (!in_array($arr['type'], ['train', 'flight', 'hotel', 'commodity']))
        {
            throw new Exception('illegal type', -2);
        }

        if (!isset($arr['seller'])) {
            throw new Exception('seller is empty', -1);
        }
        if (!is_numeric($arr['seller'])) {
            throw new Exception('seller is not numeric', -2);
        }

        if (!isset($arr['price'])) {
            throw new Exception('price is empty', -1);
        }
        if (!is_numeric($arr['price'])) {
            throw new Exception('price is not numeric', -2);
        }

        if (!isset($arr['detail'])) {
            throw new Exception('detail is empty', -1);
        }
        if (!is_array($arr['detail'])) {
            throw new Exception('detail is not array', -2);
        }

        $arr['detail'] = json_encode($arr['detail']);
    }
}