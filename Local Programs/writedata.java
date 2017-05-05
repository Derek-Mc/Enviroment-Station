import java.io.*;
import java.net.*;

public class writedata
{				
	public static void main(String[] args)
	{	
		String fileName=("data.txt");
		String input = null;
		
		//https://www.caveofprogramming.com/java/java-file-reading-and-writing-files-in-java.html
		try
		{
			FileReader fileRead=new FileReader(fileName);
			BufferedReader buffRead = new BufferedReader(fileRead);
			
			
			
			double moist=Double.parseDouble(buffRead.readLine());
			System.out.println("Soil Moisture: "+moist);
			
			double temp=Double.parseDouble(buffRead.readLine());
			System.out.println("Temperature: "+temp);
			
			double light=Double.parseDouble(buffRead.readLine());
			System.out.println("Light: "+light);
			
			double humid=Double.parseDouble(buffRead.readLine());
			System.out.println("Humidity: "+humid);
		
			String link = "http://ergoagri.esy.es/ErgoWrite.php?Temperature="+temp+"&Humidity="+humid+"&Light="+light+"&Moisture="+moist;
			//test
			System.out.println(link);
			buffRead.close();
			
			
			
			URL senddata = new URL(link);
			URLConnection yc = senddata.openConnection();
			BufferedReader in = new BufferedReader(new InputStreamReader(yc.getInputStream()));
			String inputLine;
			while ((inputLine = in.readLine()) != null) 
				System.out.println(inputLine);
			in.close();
			
		
		}
		catch(Exception e){
			System.out.println(e);
		}
	}
}
