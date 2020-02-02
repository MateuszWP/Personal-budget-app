<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class PayingMethods extends \Core\Model
{
	
	public static function setUserCategoriesAfterSingup($userId){
		
		$myfile = fopen("payingMethods.txt", "r") or die("Unable to open file!");
		
		while(!feof($myfile)){
			$category = chop(fgets($myfile));
			$sql = 'INSERT INTO payingmethods (userId, payingMethod)
                    VALUES (:userId, :payingMethod)';
					
			$db = static::getDB();
            $stmt = $db->prepare($sql);
		
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':payingMethod', $category, PDO::PARAM_STR);
			
			$stmt->execute();
		}
		
		fclose($myfile);
	}
	
	
	 public static function findByID($id)
    {
        $sql = 'SELECT * FROM payingmethods WHERE userId = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

       $stmt->execute();
		
        return $stmt->fetchAll();
		
    }
	
	public static function deletePayingMethod($method){
		$sql = 'DELETE FROM payingMethods WHERE userId = :userId AND payingMethod = :payingMethod';
		
		$db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':payingMethod', $method, PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	public static function addPayingMethod($method){
		
		if($method!=''){
			$sql = 'INSERT INTO payingMethods (userId, payingMethod)
                    VALUES (:userId, :payingMethod)';
		
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':payingMethod', $method, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		else{
			return false;
		}
		
	}
	
	
	public static function editPayingMethod($newMethod, $oldMethod){
		
		if($newMethod!=''){
			
			$sql = 'UPDATE payingMethods 
						SET payingMethod = :newPayingMethod
						WHERE payingMethod = :oldPayingMethod AND userId = :userId';
		
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':newPayingMethod', $newMethod, PDO::PARAM_STR);
			$stmt->bindValue(':oldPayingMethod', $oldMethod, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		else{
			return false;
		}
		
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
