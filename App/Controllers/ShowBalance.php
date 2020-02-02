<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Balance;


if(isset( $_POST['periodOfTime'] )) {
     $myShowBalance = new showBalance();
     $myShowBalance->decideAction();
}

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
        View::renderTemplate('/Balance/balance.html');
		$this-> showBalance(2, date('Y'), date('m'));
    }

	public function decideAction(){

	//	if($_POST['time'] == 2)
	//		echo View::renderTemplate('/Balance/balance.html', ['option' => 5]);
	//	else echo $_POST['time'];

		if($_POST['time'] == 2){
			$this-> showBalance(2, date('Y'), date('m'));
		}
		else if($_POST['time'] == 3){
			$this-> showBalance(3, date('Y'), date('m')-1);
		}
		else if($_POST['time'] == 4){
			$this-> showBalance(4, date('Y'));
		}
		else if($_POST['time'] == 5){
			View::renderTemplate('/Balance/tables.html', ['option' => 5]);
		}
	}
	
	public function showBalance($option, $year, $month=''){
		$balance = new Balance( );
		$balance->setBalance($year, $month);
		View::renderTemplate('/Balance/tables.html',
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
