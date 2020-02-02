<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Income;
use \App\Flash;
use \App\Models\IncomeCategory;
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

		$incomeCategories = new IncomeCategory();
		$incomeCategories = IncomeCategory::findByID($_SESSION['user_id']);
        View::renderTemplate('AddIncome/new.html',['incomeCategories'=> $incomeCategories]);
    }

	/**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $income = new Income($_POST);
		
		 if($income->save()){
			Flash::addMessage('Pomyślnie dodano przychód');
			$this->newAction();
		}else{
			Flash::addMessage('Nie udało sie dodać przychodu', Flash::WARNING);
			View::renderTemplate('AddIncome/new.html', array('income' => $income,'incomeCategories' => IncomeCategory::findByID($_SESSION['user_id'])));
		}
		
        
		 
    }
	
}
