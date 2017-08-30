<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/27
 * Time: 下午10:20
 */

class Info extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('hotel/info');
        $this->load->view('footer');
    }
}
