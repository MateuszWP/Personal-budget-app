<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;
use \App\Models\IncomeCategory;
use \App\Models\ExpenseCategory;
use \App\Models\PayingMethods;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{

    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save()) {
			IncomeCategory::setUserCategoriesAfterSingup(User::findByEmail($user->email)->id);
			ExpenseCategory::setUserCategoriesAfterSingup(User::findByEmail($user->email)->id);
			PayingMethods::setUserCategoriesAfterSingup(User::findByEmail($user->email)->id);
			
			Flash::addMessage('Rejestracja udana');
			View::renderTemplate('Login/new.html');
			 
            //$this->redirect('/signup/success');

        } else {
			Flash::addMessage('Nieudana rejestracja, proszę ponowić próbę',Flash::WARNING);
            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }
    }

    /**
     * Show the signup success page
     *
     * @return void
     */
    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }
}
