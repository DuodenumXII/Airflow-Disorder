<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/20
 * Time: 上午1:48
 */

class Usercenter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('header');
        foreach ($_SESSION['role'] as $role)
        {
            if ($role['role_id'] == 1)
            {
                $this->load->view('user-center-admin');
                break;
            }
            if ($role['role_id'] == 2)
            {
                $this->load->view('user-center-seller');
                break;
            }
            if ($role['role_id'] == 3)
            {
                $this->load->view('user-center-common');
                break;
            }
        }
        $this->load->view('footer');
    }
}