#PiTank
The PiTank is a small RC car with a Raspberry Pi for a brain. It is controlled over a Wi-Fi network through a TCP/IP socket, and streams back live video from an on-board webcam. The PiTank gets power from 12V battery and a switching voltage regulator for a steady five volts. 

#What you need
- Raspberry pi
- SD card with > 2GB capacity  
- Usb WiFi dongle for the Raspberry pi
- Recycled Car with 2 DC motors
- 12V battery
- L293D driver
- Usb Webcam or any recycled notebook webcam (i used the acer crystal eye from the aspire 5720)
- HC-SR04 Ultrasonic Distance Sensor Module  
- DS18B20 temperature sensor

#Preparing raspberry pi

###Install Raspbian Debian Wheezy 
http://www.raspberrypi.org/documentation/installation/installing-images/README.md

###Install Apache2/php5/Postgresql
- sudo apt-get install apache2
- sudo apt-get install php5 libapache2-mod-php5
- sudo apt-get install postgresql
- sudo apt-get install php5-pgsql

###Configure Postgresql
- sudo -u postgres createuser pi
- sudo -u postgres createdb pi

###Connecting to the PostgreSQL database from Python
sudo apt-get install python-psycopg2D

###Turn the Raspberry Pi into a WiFi router
http://andypi.co.uk/?page_id=220

###Install the DHCP server
https://learn.adafruit.com/setting-up-a-raspberry-pi-as-a-wifi-access-point/install-software

###Install MJPG-Streamer
http://blog.miguelgrinberg.com/post/how-to-build-and-run-mjpg-streamer-on-the-raspberry-pi

#Configuration
Copy the files in the conf directory into the raspberry pi, in these directory:
- /etc/network/interface
- 




