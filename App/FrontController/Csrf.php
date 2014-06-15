<?php
/**
 * ILFATE PHP ENGINE
 * @autor Ilya Rubinchik ilfate@gmail.com
 * 2012
 */

namespace App\FrontController;

use App\Exception\Error;
use App\Service;
use Core\Interfaces\FrontController;

/**
 * Description of FrontController_Auth
 *
 *
 * @author ilfate
 */
class Csrf implements FrontController
{
    const PRIORITY = 80;

    public function preExecute()
    {
        if (Service::getRequest()->getMethod() == "POST") {
            if (!\App\Csrf::check()) {
                throw new Error('No CSRF token found');
            }
        }
    }

    public function postExecute()
    {

    }
}
