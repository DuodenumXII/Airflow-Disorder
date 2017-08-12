<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/13
 * Time: 上午12:13
 */

class Logout extends CI_Controller
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
            unset($_SESSION['user']);
            unset($_SESSION['role']);
            unset($_SESSION['perm']);
            unset($_SESSION['su']);
            $this->msg['data']['result'] = true;
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }
}