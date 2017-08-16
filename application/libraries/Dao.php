<?php

class Dao
{
    private $db_handle;
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->db_handle = $this->CI->load->database('default', true);
//        var_dump($this->db_handle);
//        exit;
        if (!$this->db_handle)
        {
            throw new Exception($this->db_handle->error()['message'], -1000);
        }
    }

    private function valid_dao()
    {
        if (!$this->db_handle)
        {
            throw new Exception($this->db_handle->error()['message'], -1000);
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
        $ret = $this->db_handle->query($sql);

        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }

    public function query_train_station_list()
    {
        $this->valid_dao();
        $ret = $this->db_handle->get('tb_train_city');

        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }

    public function query_user_perms($user_id)
    {
        $this->valid_dao();
        $ret = $this->db_handle->query("SELECT res.res_uri, res.res_desc, r.role_id, r.role_name, r.role_desc
	, r.su
FROM tb_user u
	LEFT JOIN tb_role_user ru ON ru.user_id = u.user_id
	LEFT JOIN tb_role r ON r.role_id = ru.role_id
	LEFT JOIN tb_role_resource rr ON rr.role_id = r.role_id
	LEFT JOIN tb_resource res ON find_in_set(res.res_id, rr.resource_id)
WHERE u.user_id = {$user_id}");

        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }

    public function query_user_info($name, $password)
    {
        $this->valid_dao();
        $ret = $this->db_handle->select('user_id, user_name, user_icon, create_time, update_time')->get_where('tb_user', array('user_name' => $name, 'user_password' => $password));

        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }

    public function query_user_role($user_id)
    {
        $this->valid_dao();
        $ret = $this->db_handle->get_where('tb_role_user', array('user_id' => $user_id));

        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }
    
    public function insert_user($arr)
    {
        $this->valid_dao();
        $this->db_handle->trans_start();
        $role_id = $arr['role_id'];
        unset($arr['role_id']);
        $ret = $this->db_handle->insert('tb_user', $arr);
        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }

        $user_id = $this->db_handle->get_where('tb_user', array('user_name' => $arr['user_name']))->row_array()['user_id'];
        $ret = $this->db_handle->insert('tb_role_user', ['role_id' => $role_id, 'user_id' => $user_id]);
        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        $this->db_handle->trans_complete();
        return $ret;
    }

    public function insert_role_user($arr)
    {
        $this->valid_dao();
        $ret = $this->db_handle->insert('tb_role_user', $arr);
        if (!$ret)
        {
            throw new Exception($this->db_handle->error()['message'], -1001);
        }
        return $ret;
    }
}