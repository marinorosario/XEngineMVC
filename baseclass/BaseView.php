<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 3:45 PM
 */

namespace baseclass;


use app\Request;

class BaseView
{
    private $_vControl; //variable privada para asignar el controlador que se ha llamado
    private $_vMethod;
    private $_vViewObj; //variable para asignar un objeto por medio a los getter y setter de esta misma clase

    private $_vistacont;

    public function __construct(Request $request)
    {
        $this->_vViewObj = new \StdClass();// aqui creo un objeto nulo para poder asignar propiedades por medio a los getter y setter
        $this->_vControl = $request->getController(); //aqui asigno el controlador requerido a la variable privada controlador
        $this->_vMethod = $request->getMethod();

        # aqui se puede añadir un motor de plantilla externo
    }

    public function __set($name, $value)
    {
        $this->_vViewObj->$name = $value;
    }

    public function __get($name)
    {
        return $this->_vViewObj->$name;
    }

    public function render(string $vista, $datos = null): void{
        $template = VIEW_PATH . 'templates' . DS . 'cuerpo.tpl.php';
        $vista = VIEW_PATH . $this->_vControl . DS . $vista . '.tpl.php';
        if(is_readable($template)){
            if(is_readable($vista)){
                $this->_vistacont = file_get_contents($vista);
                ob_clean();
                ob_start(function($bufer){
                    return (str_replace("{contenido}", $this->_vistacont, $bufer));
                });
                require_once $template;

                ob_end_flush();
            }else{
                throw new \Exception('No hay acceso a la vista: '.$vista);
            }
        }else{
            throw new \Exception('No hay acceso a la plantilla: '.$template);
        }
    }


}