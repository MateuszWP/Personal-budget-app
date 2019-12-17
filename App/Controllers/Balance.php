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
		$this-> showBalance(2, date('Y'), date('m'));
      //  View::renderTemplate('/Balance/balance.html');
    }

	public function decideAction(){
		if($_POST['periodOfTime'] == 2){
			$this-> showBalance(2, date('Y'), date('m'));
		}
		else if($_POST['periodOfTime'] == 3){
			$this-> showBalance(3, date('Y'), date('m')-1);
		}
		else if($_POST['periodOfTime'] == 4){
			$this-> showBalance(4, date('Y'));
		}
		else if($_POST['periodOfTime'] == 5){
			View::renderTemplate('/Balance/balance.html');
		}
	}
	
	public function showBalance($option, $year, $month=''){
		$incomesCategory = Income::findByDateOrCategory($year,$month, true);
		$incomes = Income::findByDateOrCategory($year,$month);
		
		$expensesCategory = Expense::findByDateOrCategory($year,$month, true);
		$expenses = Expense::findByDateOrCategory($year,$month);
//		print_r($expensesCategory);
		View::renderTemplate('/Balance/balance.html',
			array('incomes' => $incomes, 'incomesCategory' => $incomesCategory, 'expensesCategory' =>$expensesCategory, 'expenses' => $expenses, 'option' => $option)
			);
	}
	
}
