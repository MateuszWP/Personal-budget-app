<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;

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

	/**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $income = new Income($_POST);
		
        $income->save();
		 View::renderTemplate('AddIncome/new.html');
    }
	
}
