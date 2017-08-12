<?php

/**
 * Created by PhpStorm.
 * User: zheyin.liang
 * Date: 2017/8/11
 * Time: 上午11:00
 */
class Login extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => ''];

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $arr = json_decode($this->input->raw_input_stream);

    }
}