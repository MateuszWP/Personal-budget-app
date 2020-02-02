<?php


require_once 'showBalance.php';

if(isset( $_POST['periodOfTime'] )) {
     $myShowBalance = new showBalance();
     $result = $myShowBalance->decideAction();
}
