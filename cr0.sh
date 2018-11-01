#!/bin/bash
sleep 10
cd /home/pi/code/MBox/
export mbox_home=`pwd`
php /home/pi/code/MBox/src/cr0.php
