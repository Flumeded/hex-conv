#!/bin/bash
cd /var/www/hex-conv/storage/app/firmware/
avr-objcopy -I ihex $1 -O binary $1.bin