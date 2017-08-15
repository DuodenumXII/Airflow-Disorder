<?php
/**
 * Created by PhpStorm.
 * User: liujianwei
 * Date: 17/8/5
 * Time: 上午4:08
 */

class Traininfo extends CI_Controller
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

            $train_info = $this->curl_from_api($data_arr['name'], $appkey);
            $this->msg['data'] = $train_info;
            $this->output->set_output(json_encode($this->msg));
        } catch (Exception $e) {
            $this->output->set_output(json_encode(['err_code' => $e->getCode(), 'err_msg' => $e->getMessage()]));
        }
    }

    private function valid_params(&$arr)
    {
        if (!isset($arr['name']))
        {
            throw new Exception('name is empty', -1);
        }
        if (!is_string($arr['name']))
        {
            throw new Exception('name is not a string', -2);
        }
    }

    private function curl_from_api($name, $appkey)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://apis.juhe.cn/train/s?name={$name}&key={$appkey}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: 522ac0ae-0e54-78fd-07c9-d136a4c88f42"
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