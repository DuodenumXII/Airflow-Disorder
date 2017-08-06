<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/6
 * Time: 上午5:22
 */

class Info extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('train/info');
    }
}