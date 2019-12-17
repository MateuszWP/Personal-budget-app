<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;

/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class ShowBalance extends \Core\Controller
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
			View::renderTemplate('/Balance/balance.html', ['option' => 5]);
		}
	}
	
	public function showBalance($option, $year, $month=''){
		$balance = new Balance( );
		$balance->setBalance($year, $month);
		View::renderTemplate('/Balance/balance.html',
			array('incomes' => $balance->getIncomes(), 'incomesCategory' => $balance->getIncomesCategory(), 'expensesCategory' =>$balance->getExpensesCategory(), 'expenses' => $balance->getExpenses(), 'saldoIncomes' => $balance->getIncomesAmount(), 'saldoExpenses' =>$balance->getExpensesAmount(), 'option' => $option)
			);
		
	}
	
	public function showBalanceForPeriodOfTimeAction(){
		if(isset($_POST['date1']) && isset($_POST['date2']) ){

			$balance = new Balance();
			if($balance->setBalanceByPeriodOfTime($_POST['date1'], $_POST['date2'])){
				
				View::renderTemplate('/Balance/balance.html',
				array('incomes' => $balance->getIncomes(), 'incomesCategory' => $balance->getIncomesCategory(), 'expensesCategory' =>$balance->getExpensesCategory(), 'expenses' => $balance->getExpenses(), 'saldoIncomes' => $balance->getIncomesAmount(), 'saldoExpenses' =>$balance->getExpensesAmount(),  'option' => 2)
				);
			}
			else{
				View::renderTemplate('/Balance/balance.html', ['option' => 5, 'balance' => $balance]);
			}	
		}
	}
}
