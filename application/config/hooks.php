<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_system'] []= function () {
    session_save_path('/data/session');
    if (!session_id())
    {
        if (isset($_COOKIE['my_session_id']))
        {
            session_id($_COOKIE['my_session_id']);
        }
        session_start();
    }
};

$hook['post_controller_constructor'] []= function () {
    try {
        $CI =& get_instance();
        $CI->load->config('white_list');
        $uri = $CI->uri->uri_string();
        $white_list = $CI->config->item('white_list');
        $white_list_limited = $CI->config->item('white_list_limited');

        if (strlen($uri) == 0)
        {
            return;
        }

        foreach ($white_list as $item)
        {
            if (strpos($uri, $item) === 0) {
                return;
            }
        }

        if (isset($_SESSION['user']))
        {
            if ($_SESSION['su'] === 0)
            {
                foreach ($white_list_limited as $item)
                {
                    if (strpos($uri, $item) === 0) {
                        return;
                    }
                }

                foreach ($_SESSION['perm'] as $item) {
                    if (strpos($uri, $item['uri']) === 0) {
                        return;
                    }
                }
                throw new Exception('permission denied!', -2000);
            }
            return;
        }

        throw new Exception('permission denied!', -2000);
    } catch (Exception $e) {
        $CI->output->set_content_type('application/json', 'utf-8');
        $CI->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]))->_display();
        exit;
    }
};