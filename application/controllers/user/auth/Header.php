<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/14
 * Time: 下午10:57
 */

class Header extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('header');
    }
}