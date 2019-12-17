<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;

/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class AddExpense extends \Core\Controller
{

    /**
     * Show the AddIncome page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('AddExpense/new.html');
    }

	/**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $expense = new Expense($_POST);
		
        if($expense->save()){
			Flash::addMessage('Pomyślnie dodano wydatek');
			View::renderTemplate('AddExpense/new.html');
		}else{
			Flash::addMessage('Nie udało sie dodać wydatku', Flash::WARNING);
			View::renderTemplate('AddExpense/new.html',[
                'expense' => $expense
            ]);
		}
		 
    }
	
}
