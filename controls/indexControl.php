<?php
/**
 * Created by PhpStorm.
 * User: Marino Rosario
 * Date: 16/11/2017
 * Time: 3:41 PM
 */

namespace controls;


use baseclass\BaseController;

class indexControl extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // TODO: Implement index() method.
        $this->_cView->render('index');
    }
}