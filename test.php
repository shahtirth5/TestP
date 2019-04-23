<?php
/**
 * Created by PhpStorm.
 * User: Tirth
 * Date: 8/24/2018
 * Time: 5:23 AM
 */

$string = "Tirth Shah <shahtirth5@gmail.com>";
$a = preg_split("/</" , $string);
echo $a[0] . "<br>" . rtrim($a[1] , ">") ;