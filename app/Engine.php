<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 3:08 PM
 */

namespace app;


class Engine
{
    public static function run(Request $request){
        $control = $request->getController();
        $ruteCntrl = ROOT . 'controls'. DS . $control . 'Control.php';

        $method = $request->getMethod();
        $argms = $request->getArgs();

        if (is_readable($ruteCntrl)){
            require_once $ruteCntrl;

            $control = 'controls\\'.$control.'Control';
            $control = new $control;

            if (is_callable([$control,$method])){
                if (isset($argms)){
                    call_user_func_array([$control,$method],$argms);
                }else{
                    call_user_func([$control,$method]);
                }
            }else{
                call_user_func([$control,'index']);
            }
        }else{
            throw new \Exception('No existe el control: '.$control);
        }
    }
}