<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 3:34 PM
 */

namespace baseclass;

use app\Request;

require_once 'BaseView.php';

abstract class BaseController
{
    protected $_cView; #objeto vista en el controladador

    abstract public function index();

    public function __construct()
    {
        $this->_cView = new BaseView(new Request());
    }

    protected function loadModel(string $modelo){
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';

        if(is_readable($rutaModelo)){
            require_once $rutaModelo;

            $modelo = 'models\\' . $modelo;
            $modelo = new $modelo();

            return $modelo;
        }else{
            throw new \Exception('No se encuentra el modelo: '.$modelo);
        }
    }

    protected function redir($ruta = false):void{
        if($ruta){
            header('Location: ' . SITE_ROOT . $ruta);
            exit();
        }else{
            header('Location: ' . SITE_ROOT);
            exit();
        }
    }

    protected function validarEmail(string $email):bool {
        if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Metodo para verificar si una clave ya hasheada corresponde con la nueva clave hasheada introducida;
     * @param string $pass
     * @param string $hashPass
     * @return boolean
     */
    protected function testPass(string $pass,string $hashPass){
        return password_verify($pass, $hashPass);;
    }

    /**
     * Metodo para leer una cadena por medio a post y convertir las variables y los datos en un arreglo asociativo
     */
    protected function miPost(){
        $post = file_get_contents('php://input');
        $arr = explode("&",urldecode($post));
        $arr_result = array();
        foreach($arr as $dato):
            $row = explode("=",$dato);
            $arr_result[$row[0]] = $row[1];
        endforeach;
        return($arr_result);
    }

    /**
     * Metodo para validar un texto que se envie desde un formulario por medio a POST
     * @param string $clave nomnbre que tiene el campo del formulario
     * @return string|boolean devielve el string con el valor o falso si no es correcto.
     */
    protected function getTexto($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = htmlspecialchars($_POST[$clave],ENT_QUOTES);
            return $_POST[$clave];
        }
        return false;
    }
    /**
     * Metodo para recoger de un formulario que se haya enviado por POST un entero
     * @param string $clave este es el nombre que se le dio en el formulario
     * @return mixed|boolean devuelve el valor entero o falso si no se encuentra o es incorrecto
     */
    protected function getInt($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = filter_input(INPUT_POST, $clave,FILTER_SANITIZE_NUMBER_INT);
            return $_POST[$clave];
        }
        return false;
    }

    /**
     * Metodo para recoger de un formulario que se haya enviado por POST un string
     * @param string $clave este es el nombre que se le dio en el formulario
     * @return mixed|boolean devuelve el valor entero o falso si no se encuentra o es incorrecto
     */
    protected function getStr($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $_POST[$clave] = filter_input(INPUT_POST, $clave,FILTER_SANITIZE_STRING);
            return $_POST[$clave];
        }
        return false;
    }

    /**
     * Metodo para recoger de un formulario que se haya enviado por POST un string Email
     * @param string $clave este es el nombre que se le dio en el formulario
     * @return mixed|boolean devuelve el valor entero o falso si no el email se encuentra o es incorrecto
     */
    protected function getEmailStr($clave){
        if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
            $email = filter_input(INPUT_POST, $clave,FILTER_VALIDATE_EMAIL);
            return $email;
        }
        return false;
    }

    /**
     * Metodo para filtrar un entero
     * @param string $entero tiene que ser un numero ya sea en string o no para se convertido o validado
     * @return mixed devuelve el valor como entero
     */
    protected function filtraInt($entero){
        $entero = (int) $entero;
        $entero = filter_var($entero,FILTER_VALIDATE_INT);
        return $entero;
    }

    /**
     * Metodo para filtrar una cadena
     * @param string $cadena tiene que ser una cadena
     * @return mixed devuelve el valor como cadena sin caracteres raros
     */
    protected function filtraStr($cadena){
        $cadena = filter_var($cadena,FILTER_SANITIZE_STRING);
        return $cadena;
    }
    /**
     * Metodo para hashear una clave
     * @param string $pass
     * @return string ya hasheado
     */


    /**
     * Metodo para determinar si la consulta es por ajax que se ha enviado
     */
    protected function ajaxAccess(){
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if(!$isAjax) {
            $user_error = 'Access denied - not an AJAX request...';
            //trigger_error($user_error, E_USER_ERROR);
            throw new \Exception("Solo puedes hacer peticiones por medio a AJAX...");
        }
    }

    protected function ahora(){
        $this->_fechaAhora = new \DateTime('now', new \DateTimeZone(ZONA_HORARIA));
        return $this->_fechaAhora->format(FECHA_FORMATO);
    }
}