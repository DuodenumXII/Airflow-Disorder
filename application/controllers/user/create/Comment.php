<?php

/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/31
 * Time: 下午4:05
 */
class Comment extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => array()];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('dao');
        $this->load->helper('valid_params');
        $this->output->set_content_type('application/json', 'utf-8');
    }

    public function index()
    {
        try {
            $raw_data = $this->input->raw_input_stream;
            $data_arr = json_decode($raw_data, true);
            $this->valid_params($data_arr);
            $data_arr['user_id'] = $_SESSION['user']['user_id'];

            $ret = $this->dao->insert_comment($data_arr);
            $this->msg['data']['result'] = $ret;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params($arr)
    {
        $to_check_list = array(
            'commodity_id' => 'numeric',
            'parent' => function ($str) use ($arr)
            {
                if (strlen($str) > 0)
                {
                    $ret = $this->dao->query_commodity(array('commodity_id' => $arr['commodity_id']))->row_array();
                    if ($ret['seller'] == $_SESSION['user']['user_id'])
                    {
                        return true;
                    }
                    return false;
                }
                return true;
            },
            'content' => 'string'
        );
        valid_params_checklist($to_check_list, $arr);
    }
}