<?php

/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/11
 * Time: 上午11:00
 */
class Login extends CI_Controller
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
            $arr = json_decode($this->input->raw_input_stream, true);
            $this->valid_params($arr);
            $user_info = $this->dao->query_user_info($arr['name'], $arr['password'])->row_array();
            if (count($user_info) == 0)
            {
                throw new Exception('ERROR Incorrect username or password', -100);
            }
            $role = $this->dao->query_user_role($user_info['user_id'])->result_array();
            if (count($role) == 0)
            {
                throw new Exception('The user has not yet been assigned a role', -101);
            }

            $login = $this->dao->query_user_perms($user_info['user_id'])->result_array();

            $this->save_user_perms($user_info, $login);

            $this->msg['data']['user'] = $_SESSION['user'];
            $this->msg['data']['role'] = $_SESSION['role'];
            $this->msg['data']['perm'] = $_SESSION['perm'];

            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params($arr)
    {
        if (!isset($arr['name']))
        {
            throw new Exception('name is empty', -1);
        }
        if (!is_string($arr['name']))
        {
            throw new Exception('name is not string', -2);
        }

        if (!isset($arr['password']))
        {
            throw new Exception('password is empty', -1);
        }
        if (!is_string($arr['password']))
        {
            throw new Exception('password is not string', -2);
        }
    }

    private function save_user_perms($user_info, $login)
    {
        setcookie('my_session_id', session_id());
        $_SESSION['user'] = $user_info;
        $_SESSION['role'] = array();
        $_SESSION['perm'] = array();
        $_SESSION['su'] = 0;
        foreach ($login as $item)
        {
            $flag = 1;
            foreach ($_SESSION['role'] as $role)
            {
                if ($role['role_id'] == $item['role_id'])
                {
                    $flag = 0;
                }
            }

            if ($flag == 1)
            {
                $_SESSION['role'] []= array(
                    'role_id' => $item['role_id'],
                    'role_name' => $item['role_name'],
                    'role_desc' => $item['role_desc']
                );
            }

            $flag = 1;
            foreach ($_SESSION['perm'] as $perm)
            {
                if ($perm['uri'] == $item['res_uri'])
                {
                    $flag = 0;
                }
            }

            if ($flag == 1)
            {
                $_SESSION['perm'] []= array(
                    'uri' => $item['res_uri'],
                    'desc' => $item['res_desc']
                );
            }

            if ($item['su'] == '1')
            {
                $_SESSION['su'] = 1;
            }
        }
    }
}