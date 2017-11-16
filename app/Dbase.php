<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 5:02 PM
 */

namespace app;

require_once CONFIG_PATH .'dbase.config.php';


class Dbase extends \PDO
{
    public function __construct()
    {
        parent::__construct(BDATOS_DSN, BDATOS_USER, BDATOS_PASS, [\PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8']);
        $this->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
    }
}