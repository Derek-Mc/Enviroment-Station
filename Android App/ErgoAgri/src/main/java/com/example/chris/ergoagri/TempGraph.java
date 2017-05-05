package com.example.chris.ergoagri;

import android.app.Activity;
import android.content.Intent;
import android.graphics.Color;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import com.jjoe64.graphview.DefaultLabelFormatter;
import com.jjoe64.graphview.GraphView;
import com.jjoe64.graphview.series.DataPoint;
import com.jjoe64.graphview.series.DataPointInterface;
import com.jjoe64.graphview.series.LineGraphSeries;
import com.jjoe64.graphview.series.OnDataPointTapListener;
import com.jjoe64.graphview.series.Series;

public class TempGraph extends Activity {

    int[] date;
    double[] temp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_temp_graph);

        GraphView mygraph = (GraphView) findViewById(R.id.tempGraph);

        Intent i = getIntent();
        date=i.getIntArrayExtra("date");
        temp=i.getDoubleArrayExtra("temp");

        //create the array of datapoints to display data.
        DataPoint[] mydata = new DataPoint[date.length];
        for(int x=0;x<date.length;x++)
        {
            mydata[x]=new DataPoint(date[x],temp[x]);
        }

        //setting the parameters for the graph itself
        LineGraphSeries<DataPoint> series = new LineGraphSeries<DataPoint>(mydata);
        series.setColor(Color.RED);
        mygraph.getViewport().setXAxisBoundsManual(true);
        mygraph.getViewport().setMinX(0);
        mygraph.getViewport().setMaxX(date.length);
        mygraph.getViewport().setYAxisBoundsManual(true);
        mygraph.getViewport().setMinY(0);
        mygraph.getViewport().setMaxY(40);

        mygraph.addSeries(series);
        //displays a toast when the user presses on the graph to show the exact data at that point.
        series.setOnDataPointTapListener(new OnDataPointTapListener() {
            @Override
            public void onTap(Series series, DataPointInterface dataPoint) {
                Toast.makeText(TempGraph.this, dataPoint.getY()+"°C, " + (int)dataPoint.getX() + " hour(s) ago.", Toast.LENGTH_SHORT).show();
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_temp_graph, menu);
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
