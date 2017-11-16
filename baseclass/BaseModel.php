<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 5:06 PM
 */

namespace baseclass;

use app\Dbase;

require_once APP_PATH . 'Dbase.php';

abstract class BaseModel
{
    protected $_mDb;
    protected $_table;

    public function __construct()
    {
        $this->_mDb = new Dbase();
    }

    public function setTable($table){
        $this->_table = $table;
    }

    /**
     * Metodo para hashear una clave
     * @param string $pass
     * @return string clave hasheada
     */
    protected function setPass($pass){
        return password_hash($pass,PASSWORD_DEFAULT);
    }

    abstract public function save();
    abstract public function delete();
    abstract public function findOne();
    abstract public function getAll();
}