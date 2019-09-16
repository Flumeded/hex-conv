!/bin/bash
# mkdir /home/nikita/conv/hex-conv/storage/app/firmware/
cd /var/wwwhex-conv/storage/app/firmware/
avr-objcopy -I ihex $1 -O binary $1.bin