<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class Settings extends \Core\Controller
{

    /**
     * Show the AddIncome page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Settings/new.html');
    }

	
}
