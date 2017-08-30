<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/28
 * Time: 上午7:09
 */

class Searchlist extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('hotel/list');
        $this->load->view('footer');
    }
}