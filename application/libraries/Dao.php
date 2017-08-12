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
            throw new Exception('failed to query database', -1001);
        }
        return $ret;
    }

    public function query_user_perms($user_id)
    {
        $this->valid_dao();
        $ret = $this->dao_handler->query("SELECT res.res_uri, res.res_desc, r.role_id, r.role_name, r.role_desc
	, r.su
FROM tb_user u
	LEFT JOIN tb_role_user ru ON ru.user_id = u.user_id
	LEFT JOIN tb_role r ON r.role_id = ru.role_id
	LEFT JOIN tb_role_resource rr ON rr.role_id = r.role_id
	LEFT JOIN tb_resource res ON find_in_set(res.res_id, rr.resource_id)
WHERE u.user_id = {$user_id}");

        if (is_null($ret))
        {
            throw new Exception('failed to query database', -1001);
        }
        return $ret;
    }

    public function query_user_info($name, $password)
    {
        $this->valid_dao();
        $ret = $this->dao_handler->select('user_id, user_name, user_icon, create_time, update_time')->get_where('tb_user', array('user_name' => $name, 'user_password' => $password));

        if (is_null($ret))
        {
            throw new Exception('failed to query database', -1001);
        }
        return $ret;
    }

    public function query_user_role($user_id)
    {
        $this->valid_dao();
        $ret = $this->dao_handler->get_where('tb_role_user', array('user_id' => $user_id));

        if (is_null($ret))
        {
            throw new Exception('failed to query database', -1001);
        }
        return $ret;
    }
}