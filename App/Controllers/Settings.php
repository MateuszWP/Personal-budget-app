<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use \App\Models\User;
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
        View::renderTemplate('Settings/new.html');
    }

	public function changePersonalInfoAction()
    {
        $user = User::findById($_SESSION['user_id']);
		
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];

        if ($user->changePersonalInfo($name, $email, $password)) {
			Flash::addMessage('Udało się zmienić dane użytkownika');
			View::renderTemplate('Settings/new.html');
			 
        } else {
			Flash::addMessage('Nie udało się zmienić danych użytkowaika, proszę ponowić próbę',Flash::WARNING);
            View::renderTemplate('Settings/new.html', [
                'user' => $user
            ]);

        }
    }
}
