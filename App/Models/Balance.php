<?php

namespace App\Models;

use PDO;
use \App\Models\Income;
use \App\Models\Expense;
/**
 * User model
 *
 * PHP version 7.0
 */
class Balance extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];
	private $incomes;
	private $incomesCategory;
	private $expenses;
	private $expensesCategory;

	
	public function __construct()
    {
		$this->incomes = new Income();
		$this->incomesCategory = new Income;
		$this->expenses = new Expense;
		$this->expensesCategory = new Expense;
		

    }
	
	public function setBalance($year, $month =''){
		$this->incomesCategory = Income::findByDateOrCategory($year,$month, true);
		$this->incomes = Income::findByDateOrCategory($year,$month);
		$this->expensesCategory = Expense::findByDateOrCategory($year,$month, true);
		$this->expenses = Expense::findByDateOrCategory($year,$month);
	}
	
	public function setBalanceByPeriodOfTime($date1, $date2){
		$this->validatePeriodOfTime($date1, $date2);

        if (empty($this->errors)) {
			$this->incomesCategory = Income::findByPeriodOfTimeOrCategory($date1, $date2, true);
			$this->incomes = Income::findByPeriodOfTimeOrCategory($date1, $date2);
			$this->expensesCategory = Expense::findByPeriodOfTimeOrCategory($date1, $date2, true);
			$this->expenses = Expense::findByPeriodOfTimeOrCategory($date1, $date2);
		}
	}
	
	public function getIncomes(){
		return $this->incomes;
	}
	
	public function getIncomesCategory(){
		return $this->incomesCategory;
	}
	
	public function getexpenses(){
		return $this->expenses;
	}
	
	public function getexpensesCategory(){
		return $this->expensesCategory;
	}
	
	public function validatePeriodOfTime($date1, $date2)
    {
        // dates
        if ($date1 > $date2) {
            $this->errors[] = 'Pierwsza data nie może być późniejsza od drugiej';
        }
		if($date1 =='' || $date2 ==''){
			$this->errors[] = 'Określ date';
		}
    }
	
	
	
}
