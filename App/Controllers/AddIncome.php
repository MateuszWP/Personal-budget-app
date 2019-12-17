<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class AddIncome extends \Core\Controller
{

    /**
     * Show the AddIncome page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('AddIncome/new.html');
    }

}
