<?php

class Dao
{
    private $dao_handler;
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->dao_handler = $this->CI->load->database('default', true);
//        var_dump($this->dao_handler);
//        exit;
        if (!$this->dao_handler)
        {
            throw new Exception('failed to connect to database', -1000);
        }
    }

    private function valid_dao()
    {
        if (!$this->dao_handler)
        {
            throw new Exception('failed to connect to database', -1000);
        }
    }

    public function update_train_station_list($arr)
    {
        $this->valid_dao();
        $sql = 'INSERT INTO tb_train_city (name, ename, code) VALUES ';
        $values = array();
        foreach($arr as $item)
        {
            $values []= "('{$item['sta_name']}', '{$item['sta_ename']}', '{$item['sta_code']}')";
        }
        $sql .= implode(', ', $values);
        $sql .= ' ON DUPLICATE KEY UPDATE name = VALUES(name), ename = VALUES(ename)';
        $ret = $this->dao_handler->query($sql);

        if (is_null($ret))
        {
            throw new Exception('failed to update database', -1001);
        }
        return $ret;
    }

    public function query_train_station_list()
    {
        $this->valid_dao();
        $ret = $this->dao_handler->get('tb_train_city');

        if (is_null($ret))
        {
            throw new Exception('failed to update database', -1001);
        }
        return $ret;
    }
}