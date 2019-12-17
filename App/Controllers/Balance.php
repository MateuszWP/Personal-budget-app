<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Models\Expense;

/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class Balance extends \Core\Controller
{

    /**
     * Show the AddIncome page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('/Balance/balance.html');
    }

	public function showForOptionAction(){
		if($_POST['periodOfTime'] == 2){
			$incomesCategory = Income::findByDateOrCategory(date('m'),date('Y'), true);
			$incomes = Income::findByDateOrCategory(date('m'),date('Y'));
			
			$expensesCategory = Expense::findByDateOrCategory(date('m'),date('Y'), true);
	//		print_r($expensesCategory);
			View::renderTemplate('/Balance/balance.html',
				array('incomes' => $incomes, 'incomesCategory' => $incomesCategory, 'expensesCategory' =>$expensesCategory)
			);
		}

	}
	
 
	
}
