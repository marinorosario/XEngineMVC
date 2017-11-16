<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 2:52 PM
 */

use app\{Engine,Request};



define('DS',DIRECTORY_SEPARATOR);
define('ROOT',realpath(dirname(__FILE__)).DS);

define('APP_PATH',ROOT . 'app' . DS);
define('BCLASS_PATH',ROOT . 'baseclass' . DS);
define('VIEW_PATH',ROOT . 'views' . DS);

define('CONFIG_PATH',ROOT . 'configs' . DS);

//core
require_once CONFIG_PATH.'config.php';
require_once APP_PATH.'Request.php';
require_once APP_PATH.'Engine.php';

//base class
require_once BCLASS_PATH .  'BaseController.php';

try{

    if (version_compare(PHP_VERSION, '7.1.0', '>=')) {

        Engine::run(new Request());

    } else {
        throw new Exception('Tu version de PHP ['.PHP_VERSION.'] no cumple con los requerimientos, debes tener php 7.1+');
    }

}catch (\PDOException | \Exception $ex){
        echo $ex->getMessage();

}finally{

    //debug
    echo '<pre>';
    var_dump(get_required_files());
    echo '</pre>';
}

