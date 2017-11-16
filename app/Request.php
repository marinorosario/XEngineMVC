<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 3:01 PM
 */

namespace app;


class Request
{
    private $_controller;
    private $_method;
    private $_args;

    public function __construct()
    {
        if (isset($_GET['url'])){
            $url = filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL);
            $url = strtolower($url);
            $url = explode('/',$url);
            $url = array_filter($url);

            $this->_controller = array_shift($url);
            $this->_method = array_shift($url);
            $this->_args = $url;
        }

        $this->_controller = ($this->_controller) ?? DEFAULT_CONTROL;
        $this->_method = ($this->_method) ?? 'index';
        $this->_args = ($this->_args) ?? array();
    }

    /**
     * @return string Control
     */
    public function getController():string
    {
        return $this->_controller;
    }

    /**
     * @return string Metodo
     */
    public function getMethod():string
    {
        return $this->_method;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->_args;
    }


}