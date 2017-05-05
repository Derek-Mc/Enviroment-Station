package com.example.chris.ergoagri;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Environment;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.Toast;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileOutputStream;
import java.io.FileReader;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;
import java.net.HttpURLConnection;
import java.net.URI;
import java.net.URL;
import java.util.Scanner;

public class MainMenu extends Activity {
    int[] date;
    double[] temp;
    double[] light;
    double[] humid;
    double[] moist;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_menu);

        if (tablet()) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        }

        //Giving a default array of values, mainly used for testing to ensure that data was updated
        date=new int[]{      1, 2, 3, 4, 5, 6, 7, 8, 9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24};
        temp=new double[]{   0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
        light=new double[]{  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
        humid=new double[]{  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
        moist=new double[]{  0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
        newUpdate();
    }

    //go to Current Data screen
    public void gotoCurrent(View view)
    {
        Intent intent = new Intent(MainMenu.this, CurrentData.class);
        intent.putExtra("date",date);
        intent.putExtra("temp",temp);
        intent.putExtra("humid",humid);
        intent.putExtra("light",light);
        intent.putExtra("moist", moist);
        MainMenu.this.startActivity(intent);
    }

    //go to Temperature History screen, and from there are able to continue to the graph.
    public void gotoTemp(View view)
    {
        Intent intent = new Intent(MainMenu.this, TempHistory.class);
        intent.putExtra("date",date);
        intent.putExtra("temp",temp);
        MainMenu.this.startActivity(intent);
    }

    //go to Light History screen, and from there are able to continue to the graph.
    public void gotoLight(View view)
    {
        Intent intent = new Intent(MainMenu.this,LightHistory.class);
        intent.putExtra("date",date);
        intent.putExtra("light",light);
        MainMenu.this.startActivity(intent);
    }

    //go to Moisture History screen, and from there are able to continue to the graph.
    public void gotoMoisture(View view)
    {
        Intent intent = new Intent(MainMenu.this,MoistureHistory.class);
        intent.putExtra("date",date);
        intent.putExtra("moist",moist);
        MainMenu.this.startActivity(intent);
    }

    //go to Humidity History screen, and from there are able to continue to the graph.
    public void gotoHumid(View view)
    {
        Intent intent = new Intent(MainMenu.this,HumidHistory.class);
        intent.putExtra("date",date);
        intent.putExtra("humid",humid);
        MainMenu.this.startActivity(intent);
    }

    //This is the function that runs in the oncreate to sync the local database with the one on the server.

    public void newUpdate()
    {
        new LoadDataActivity(getBaseContext(), 0).execute();
    }


    private class LoadDataActivity extends AsyncTask<String, Void, String> {
        private Context context;
        private int byGetOrPost = 0;
        JSONArray stuff = null;
        private static final String TAG_JSONNAME = "stuff";
        private static final String TAG_TEMP = "temp";
        private static final String TAG_LIGHT = "light";
        private static final String TAG_HUMID = "humid";
        private static final String TAG_MOIST = "moist";

        //flag 0 means get and 1 means post.(By default it is get.)
        public LoadDataActivity(Context context, int flag) {
            this.context = context;
            byGetOrPost = flag;
        }

        //Creates a progressdialog so the user knows the app is performing actions.
        protected void onPreExecute() {}

        //Connects to database and recieves a JSONArray
        @Override
        protected String doInBackground(String... arg0) {
            if (byGetOrPost == 0) { //means by Get Method
                try {
                    String link = "http://ergoagri.esy.es/ErgoData.php"; //makes this your url to the php script
                    link = link.replaceAll(" ", "%20");

                    URL url = new URL(link);
                    HttpClient client = new DefaultHttpClient();
                    HttpGet request = new HttpGet();
                    request.setURI(new URI(link));
                    HttpResponse response = client.execute(request);
                    HttpEntity httpEntity = response.getEntity();
                    String myResponse = EntityUtils.toString(httpEntity);

                    // Making a request to url and getting response
                    Log.d("Response: ", "> " + myResponse);

                    if (myResponse != null) {
                        try {
                            JSONObject jsonObj = new JSONObject(myResponse);
                            // Getting JSON Array node
                            stuff = jsonObj.getJSONArray(TAG_JSONNAME);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    } else {
                        Log.e("ServiceHandler", "Couldn't get any data from the url");
                    }
                    return null;
                } catch (Exception e) {
                    return "Exception: " + e.getMessage();
                }
            } else {
                return "False";
            }
        }

        //Iterates through the data gathered from the return string and displays it.
        @Override
        protected void onPostExecute(String result) {
            try {
                // looping through All Contacts
                for (int i = 0; i < stuff.length(); i++) {

                    JSONObject c = stuff.getJSONObject(i);

                    temp[i] = c.getDouble(TAG_TEMP);
                    light[i] = c.getDouble(TAG_LIGHT);
                    humid[i] = c.getDouble(TAG_HUMID);
                    moist[i] = c.getDouble(TAG_MOIST);

                }
            } catch (JSONException e) {
                e.printStackTrace();
            }
        }
    }

    public void autoupdate()
    {
        try {
            Toast.makeText(MainMenu.this, "Loading Database", Toast.LENGTH_SHORT).show();
            new Thread() {

                @Override
                public void run() {

                    try {

                        URL url = new URL("http://phdeats.esy.es/ergodata.txt");
                        HttpURLConnection urlConnection;

                        File sdcard = Environment.getExternalStorageDirectory();
                        File dir = new File(sdcard.getAbsolutePath() + "/tmp/");
                        dir.mkdir();
                        File remoteFile = new File(dir, "data.txt");
                        String StringBuffer2=new String();

                        //File remoteFile = new File(path + saveTo);

                        if (remoteFile.exists()) {
                            try {
                                //url = new URL(toDownload);
                                urlConnection = (HttpURLConnection) url.openConnection();
                                int responceCode = urlConnection.getResponseCode();
                                if (responceCode == 200) {
                                    BufferedReader bufferedReader = new BufferedReader(new InputStreamReader(url.openStream()));
                                    String StringBuffer;

                                    FileOutputStream outStream = new FileOutputStream(remoteFile);
                                    OutputStreamWriter osw = new OutputStreamWriter(outStream);

                                    while ((StringBuffer = bufferedReader.readLine()) != null) {
                                        //osw.append(StringBuffer + "\n");
                                        StringBuffer2 += StringBuffer + "\n";
                                    }
                                    osw.write(StringBuffer2);
                                    osw.close();
                                    outStream.close();
                                    bufferedReader.close();
                                    //outStream.close();
                                    //osw.close();
                                }
                            } catch (Exception e) {
                                e.printStackTrace();
                            }
                        }
                        try {
                            //File sdcard = Environment.getExternalStorageDirectory();
                            //File dir = new File(sdcard.getAbsolutePath() + "/tmp/");
                            File fileread = new File(dir, "data.txt");
                            StringBuilder text = new StringBuilder();
                            BufferedReader br = new BufferedReader(new FileReader(fileread));
                            int x=0;
                            int arrayindex=0;
                            String line;

                            while ((line = br.readLine()) != null) {
                                text.append(line);
                                text.append('\n');
                            }
                            br.close();

                            Scanner scan = new Scanner(text.toString());
                            scan.useDelimiter("\n");

                            while (arrayindex<20) {
                                if(x==0)
                                {
                                    date[arrayindex]=Integer.parseInt(scan.next());
                                    x=1;
                                }
                                if (x==1)
                                {
                                    temp[arrayindex]=Integer.parseInt(scan.next());
                                    x=2;
                                }
                                if (x==2)
                                {
                                    light[arrayindex]=Integer.parseInt(scan.next());
                                    x=3;
                                }
                                if (x==3)
                                {
                                    humid[arrayindex]=Integer.parseInt(scan.next());
                                    x=4;
                                }
                                if (x==4)
                                {
                                    moist[arrayindex]=Integer.parseInt(scan.next());
                                    arrayindex++;
                                    x=0;
                                }
                            }
                            br.close();
                        }
                        catch (Exception e) {
                            e.printStackTrace();
                        }
                    }
                    catch (Exception e)
                    {
                        e.printStackTrace();
                    }
                }
            }.start();
        }catch (Exception e) {
            e.printStackTrace();
        }

    }

    //This function is called when the user presses the update button and runs the update function
    public void update(View view) {
        newUpdate();
    }

    //Checks to see if the device is a tablet and returns true if it is
    private boolean tablet() {
        return (this.getResources().getConfiguration().screenLayout
                & Configuration.SCREENLAYOUT_SIZE_MASK)
                >= Configuration.SCREENLAYOUT_SIZE_LARGE;
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
