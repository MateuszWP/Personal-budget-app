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
			$option = 5;
			View::renderTemplate('/Balance/balance.html', ['option' => $option]);
		}
	}
	
	public function showBalance($option, $year, $month=''){
		$balance = new Balance( );
		$balance->setBalance($year, $month);

		View::renderTemplate('/Balance/balance.html',
			array('incomes' => $balance->getIncomes(), 'incomesCategory' => $balance->getIncomesCategory(), 'expensesCategory' =>$balance->getExpensesCategory(), 'expenses' => $balance->getExpenses(), 'option' => $option)
			);
		
	}
	
	public function showBalanceForPeriodOfTimeAction(){
		//$this-> showBalance(3, date('Y'), date('m')-1);
		if(isset($_POST['date1']) && isset($_POST['date1'])){
			
			$date1 = date('Y-m-d', strtotime($_POST['date1']));
			$date2 = date('Y-m-d', strtotime($_POST['date2']));		
			
			$balance = new Balance();
			$balance->setBalanceByPeriodOfTime($date1, $date2);
			View::renderTemplate('/Balance/balance.html',
			array('incomes' => $balance->getIncomes(), 'incomesCategory' => $balance->getIncomesCategory(), 'expensesCategory' =>$balance->getExpensesCategory(), 'expenses' => $balance->getExpenses(), 'option' => 2)
			);
		}
		
	}
	
}
