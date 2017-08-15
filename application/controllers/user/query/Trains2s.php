<?php

/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/3
 * Time: 下午11:38
 */
class Trains2s extends CI_Controller
{
    private $msg = ['code' => 0, 'msg' => '', 'data' => array()];

    public function __construct()
    {
        parent::__construct();
        $this->config->load('api_settings');
        $this->output->set_content_type('application/json', 'utf-8');
    }

    public function index()
    {
        try {
            $appkey = $this->config->item('juhe_appkey');
            $raw_data = $this->input->raw_input_stream;
            $data_arr = json_decode($raw_data, true);
            $this->valid_params($data_arr);

            $result = $this->curl_from_api($data_arr, $appkey);
            $this->msg['data'] = $result;

            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params(&$arr)
    {
        if (!isset($arr['start']))
        {
            throw new Exception('start is empty', -1);
        }
        if (!is_string($arr['start']))
        {
            throw new Exception('start is not a string', -2);
        }
        if (!isset($arr['end']))
        {
            throw new Exception('end is empty', -1);
        }
        if (!is_string($arr['end']))
        {
            throw new Exception('end is not a string', -2);
        }
        if (isset($arr['date'])) {
            $date = strtotime($arr['date']);
            if ($date === false)
            {
                throw new Exception('date format error', -2);
            }
            $arr['date'] = date('YYYY-mm-dd', $date);
        }
    }

    private function curl_from_api($arr, $appkey)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://apis.juhe.cn/train/s2swithprice?start={$arr['start']}&end={$arr['end']}&key={$appkey}",
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
            return json_decode($response, true);
        }
    }
}