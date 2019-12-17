<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class Expense extends \Core\Model
{

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
	 
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
	
	
    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO expenses (userId, amount, date, payingMethod ,category, comment)
                    VALUES (:userId, :amount, :date, :payingMethod, :category, :comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':payingMethod', $this->payingMethod, PDO::PARAM_STR);
            $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
        // Amount
        if ($this->amount == '') {
            $this->errors[] = 'Name is required';
        }

		if ($this->amount < 0) {
            $this->errors[] = 'Wartosc musi być większa od zera';
        }
    }

    /**
     * Find a user model by ID
     *
     * @param string $id The user ID
     *
     * @return mixed User object if found, false otherwise
     */
	 public static function findByDateOrCategory($year, $month='', $category ='')
    {
		if($month =='' && $category == true)
			$sql = 'SELECT SUM(amount) as sum, category FROM expenses WHERE userId = :userId && year(date) = :year GROUP BY category';
		else if($month =='')
			$sql = 'SELECT date, amount, category FROM expenses WHERE userId = :userId && year(date) = :year';
		else if($category == '')
			$sql = 'SELECT date, amount, category FROM expenses WHERE userId = :userId && month(date) = :month && year(date) = :year';
		else
			$sql = 'SELECT SUM(amount) as sum, category FROM expenses WHERE userId = :userId && month(date) = :month && year(date) = :year GROUP BY category' ;
		
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        if($month !=='') $stmt->bindValue(':month', $month, PDO::PARAM_STR);
        $stmt->bindValue(':year', $year, PDO::PARAM_STR);


  //     $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }
}
