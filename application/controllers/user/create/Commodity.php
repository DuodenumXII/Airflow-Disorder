<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/28
 * Time: 上午3:09
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
            $data_arr['seller'] = $_SESSION['user']['user_id'];

            $ret = $this->dao->insert_admin_todo(array(
                'type' => '商品',
                'from' => $_SESSION['user']['user_id'],
                'func' => 'insert_commodity',
                'param' => json_encode($data_arr, JSON_UNESCAPED_UNICODE),
                'status' => 0,
                'detail' => json_encode(array(
                    '商品名称' => $data_arr['name'],
                    '城市' => $data_arr['city'],
                    '价格' => $data_arr['price']
                ), JSON_UNESCAPED_UNICODE)
            ));
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
        if (!in_array($arr['type'], ['hotel', 'commodity']))
        {
            throw new Exception('illegal type', -2);
        }

        if (!isset($arr['name']))
        {
            throw new Exception('name is empty', -1);
        }
        if (!is_string($arr['name']))
        {
            throw new Exception('name is not a string', -2);
        }

        if (!isset($arr['price']))
        {
            throw new Exception('price is empty', -1);
        }
        if (!is_numeric($arr['price']))
        {
            throw new Exception('price is not numeric', -2);
        }

        if (!isset($arr['subtitle']))
        {
            throw new Exception('subtitle is empty', -1);
        }
        if (!is_string($arr['subtitle']))
        {
            throw new Exception('subtitle is not a string', -2);
        }

        if (!isset($arr['city']))
        {
            throw new Exception('city is empty', -1);
        }
        if (!is_string($arr['city']))
        {
            throw new Exception('city is not a string', -2);
        }

        if (!isset($arr['introduction']))
        {
            throw new Exception('introduction is empty', -1);
        }
        if (!is_string($arr['introduction']))
        {
            throw new Exception('introduction is not a string', -2);
        }

        if (!isset($arr['detail']))
        {
            throw new Exception('detail is empty', -1);
        }
        if (!is_array($arr['detail']))
        {
            throw new Exception('detail is not array', -2);
        }

        $arr['detail'] = json_encode($arr['detail'], JSON_UNESCAPED_UNICODE);
    }
}