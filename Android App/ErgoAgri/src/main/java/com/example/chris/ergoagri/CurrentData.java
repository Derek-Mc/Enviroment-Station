package com.example.chris.ergoagri;

import android.app.Activity;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.TextView;

public class CurrentData extends Activity {

    double[] temp;
    double[] humid;
    double[] light;
    double[] moist;
    String tempdata;
    String humiddata;
    String lightdata;
    String moistdata;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_current_data);

        if (tablet()) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        }

        TextView temptext = (TextView) findViewById(R.id.curTemp);
        TextView humidtext = (TextView) findViewById(R.id.curHumid);
        TextView lighttext = (TextView) findViewById(R.id.curLight);
        TextView moisttext = (TextView) findViewById(R.id.curMoist);
        Intent i = getIntent();

        temp=i.getDoubleArrayExtra("temp");
        humid=i.getDoubleArrayExtra("humid");
        light=i.getDoubleArrayExtra("light");
        moist=i.getDoubleArrayExtra("moist");

        //the data at index 0 is the most recent entry in the database, so I pull these records out and display them to the user.
        tempdata=temp[0]+ "°C";
        temptext.setText(tempdata);
        humiddata=humid[0]+ "%";
        humidtext.setText(humiddata);
        lightdata=light[0]+" ";
        lighttext.setText(lightdata);
        moistdata=moist[0]+ "%";
        moisttext.setText(moistdata);

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
        getMenuInflater().inflate(R.menu.menu_current_data, menu);
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
