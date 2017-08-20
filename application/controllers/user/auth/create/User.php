<?php

/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/15
 * Time: 下午5:20
 */
class User extends CI_Controller
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

            $ret = $this->dao->query_user_exist(array('user_name' => $data_arr['user_name']))->result_array();
            if (count($ret) != 0)
            {
                throw new Exception('用户名已存在', -1001);
            }

//            $ret = $this->dao->insert_user($data_arr);
            $ret = $this->dao->insert_admin_todo(array(
                'type' => '注册',
                'from' => 0,
                'func' => 'insert_user',
                'param' => json_encode($data_arr, JSON_UNESCAPED_UNICODE),
                'status' => 0,
                'detail' => json_encode(array(
                    '注册角色' => $data_arr['role_id'],
                    '用户名' => $data_arr['user_name']
                ), JSON_UNESCAPED_UNICODE)
            ));
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
        if (!isset($arr['user_name']))
        {
            throw new Exception('name is empty', -1);
        }
        if (!is_string($arr['user_name']))
        {
            throw new Exception('name is not a string', -2);
        }

        if (!isset($arr['user_password']))
        {
            throw new Exception('password is empty', -1);
        }
        if (!is_string($arr['user_password']))
        {
            throw new Exception('password is not a string', -2);
        }

        if (isset($arr['user_icon']) && !parse_url($arr['user_icon']))
        {
            throw new Exception('icon is not a link', -2);
        }

        if (!isset($arr['role_id']))
        {
            throw new Exception('role_id is empty', 1);
        }

        if ($arr['role_id'] == 1 && (!isset($_SESSION['su']) || $_SESSION['su'] !== 1))
        {
            throw new Exception('administrator accounts can only be created by administrators', -3);
        }

        if (!is_numeric($arr['role_id']))
        {
            throw new Exception('role_id is not numeric', -2);
        }
    }
}