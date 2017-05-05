int moistPin = A0;
int tempPin = A1;
int lightPin = A2;
int humidPin = A3;
int motorPin = A5;
float moist = 0.0;
float temp = 0.0;
float light = 0.0;
float humid = 0.0;
int waterFlag=0;
float dryAmount=72.0;
float hydrateAmount=45.0;
int boardID = 1;

void setup(){
  // put your setup code here, to run once:
  Serial.begin(9600);
  pinMode(moistPin, INPUT);//moisture
  pinMode(tempPin, INPUT);//temp
  pinMode(lightPin, INPUT);//light
  pinMode(humidPin, INPUT);//humid
  pinMode(motorPin, OUTPUT);//motor
}//end setup

void loop(){
  // put your main code here, to run repeatedly:
  //reset values to 0 to ensure that data being transmitted is new data (for testing purposes)
  moist = 0;
  temp = 0;
  light = 0;
  humid = 0;
  waterFlag = 0;

  //read data from pins and store into temp memory
  moist = analogRead(moistPin);
  moist = ((moist*0.9765625)/10);//convert value ranging from 0-1023 to a number between 0-99
  
  temp = analogRead(tempPin);
  temp=((((temp*5)/1024)-0.5)*100);//https://learn.adafruit.com/tmp36-temperature-sensor/using-a-temp-sensor
  
  humid = humidConv(temp);
  
  light = lightConv();
  
  Serial.println(moist);
  delay(1000);
  Serial.println(temp);
  delay(1000);
  Serial.println(light);
  delay(1000);
  Serial.println(humid);
  
  //watering if soil moisture is lower than allowed dry amount
  
	if(moist<=hydrateAmount)
	{
		digitalWrite(motorPin,HIGH);
    		delay(60000);
		//delay(1000);
    		digitalWrite(motorPin,LOW);
    		waterFlag=1;	
	}

	if((moist<=dryAmount)&&(waterFlag==0))
	{
    		digitalWrite(motorPin,HIGH);
    		delay(20000);
		//delay(500);
    		digitalWrite(motorPin,LOW);
                delay(40000);
    		waterFlag=2;
  	}
  
        if(waterFlag==0)
        {
          delay(60000);
        }

  //Ensures that the measuring data timing does float away over time.
  /*if(waterFlag==1){
    delay(57000);}
  else if(waterflag==2){
    delay(15000);
}
else{
    delay(57000);
}*/

  //1h between measurements
  for (int x = 0; x < 59; x++)
  {
    for (int y = 0; y < 60; y++)
    {
      delay(1000);
    }
  }//end of 1h wait
  
}

//https://learn.adafruit.com/adafruit-ga1a12s202-log-scale-analog-light-sensor/use-it
float lightConv()
{
  float rawRange = 1024;
  float logRange = 5.0;
  float data=0.0;
  float value=0.0;
  int raw=0;
  
  analogReference(EXTERNAL);
  for (int x=0;x<10;x++)
  {
    raw=analogRead(lightPin);
  }
   value = (raw*logRange/rawRange);
   data=pow(10,value);
    
  analogReference(DEFAULT);
  
  for(int x=0;x<10;x++)  
  {
    raw=analogRead(lightPin);
  }
  
  return data;
  
}
float humidConv(float temp)//http://bildr.org/2012/11/hih4030-arduino/
{
    int raw = analogRead(humidPin);
    float supplyVolt=5.0;
    float voltage = raw/1023.0*supplyVolt;
    float sensorRH = 161.0*voltage/supplyVolt - 25.8;
    float trueRH = sensorRH/(1.0546 - 0.0026*temp);
    
    return trueRH;
}
