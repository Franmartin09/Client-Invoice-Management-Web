<?php
//COMMENT
#COMMENT
$color="red";
echo "<h1>Pagina Web Prueva PHP!<br></h1>";
echo "color of World is " . $color . "<br>";
echo "color of World is " . $color;

echo "<br>";

$x=5;

function pass_var($y){
    echo "The value inside of X = " . $y . "<br>";
}
pass_var($x);
echo "The value outside of X = " . $x . "<br>";

$value1=15;
$value2=1;
$value3=5;
$value4=25;
function global_var(){
    global $value1,$value2,$value3,$value4;
    echo "The values are: <br>";
    echo "value1 = " . $value1 . "<br>";
    echo "value2 = " . $value2 . "<br>";
    echo "value3 = " . $value3 . "<br>";
    echo "value4 = " . $value4 . "<br>";
}
global_var();
echo "The value outside of X = " . $x . "<br>";

$string="ESTO ES UN STRING";
$int = 5985;
$float = 59.85;
var_dump($string);
echo "<br>";
var_dump($int);
echo "<br>";
var_dump($float);
?>