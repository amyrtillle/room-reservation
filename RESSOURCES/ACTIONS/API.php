<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once $_SERVER['DOCUMENT_ROOT'] . '/RESSOURCES/ACTIONS/bd.php';

// reservation : SELECT, INSERT, UPDATE, DELETE
// room : SELECT

class API extends BDHandler {
    private $res;
    private $api;

    public function __construct()
    {
        /*$this->res = $res;
        $this->api = new API();*/
    }

    function stop($status, $res)
    {
        $res['status'] = $status;
        echo json_encode($res);
        exit();
    }

    public function execute($req)
    {
        require_once 'config.php';
        try {
            $conn = new PDO(DB, USER, PWD);
        } catch (PDOException $e) {
            die("Failed: " . $e);
        }

        $res = $conn->query($req);
        if (!$res)
            die("Failed query: " . $req);
        $rows = $res->fetchAll();
        return $rows;
    }

    public function isset($data, $key, $msg)
    {
        if (!isset($data[$key]) or $data[$key] == '') {
            $this->res['msg'] = $msg;
            $this->stop(false);
        }
    }

    public function isnum($data, $key, $msg)
    {
        if (!is_numeric($data[$key])) {
            $this->res['msg'] = $msg;
            $this->stop(false);
        }
    }
    public function getIsAdmin($login)
    {
        if (isset($login)) {
            $req = "SELECT `admin_login` FROM `admin` WHERE `admin_login` = '" . $login . "'";
            $response = $this->execute($req);
            return $response;
        } else {
            return false;
        }
    }
    public function dataVerification($data)
    { //la variable data correspond au $_GET
        if (isset($data['action']) && isset($data['table'])) {
            $arguments = $data;
            unset($arguments['action']);
            unset($arguments['table']);
            // var_dump($arguments);
            switch ($data['action']) {
                case 'select':
                    return $this->selectData($data['table'], $arguments);
                case 'insert':
                    return $this->insetData($data['table'], $arguments);
                case 'update':
                    return $this->updateData($data['table'], $arguments);
                case 'delete':
                    return $this->deleteData($data['table'], $arguments);
            }
        } else {
            return false;
        }
    }
    public function selectData($table, $arguments)
    {
        $arg = $arguments;
        $needOrderBy = false;
        $needJoin = false;

        if(isset($arg['orderBy'])){
            $orderBy = $arg['orderBy'];
            $needOrderBy = true;
        }

        if(isset($arg['leftJoin'])){
            $leftJoin = $arg['leftJoin'];
            if (isset($leftJoin['tableToJoin']) && isset($leftJoin['argToJoin'])){
                $tableToJoin = $leftJoin['tableToJoin'];
                $argToJoin = $leftJoin['argToJoin'];
                $needJoin = true;
            }
        }

        $req = "SELECT * FROM " . $table;

        if($needJoin){
            $req .= " LEFT JOIN " . $tableToJoin . " ON " . $table . "." . $argToJoin . " = " . $tableToJoin . "." . $argToJoin;
            unset($arg['leftJoin']);
        }

        $i = 0;
        foreach ($arg as $key => $value) {
            if($key != 'orderBy') {
                if ($i == 0) {
                    $req .= " WHERE ";
                } else {
                    $req .= " AND ";
                }
                if (is_numeric($value)) {
                    $req .= $key . "=" . $value;
                } else {
                    $req .= $key . "='" . $value . "'";
                }
                $i++;
            }
        }

        if($needOrderBy){
            $req .= " ORDER BY " . $orderBy;
        }
        $response = $this->execute($req);
        if (sizeof($response) != 0) {
            return [
                'data' => $response,
                'state' => true,
            ];
        } else {
            return [
                'data' => [],
                'state' => false
            ];
        }
    }

