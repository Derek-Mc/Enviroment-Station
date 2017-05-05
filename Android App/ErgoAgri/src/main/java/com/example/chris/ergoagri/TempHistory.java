package com.example.chris.ergoagri;

import android.app.Activity;
import android.content.Intent;
import android.content.pm.ActivityInfo;
import android.content.res.Configuration;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.TextView;

public class TempHistory extends Activity {

    int[] date;
    double[] temp;
    String display;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_temp_history);

        if (tablet()) {
            setRequestedOrientation(ActivityInfo.SCREEN_ORIENTATION_LANDSCAPE);
        }

        Intent i = getIntent();
        date=i.getIntArrayExtra("date");
        temp=i.getDoubleArrayExtra("temp");

        TextView text = (TextView) findViewById(R.id.textViewTemp2);
        text.setMovementMethod(new ScrollingMovementMethod());
        display = (date[0]) + "\t\t\t\t" + temp[0] + "°C" + "\n";

        for(int x=1;x<date.length;x++)
        {
            display += (date[x])+ "\t\t\t\t" + temp[x] + "°C" + "\n";
        }
        text.setText(display);
    }

    public void gotoTempGraph(View view)
    {
        Intent intent = new Intent(TempHistory.this,TempGraph.class);
        intent.putExtra("date", date);
        intent.putExtra("temp",temp);
        TempHistory.this.startActivity(intent);
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
        getMenuInflater().inflate(R.menu.menu_temp_history, menu);
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
