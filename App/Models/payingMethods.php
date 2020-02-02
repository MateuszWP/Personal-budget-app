<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class payingMethods extends \Core\Model
{
	
	public static function setUserCategoriesAfterSingup($userId){
		
		$myfile = fopen("payingMethods.txt", "r") or die("Unable to open file!");
		
		while(!feof($myfile)){
			$category = chop(fgets($myfile));
			$sql = 'INSERT INTO payingMethods (userId, payingMethod)
                    VALUES (:userId, :categoryName)';
					
			$db = static::getDB();
            $stmt = $db->prepare($sql);
		
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':categoryName', $category, PDO::PARAM_STR);
			
			$stmt->execute();
		}
		
		fclose($myfile);
	}
	
    public function save()
    {
        $this->validate();

        if (empty($this->errors)) {

            $sql = 'INSERT INTO incomes (userId, amount, date, category, comment)
                    VALUES (:userId, :amount, :date, :category, :comment)';
					
			
            $db = static::getDB();
            $stmt = $db->prepare($sql);
		
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date', $this->date, PDO::PARAM_STR);
            $stmt->bindValue(':category', $this->category, PDO::PARAM_STR);
            $stmt->bindValue(':comment', $this->comment, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }
}
