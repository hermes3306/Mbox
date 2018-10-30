#!/bin/bash
sleep 10
cd /home/pi/code/MBox/
export mbox_home=`pwd`
php src/cr0.php
