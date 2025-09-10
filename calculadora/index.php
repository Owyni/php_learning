<?php   

function sum($a4, $b4)
{
    return $a4 + $b4;
}

$c = sum(5, 10);
echo "The sum of 5 and 10 is " . $c;

function multiply($a, $b)
{
    return $a * $b;
}
echo "\nThe product of 5 and 10 is " . multiply(5, 10);

function divide($a1, $b1)
{
    if ($b1 == 0) {
        return "Error: Division by zero";
    }
    return $a1 / $b1;
}
echo "\nThe division of 10 by 2 is " . divide(10, 2);

function subtract($a2, $b2)
{
    return $a2 - $b2;
}
echo "\nThe subtraction of 10 from 5 is " . subtract(5, 10);

?>
