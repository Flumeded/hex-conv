#!/bin/bash

cd ../storage/app/firmwares/
avr-objcopy -I ihex $1 -O binary $1.bin
