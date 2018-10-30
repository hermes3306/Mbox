<?php
    $mbox_home  =   getenv('mbox_home',true) ? getenv('mbox_home', true) : '.';
    require     $mbox_home . '/vendor/autoload.php';
    require     $mbox_home . '/src/mbox.php';

    $mbox = new mbox($mbox_home . '/mbox.ini');

    $mbox->campaign(6, "캠페인 5 - Waffle 쿠폰 사용 현황");
    $mbox->send();
?>
