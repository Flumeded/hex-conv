!/bin/bash
# mkdir /home/nikita/conv/hex-conv/storage/app/firmware/
cd /home/nikita/conv/hex-conv/storage/app/firmware/
avr-objcopy -I ihex 6ball.hex -O binary FLASH.BIN