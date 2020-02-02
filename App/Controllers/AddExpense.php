<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Expense;
use \App\Flash;
use \App\Models\PayingMethods;
use \App\Models\ExpenseCategory;

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
		$payingMethods = new PayingMethods();
		$payingMethods = PayingMethods::findByID($_SESSION['user_id']);
		
		$expenseCategories = new ExpenseCategory();
		$expenseCategories = ExpenseCategory::findByID($_SESSION['user_id']);
		
        View::renderTemplate('AddExpense/new.html',array('payingMethods' =>$payingMethods, 'expenseCategories' =>$expenseCategories));
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
			$this->newAction();
		}else{
			Flash::addMessage('Nie udało sie dodać wydatku', Flash::WARNING);
			View::renderTemplate('AddExpense/new.html',array('payingMethods' =>PayingMethods::findByID($_SESSION['user_id']), 'expenseCategories' =>ExpenseCategory::findByID($_SESSION['user_id']),'expense' => $expense));

		}
		 
    }
	
}
