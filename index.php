<?php
require('BaseConvert.php');
require('Reference.php');

$BC = new BaseConvert();
$r  = new Reference($BC);

for($id = 101; $id <=1000; $id++) {

    echo 'Original: ' . $id . '<br/>';
    $code = $r->encode('APP', $id );
    echo 'Encoded: ' . $code . '<br/>';
    echo 'Decoded:' .  $r->decode($code)->id() . '<br/>';
    echo 'Type:' . $r->decode($code)->type() . '<br/>';
    echo '---<br/>';

}