    public function insetData($table, $arguments)
    {
        $arg = $arguments;
        if (sizeof($arg) === 0) {
            return [
                'data' => [],
                'state' => false
            ];
        } else {
            $req = "INSERT INTO " . $table . " (";
            $keyList = '';
            $valueList = '';
            $i = 0;
            $limitNumberArg = sizeof($arg) - 1;
            foreach ($arg as $key => $value) {
                if ($i == $limitNumberArg) {
                    $keyList .= "`" . $key . "`";
                    if (is_numeric($value)) {
                        $valueList .= $value;
                    } else {
                        $valueList .= "'" . $value . "'";
                    }
                } else {
                    $keyList .= "`" . $key . "`,";
                    if (is_numeric($value)) {
                        $valueList .= $value . ",";
                    } else {
                        $valueList .= "'" . $value . "',";
                    }
                }
                $i++;
            }
            $req .= $keyList . ') VALUES (' . $valueList . ');';

            $this->execute($req);

            return [
                'data' => [],
                'state' => true
            ];
        }

}

    public function updateData($table, $args)
    {

        header("Content-Type: application/json");
        if (!sizeof($args)) {
            return [
                'data' => [],
                'state' => false
            ];
        } else {
            $arg = ['id'=> '', 'id-type' => ''];
            $i = 0;
            foreach ($args as $key => $value) {
                $columnExist = $this->instruct("SHOW COLUMNS FROM ". $table ." LIKE '" . $key . "';");
                if ($columnExist->rowCount() == null) {
                    $response = ['msg' => "Error, column " . $key . " doesn't exist", 'code' => 404];
                    
                    return [
                        'data' => $response,
                        'state' => true
                    ];
                }
                if(str_contains($key, 'id')){
                    $arg['id'] = $value;
                    $arg['id-type'] = $key;
                }
                else{
                    $arg['arg'.$i.'-val'] = $value;
                    $arg['arg'.$i.'-type'] = $key;
                    // echo json_encode($arg);
                    // var_dump($arg);
                }
                $i ++;
            }
            // echo json_encode($arg);
            // var_dump($arg);
            $idExist = $this->instruct("SELECT " . $arg['id-type'] . " FROM " . $table . " WHERE " . $arg['id-type'] . " = " . $arg['id'] . ";");
            if (!$idExist->rowCount()) {
                $response = ['msg' => "Error, id ". $arg['id'] . " doesn't exist in table " . $table, 'code' => 404];
                return [
                    'data' => $response,
                    'state' => true
                ];
            } else {
                $req = "UPDATE " . $table . " SET " . $arg['arg0-type'] . " =  " . $arg['arg0-val'] . " WHERE " . $arg['id-type'] . " = " . $arg['id'];
                // var_dump($req);
                $response = $this->execute($req);
                $isSuccess = $this->execute("SELECT " . $arg['arg0-type'] . " FROM " . $table . " WHERE " . $arg['id-type'] . " = " . $arg['id'] . " AND " . $arg['arg0-type'] . " = " . $arg['arg0-val']);
                if (sizeof($isSuccess) != 0) {
                    $response = ['msg' => "Success, id " . $arg['id'] . " has been updated in table " . $table, 'code' => 200];
                    return [
                        'data' => $response,
                        'state' => true,
                    ];
                } else {
                    return [
                        'data' => [],
                        'state' => false
                    ];
                }
            }
        }
    }

    public function deleteData($table, $arguments)
    {
        $arguments['id-key'] = array_keys($arguments)[0];
        $arguments['id'] = array_values($arguments)[0];        
        $arg = $arguments;
        if (isset($arg['id'])) {
            $req = "DELETE FROM ${table} WHERE ${arg['id-key']} = ${arg['id']}";
            echo $req;
            $this->instruct($req);
            return [
                'data' => [],
                'state' => true
            ];
        } else {
            return [
                'data' => [],
                'state' => false
            ];
        }
    }
}

if (sizeof($_GET) != 0){
    $requestAPI = new API();
    echo json_encode($requestAPI->dataVerification($_GET));
}