<?php

namespace App\Models;

use PDO;

/**
 * User model
 *
 * PHP version 7.0
 */
class ExpenseCategory extends \Core\Model
{
	
	public static function setUserCategoriesAfterSingup($userId){
		
		$myfile = fopen("expenseCategories.txt", "r") or die("Unable to open file!");
		
		while(!feof($myfile)){
			$category = chop(fgets($myfile));
			$sql = 'INSERT INTO expenseCategories (userId, categoryName)
                    VALUES (:userId, :categoryName)';
					
			$db = static::getDB();
            $stmt = $db->prepare($sql);
		
			$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':categoryName', $category, PDO::PARAM_STR);
			
			$stmt->execute();
		}
		
		fclose($myfile);
	}
	
	public static function findByID($id)
    {
        $sql = 'SELECT * FROM expenseCategories WHERE userId = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

       $stmt->execute();
		
        return $stmt->fetchAll();
		
    }
	
	public static function deleteExpenseCategory($method){
		$sql = 'DELETE FROM expenseCategories WHERE userId = :userId AND categoryName= :expenseCategory';

		$db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':expenseCategory', $method, PDO::PARAM_STR);
		
		return $stmt->execute();
	}
	
	
	public static function addExpenseCategory($method){
		
		if($method!=''){
			$sql = 'INSERT INTO expenseCategories (userId, categoryName)
                    VALUES (:userId, :categoryName)';
		
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':categoryName', $method, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		else{
			return false;
		}
	}
	
	public static function editExpenseCategory($newCategory, $oldCategory, $limitAmount=0){
		
		if($newCategory!=''){
			
			$sql = 'UPDATE expenseCategories 
						SET categoryName = :newExpenseCategory, limitAmount = :limitAmount
						WHERE categoryName = :oldExpenseCategory AND userId = :userId';
		
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':newExpenseCategory', $newCategory, PDO::PARAM_STR);
			$stmt->bindValue(':limitAmount', $limitAmount, PDO::PARAM_STR);
			$stmt->bindValue(':oldExpenseCategory', $oldCategory, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		else if($newCategory==''){
			$sql = 'UPDATE expenseCategories 
						SET limitAmount = :limitAmount
						WHERE categoryName = :oldExpenseCategory AND userId = :userId';
		
			$db = static::getDB();
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userId', $_SESSION['user_id'], PDO::PARAM_INT);
			$stmt->bindValue(':limitAmount', $limitAmount, PDO::PARAM_STR);
			$stmt->bindValue(':oldExpenseCategory', $oldCategory, PDO::PARAM_STR);
			
			return $stmt->execute();
		}
		else{
			return false;
		}
	}
	
	public static function getLimitForCategory($category){
		$sql = 'SELECT limitAmount FROM expenseCategories WHERE userId = :id AND categoryName = :category';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->bindValue(':category', $category, PDO::PARAM_STR);

        //$stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
		
		return $stmt->fetch();
	}
}
