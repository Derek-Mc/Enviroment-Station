<?php include 'prototypeheader.php';?>


		<DIV ID="Wrapper">

			<ARTICLE ID="Article_1">
				<HEADER ID="Header_Article_1">
					<H2>Seed Germination - Build Instructions</H2>
				</HEADER>

				<SECTION ID="Section_1">
					<H3>Introduction</H3>
					<P>The goal of this project is to create a unit that can monitor the surrounding temperature, light level, humidity, and the soil moisture around the plant as it is going through the germination process and to provide it with water when the soil becomes too dry.</P>
				</SECTION>

				<SECTION ID="Section_2">
					<H3>Bill of Materials</H3>
					<P><a href="http://www.amazon.ca/Arduino-A000066-Uno-R3-Microcontroller/dp/B008GRTSV6/ref=sr_1_1?ie=UTF8&qid=1449726852&sr=8-1&keywords=arduino+uno"target="_blank">Arduino Uno - $28.99</a>
					   <br><a href="http://www.amazon.ca/gp/product/B00MV6TAJI?psc=1&redirect=true&ref_=oh_aui_detailpage_o05_s00"target="_blank"> Raspberry Pi starter kit - $89.95</a>
					   <br><a href="https://www.adafruit.com/products/62"target="_blank">USB cable (Pi to Arduino) - $3.95</a>
					   <br><a href="https://www.adafruit.com/products/1150?&main_page=product_info&products_id=1150"target="_blank">Water pump - $24.95</a>
					   <br><a href="https://www.adafruit.com/products/63"target="_blank">Power adapter (Arduino) - $6.95</a>
					   <br><a href="https://www.adafruit.com/products/755?&main_page=product_info&products_id=755"target="_blank">Diode - $1.50</a>
					   <br><a href="https://www.adafruit.com/products/165"target="_blank">Temperature sensor - $1.50</a>
					   <br><a href="https://www.sparkfun.com/products/9569"target="_blank">Humidity sensor - $16.95</a>
					   <br><a href="https://www.adafruit.com/product/1384"target="_blank">Light sensor - $3.95</a>
					   <br><a href="http://www.amazon.ca/gp/product/B00AFCNR3U?psc=1&redirect=true&ref_=oh_aui_detailpage_o02_s00"target="_blank">Soil moisture sensor - $1.93 (I recommend ordering from Phantom YoYo as it is about half the cost!)</a>
					   <br><a href="http://www.digikey.ca/product-detail/en/MTP3055VL/MTP3055VLFS-ND/1055090"target="_blank">MOSFET - $1.65</a>
					   <br><a href="http://www.amazon.com/E-Projects-470k-Resistors-Watt-Pieces/dp/B00IYU99Q4/ref=sr_1_9?s=industrial&ie=UTF8&qid=1449730299&sr=1-9&keywords=470K+Ohm+Resistors"target="_blank">470k&#8486; Resistor - $4.44  (You only need a single resistor between 100k&#8486; and 1M&#8486;)</a>
					   <br><a href="https://www.adafruit.com/products/289"target="_blank">Hook-up wire - $2.50</a>
					   
					   <br>Total before shipping and taxes - $172.24
					</P>
				</SECTION>

				<SECTION ID="Section_3">
					<H3>Time Commitment</H3>
					<P>The time it would take to reproduce the project is about three hours is using the code
						provided and if you already have the materials, longer if you want to create the code by yourself.
						If using the code provided, some slight modifications need to be made to write to your own server.  
					</P>
				</SECTION>

				<SECTION ID="Section_4">
					<H3>Mechanical Assembly</H3>
					Below is a guide on how the circuit is assembled should you choose not 
					to use a PCB or wish to create a prototype of the circuit on a breadboard.
					<br><br>
					<P>The pump:
					<br>Connect the Vin pin on the Arduino to the positive pin on the pump, 
					next connect the negative pin on the pump to the drain pin of the MOSFET.
					Connect a diode across the two pump pins so that the negative side of the 
					diode is towards the positive pin on the pump.  Connect the gate pin to the Arduino analog
					pin 5.  Put a 470k&#8486; from the gate pin to ground.  Connect the source pin to ground.
					
					
					<br>
					<img style="margin:0px auto;display:block" src="schematic2.png"/>
					<br>
					<br>The sensors:
					<br>Connect all of the sensor's 5V pins to the fixed 5V pin of the Arduino.  
					Next, connect them all to a common ground
					(I chose to use separate grounds for the pump and the sensors, to make use of the 2 ground pins.).
					  Next, connect the data pins to their respective pins as shown in the Arduino .ino 
					  file included in the project folder.
					  <br>
					  <img style="margin:0px auto;display:block" src="schematic1.png"/>
					  <br><b>IMPORTANT NOTE:  Because the light sensor does not return a value greater than 3V to the Arduino, connect the 3.3V pin to the AREF pin on the opposite side of the board.
					  The code will use this connection to get a more accurate reading of the light level.
					</b>
					<br><br>
					The box:
					<br>Included in the Project Files folder are the files to have a lazer cutter cut out the dividers for the box shown.  The long piece is a middle divider between the soil
					and the pump and the water reservoir.  The two identicle pieces are to make small compartments for the pump and reservoir to make sure that no water is spilled onto the electronics.  
					The last piece is a platform that I made to allow me to stack the Arduino on top of the Raspberry Pi to allow them to both fit in the compartment and still have enough room for the 
					cords.  I used Gorilla Glue to hold together the pieces of acrylic and to waterproof the compartments to ensure that no water leaked onto the Pi.  Any sort of sealent would work,
					 just ensure that it is waterproof.
					<br>
					<img style="margin:0px auto;display:block" src="box2.jpg"/>
					</P>
				</SECTION>

				<SECTION ID="Section_5">
					<H3>PCB/Soldering</H3>
					<P><a href="Project Files.zip">Project files (Code, PCB files, Schematic Diagrams)</a>
					<br>The soil moisture sensor will be connected to the the board by hook-up wires, so ensure that the wires used are long enough to reach from the sensor, to the soil.
					  The temperature, humidity, and light sensors should be mounted on the top side of the board. The light sensor will be a little tricky to solder because you need to make asecure connection from the 5V line to the top side of the board as the hmidity sensor recieves 5V
					  on the top side. 
					  Ensure when soldering in the MTP3055VL MOSFET that the side with writing on it is facing the resistor,
					  and that the cathode of the diode is connected to the positive pin of the pump.
					</P>
				</SECTION>

				<SECTION ID="Section_6">
					<H3>Power Up</H3>
					<P>Ensure that there are no shorts on the PCB itself before hooking up power to the Arduino.
					This can be done by using an Ohmmeter and checking the resistance between the traces and ensuring that there
					is no shorts (There will be a very small resistance, almost 0&#8486, if there is a short).  After his is done,turn on the Pi
					and open a terminal.  Navigate to the folder containing the Python script and type "python readinputs.py" but do not run the command yet.
					Plug in the Arduino's power supply cable FIRST, then connect to the Pi through the USB port on both devices.  Once the
					they are connected, run the script and you should be seeing the data on the screen.  If the data seems off, the
					script may not be synced up with the display.  To solve this, run the script again after the data stops being transmitted and the output should be synced up.
					
					
					</P>
				</SECTION>

				<SECTION ID="Section_7">
					<H3>Unit Testing</H3>
					<P>The temperature sensor should be returning the correct value of the current temperature in degrees Celsius.  The humidity and soil moisture should be returning a value between 0 and 100, which is the percent value.  The light sensor should be returning the
					current light level in lux.  The light value if you are in a moderately lit room should be around 80lux, the soil moisture should read 0% if it is not placed in soil.  Should any of the values be returning incorrectly,
					 ensure that the sensor is placed in the mounting correctly, and that the solder is correctly applied.
					</P>
				</SECTION>

				<SECTION ID="Section_8">
					<H3>Production Testing</H3>
					<P>Ensure that the pump is turning on once every minute for 5 seconds and that the values returned form then sensors are correct.
					  Should anything not be returning the correct value, or the pump is not turning on (When not in moist soil), follow the unit testing guide above to help troubleshoot your problem.
					  <img style="margin:0px auto;display:block" src="project.jpg"/>
					</P>
					
					</SECTION>

			</ARTICLE>

		</DIV>
		
<?php include 'switchcolumns.php';?>
		
		<NAV>
			<UL>
				<LI><a href="#Section_1">Introduction</a></LI>
				<LI><a href="#Section_2">Bill of Materials</a></LI>
				<LI><a href="#Section_3">Time Commitment</a></LI>
				<LI><a href="#Section_4">Mechanical Assembly</a></LI>
				<LI><a href="#Section_5">PCB/Soldering</a></LI>
				<LI><a href="#Section_6">Power Up</a></LI>
				<LI><a href="#Section_7">Unit Testing</a></LI>
				<LI><a href="#Section_8">Production Testing</a></LI>
			</UL>
		</NAV>

<?php include 'prototypefooter.php';?>

