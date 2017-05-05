#!/usr/bin/python

import serial

ser=serial.Serial('/dev/ttyACM0',9600)
while 1:
	print("Soil Moisture")
	print(ser.readline())
	print("Temperature")
	print(ser.readline())
	print("Light")
	print(ser.readline())
	print("Humidity")
	print(ser.readline())
