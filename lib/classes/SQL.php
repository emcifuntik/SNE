<?php
/**
 * Created by PhpStorm.
 * User: Tuxick
 * Date: 06.03.2015
 * Time: 14:26
 */

namespace Base;


class SQL {
    const CONNECTION_MYSQL = 1;
    const CONNECTION_SQLITE = 2;
    public $connection_type;
    private $handler;
    public $debug = true;

    public function __construct($_connection_type, $_name_or_host, $_user = "", $_pass = "", $_db = "") {
        $this->connection_type = $_connection_type;
        if($this->connection_type == SQL::CONNECTION_SQLITE) {
            $this->handler = new \SQLite3($_name_or_host);
        }
        /*else if($this->connection_type == SQL::CONNECTION_MYSQL) {
            $this->handler = new \mysqli($_name_or_host, $_user, $_pass, $_db);
        }*/
    }

    public function __destruct()
    {

    }

    public function __get($key)
    {
        switch($key) {
            case "affected_rows": {
                return (($this->connection_type == SQL::CONNECTION_MYSQL) ? $this->handler->affected_rows : $this->handler->changes());
            }
        }
    }

    public function insert($_data, $_table) // return: query result
    {
        $keys = array_keys($_data);

        $fields = "(";
        $values = "(";
        $keys_keys = array_keys($keys);//тавтология
        foreach($keys as $key => $value) {
            $fields .= $value.
                (($key == end($keys_keys)) ?
                    ")" : ",");

            $values .= ((gettype($_data[$value]) == "string") ? "\"" : "").
                $this->escape($_data[$value]).
                ((gettype($_data[$value]) == "string") ? "\"" : "").
                (($key == end($keys_keys)) ? ")" : ",");
        }

        $query_text = "insert into \"".$_table."\" ".$fields." VALUES ".$values;
        return $this->query($query_text);
    }

    public function update($_table, $_data, $_clause = "") // return: query result
    {
        $keys = array_keys($_data);

        $update = "";

        $keys_keys = array_keys($keys);//тавтология
        foreach($keys as $key => $value) {
            $update .= "`".$value."`=".
                ((gettype($_data[$value]) == "string") ? "\"" : "").
                $this->escape($_data[$value]).
                ((gettype($_data[$value]) == "string") ? "\"" : "").
                (($key == end($keys_keys)) ? "" : ",");
        }

        $query_text = "update \"".$_table."\" set ".$update.(($_clause == "") ? "" : " where ").$_clause;
        return $this->query($query_text);
    }

    public function select($_fields, $_tables, $_clause = "") // return: query result
    {
        $fields = "";

        $keys = array_keys($_fields);
        foreach($_fields as $key => $value) {
            $fields .= $value.(($key == end($keys)) ? "" : ",");
        }

        $tables = "";

        $keys = array_keys($_tables);
        foreach($_tables as $key => $value) {
            $tables .= "\"".$value."\"".(($key == end($keys)) ? "" : ",");
        }

        $query_text = "select ".$fields." from ".$tables.(($_clause == "") ? "" : " where ").$_clause;

        return $this->query($query_text);
    }

    //Function query
    //Return:
    //0 - fail or undefined sql connection type
    //sql query result - success
    private function query($query_text)
    {
        if($this->connection_type == SQL::CONNECTION_MYSQL) {
            $result = $this->handler->query($query_text);
            return $result === false ? $this->log_error($query_text, mysql_error()) : $result;
        }
        else if($this->connection_type == SQL::CONNECTION_SQLITE) {
            $result = $this->handler->query($query_text);
            return $result === false ? $this->log_error($query_text, $this->handler->lastErrorMsg()) : $result;
        }
        else return 0;
    }

    public function escape($_string)
    {
        return (($this->connection_type == SQL::CONNECTION_MYSQL) ? $this->handler->escape_string($_string) : $this->handler->escapeString($_string));
    }

    public function fetch_array($_sql_result)
    {
        if(gettype($_sql_result) == "object")
        {
            if($this->connection_type == SQL::CONNECTION_MYSQL) {
                return $_sql_result->fetch_array(MYSQLI_ASSOC);
            }
            else if($this->connection_type == SQL::CONNECTION_SQLITE) {
                return $_sql_result->fetchArray(SQLITE3_ASSOC);
            }
            else return 0;
        }
        else return 0;
    }

    public function num_rows($_sql_result)
    {
        return (($this->connection_type == SQL::CONNECTION_MYSQL) ? $_sql_result->num_rows : $_sql_result->numColumns());
    }

    //Function sql_load
    //Return:
    //0 - fail
    //sql query result - success
    //2 - file not found
    public function sql_load($_name)
    {
        $query_text = file_get_contents($_name);
        return $this->query($query_text);
    }

    private function log_error($query, $mysql_error)
    {
        if($this->debug) {
            $text = "[".date('Y-m-d H:i:s')."] SQL Error, Query text: ".$query.", error text: ".$mysql_error;
            file_put_contents("sql_debug.txt", $text."\n", FILE_APPEND);
            die('SQL Error. More info in sql_debug.txt');
        }
        return 0;
    }
}