<?php

/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/4
 * Time: 上午1:04
 */
class Trainstationlist extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => array()];

    public function __construct()
    {
        parent::__construct();
        $this->config->load('api_settings');
        $this->load->library('dao');
        $this->output->set_content_type('application/json', 'utf-8');
    }

    public function index()
    {
        try {
            $appkey = $this->config->item('juhe_appkey');
            $cities = json_decode($this->curl_from_api($appkey), true);
            $ret = $this->dao->update_train_station_list($cities['result']);
            $this->msg['data']['result'] = $ret;
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_content_type('application/json', 'utf-8');
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function curl_from_api($appkey)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://apis.juhe.cn/train/station.list.php?key={$appkey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 35d1ef13-3066-24ee-4a26-4f643c14aed7"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new Exception('cURL Error #' . $err);
        } else {
            return $response;
        }
    }
}