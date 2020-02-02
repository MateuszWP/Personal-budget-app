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
		if(isset($_POST['payingMethod']))
		{
			$method = $_POST['payingMethod'];
		
			if(PayingMethods::deletePayingMethod($method)){
				Flash::addMessage('Udało się usunąć wybraną metodę płatności');
			}
			else {
				Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
			}
		}
		else{
			Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
		}
		
		$this->newAction();
	}
	
	public function deleteIncomeCategoryAction()
	{
		if(isset($_POST['incomeCategory']))
		{
			$method = $_POST['incomeCategory'];
		
			if(IncomeCategory::deleteIncomeCategory($method)){
				Flash::addMessage('Udało się usunąć wybraną metodę płatności');
			}
			else {
				Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
			}
		}
		else{
			Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
		}
		$this->newAction();
	}
	
	public function deleteExpenseCategoryAction()
	{
		if(isset($_POST['expenseCategory']))
		{
			$method = $_POST['expenseCategory'];
		
			if(ExpenseCategory::deleteExpenseCategory($method)){
				Flash::addMessage('Udało się usunąć wybraną metodę płatności');
			}
			else {
				Flash::addMessage('Nie udało się usunąć wybranej metody płatności, proszę ponowić próbę',Flash::WARNING);
			}
		}
		else{
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
	
	public function addIncomeCategoryAction()
	{
		$method = $_POST['category'];
		
		if(IncomeCategory::addIncomeCategory($method)){
			Flash::addMessage('Udało się dodać metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się dodac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
	public function addExpenseCategoryAction()
	{
		$method = $_POST['category'];
		
		if(ExpenseCategory::addExpenseCategory($method)){
			Flash::addMessage('Udało się dodać metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się dodac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
	public function editPayingMethodAction(){
		
		$newMethod = $_POST['category'];
		$oldMethod = $_POST['editCategoryRadio'];
		
		if(PayingMethods::editPayingMethod($newMethod, $oldMethod)){
			Flash::addMessage('Udało się z edytować metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się z edytowac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
		
	}
	
	public function editIncomeCategoryAction(){
		
		$newCategory = $_POST['category'];
		$oldCategory = $_POST['editCategoryRadio'];
		
		if(IncomeCategory::editIncomeCategory($newCategory, $oldCategory)){
			Flash::addMessage('Udało się z edytować metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się z edytowac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
	public function editExpenseCategoryAction(){
		
		$newCategory= $_POST['category'];
		$limitAmount= $_POST['limitAmount'];
		$oldCategory = $_POST['editCategoryRadio'];
		
		if(ExpenseCategory::editExpenseCategory($newCategory, $oldCategory, $limitAmount)){
			Flash::addMessage('Udało się z edytować metodę płatności');
		}
		else {
			Flash::addMessage('Nie udało się z edytowac metody płatności, proszę ponowić próbę',Flash::WARNING);
        }
		$this->newAction();
	}
	
}
