<?php
/**
 * Created by PhpStorm.
 * User: Tuxick
 * Date: 09.03.2015
 * Time: 7:10
 */

namespace Base;


class User {
    private $sql;

    public function __construct($_sql)
    {
        $this->sql = $_sql;
    }

    public function register($_name, $_pass, $_access = 1, $_money = 0)
    {
        $array = array(
            "user_name" => $_name,
            "user_password" => md5($_pass.$_name),
            "user_access" => $_access,
            "user_money" => $_money
        );
        return $this->sql->insert($array, "users");
        //TODO: Дописать возвращаемые переменные
    }

    public function login($_name, $_pass)
    {
        $_pass = md5($_pass.$_name);
        $fields = array("user_id", "user_name", "user_access", "user_money");
        $tables = array("users");
        $clause = "user_name=\"".$this->sql->escape($_name)."\" and user_password=\"".$_pass."\" limit 1";
        $result = $this->sql->select($fields, $tables, $clause);
        $data = $this->sql->fetch_array($result);
        if($data)
        {
            $session = md5($data["user_name"].$_pass.$data["user_id"].$data["user_access"].date('YmdHis'));

            setcookie("id", $data["user_id"]); //TODO: Сделать класс Cookie
            setcookie("session", $session);

            $to_update = array(
                "user_session" => $session
            );
            $this->sql->update("users", $to_update, "`user_id`=".$data["user_id"]);
            return $data;
        }
        else return false;
        //TODO: Возвращать 0 в случае неудачи
    }

    public function get_data($_id, $_session)
    {
        if($_session == "") return 0;
        $id = $this->sql->escape($_id);
        $session = $this->sql->escape($_session);
        $fields = array("user_id", "user_name", "user_access", "user_money");
        $tables = array("users");
        $clause = "user_id=\"".$id."\" and user_session=\"".$session."\" limit 1";
        $result = $this->sql->select($fields, $tables, $clause);
        return $this->sql->fetch_array($result);
        //TODO: Возвращать 0 в случае неудачи
    }

    public function logout($_id, $_session)
    {
        $to_update = array(
            "user_session" => ""
        );
        $this->sql->update("users", $to_update, "user_id=".$this->sql->escape($_id)." and user_session=\"".$this->sql->escape($_session)."\"");
        setcookie("id", "", 0); //TODO: Сделать класс Cookie
        setcookie("session", "", 0);
        if($this->sql->affected_rows > 0) return true;
        else return false;
    }
}