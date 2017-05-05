#!/usr/bin/python

import serial
import os

ser=serial.Serial('/dev/ttyACM0',9600)
while 1:
	print("Soil Moisture")
	moist=ser.readline()
	print(moist)
	
	print("Temperature")
	temp=ser.readline()
	print(temp)
	
	print("Light")
	light=ser.readline()
	print(light)
	
	print("Humidity")
	humid=ser.readline()
	print(humid)
	
	#write to file here
	#text_file = open("data.txt","w")
	#text_file.write(moist  + temp  + light  + humid )
	#text_file.close()
		
	
	#os.system("java writedata");
