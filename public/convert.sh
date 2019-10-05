#!/bin/bash
# cding into firmwares folder and converting the hex to bin 
cd ../storage/app/firmwares/
/usr/bin/avr-objcopy -I ihex $1 -O binary $1.bin
