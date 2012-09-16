<?php
$name = "The optional offset parameter allows you to specify";
echo $name;
echo '<br />';
$off = 0;
$r = 0;
$w = "s";
do
{
    $r = strpos($name, $w, $off);
    $off = $r + 1;
    echo ("  " . $off . $w);
} while(($r = strpos($name, $w, $off)));

echo '<br />';
print_r(count_chars($name,3));
?>