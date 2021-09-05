<?php 


$n = 7;

$a = array(1, 2, 1, 2, 7, 3, 5);


function getPairs($n, $a)
{
    $socks = [];
    $pairedSocks = [];

    for ($i=0; $i <  count($a) ; $i++) {
        if (!in_array($a[$i], $socks)) {
            $socks[] = $a[$i];
        } else {
            $pairedSocks[] = $a[$i];
            $key = array_search($a[$i], $socks);
            unset($socks[$key]);
        }
    }
    echo 'the single socks => ' . PHP_EOL;
    print_r($socks); 

    echo 'the paired socks => ' . PHP_EOL;
    print_r($pairedSocks);

    return count($pairedSocks);
}

echo 'the number of pairs : ' . getPairs($n, $a);
 
