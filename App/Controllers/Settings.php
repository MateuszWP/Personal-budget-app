<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\User;
use \App\Models\IncomeCategory;
use \App\Models\PayingMethods;
use \App\Models\ExpenseCategory;
/**
 * AddIncome controller
 *
 * PHP version 7.0
 */
class Settings extends \Core\Controller
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
		
		$incomeCategories = new IncomeCategory();
		$incomeCategories = IncomeCategory::findByID($_SESSION['user_id']);
		
        View::renderTemplate('Settings/new.html', array('payingMethods' =>$payingMethods, 'expenseCategories' =>$expenseCategories, 'incomeCategories' => $incomeCategories));
    }

	public function changePersonalInfoAction()
    {
        $user = User::findById($_SESSION['user_id']);
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

        if ($user->changePersonalInfo($name, $email, $password)) {
			Flash::addMessage('Udało się zmienić dane użytkownika');
			$this->newAction();
			 
        } else {
			Flash::addMessage('Nie udało się zmienić danych użytkowaika, proszę ponowić próbę',Flash::WARNING);
            View::renderTemplate('Settings/new.html', array('payingMethods' =>PayingMethods::findByID($_SESSION['user_id']), 'expenseCategories' =>ExpenseCategory::findByID($_SESSION['user_id']), 'incomeCategories' => IncomeCategory::findByID($_SESSION['user_id']), 'user' => $user));

        }
    }
	
	public function deletePayingMethodAction()
	{
		$method = $_POST['payingMethod'];
		
		if(PayingMethods::deletePayingMethod($method)){
			Flash::addMessage('Udało się usunąć wybraną metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
	public function addPayingMethodAction()
	{
		$method = $_POST['category'];
		
		if(PayingMethods::addPayingMethod($method)){
			Flash::addMessage('Udało się dodać metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się dodac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
}
