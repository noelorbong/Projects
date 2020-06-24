package ph.edu.hau.wallettracker;

import android.app.ProgressDialog;
import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.text.Html;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.Window;
import android.widget.Toast;

import java.util.List;
import java.util.Timer;
import java.util.UUID;

import ph.edu.hau.wallettracker.Database.SqlLiteHelper;
import ph.edu.hau.wallettracker.Fragment.FragmentAbout;
import ph.edu.hau.wallettracker.Fragment.FragmentBluetooth;
import ph.edu.hau.wallettracker.Fragment.FragmentBluetoothSetting;
import ph.edu.hau.wallettracker.Fragment.FragmentDashboard;
import ph.edu.hau.wallettracker.Fragment.FragmentMap;
import ph.edu.hau.wallettracker.Fragment.FragmentMapHistory;
import ph.edu.hau.wallettracker.Model.BTModel;

public class MainActivity extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener {

    private ProgressDialog progress;
    public int btId=1;
    public String macAddress="";
    public String btName = "";
    public int btSize = 0;

    BluetoothAdapter bluetoothAdapter = null;
    public boolean isBtConnected = false;
    private BluetoothSocket btSocket;
    static final UUID myUUID = UUID.fromString("00001101-0000-1000-8000-00805F9B34FB");
    public Boolean mScanning = false;

    boolean disAutoCon = false;

    Fragment fragment = null;
    SqlLiteHelper db;

    private final BroadcastReceiver mReceiver = new BroadcastReceiver() {
        @Override
        public void onReceive(Context context, Intent intent) {
            final String action = intent.getAction();
            if (BluetoothDevice.ACTION_ACL_CONNECTED.equals(action)) {
                //txtConnection.setText("Connected");
                invalidateOptionsMenu();
                isBtConnected = true;
            } else if (BluetoothDevice.ACTION_ACL_DISCONNECTED.equals(action)) {
                //txtConnection.setText("Disconnected");
                isBtConnected = false;
                invalidateOptionsMenu();
                if(!disAutoCon) {
                    new InConnectBT().execute("");
                }
            }
        }
    };

    private static IntentFilter filter() {
        final IntentFilter intentFilter = new IntentFilter();
        intentFilter.addAction(BluetoothDevice.ACTION_ACL_CONNECTED);
        intentFilter.addAction(BluetoothDevice.ACTION_ACL_DISCONNECTED);
        return intentFilter;
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().requestFeature(Window.FEATURE_PROGRESS);
        setContentView(R.layout.activity_main);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setTitle(Html.fromHtml("<small><font size=\"2\">Wellet</font></small>"));


        db = new SqlLiteHelper(this);
        db.open();

        List<BTModel> dataList = db.fetchAllData();
        btSize =dataList.size();

        if( btSize> 0){
            btId = dataList.get(0).getBtId();
            btName = dataList.get(0).getBtName();
            macAddress = dataList.get(0).getBtAddress();
            reconect();
        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        registerReceiver(mReceiver, filter());

        changeFragment(new FragmentDashboard());
    }

    public void updateDb(BTModel btModel){
        db.updateData(btModel);
    }

    public void insertDb(BTModel btModel){
        db.insertData(btModel);
    }

    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START)) {
            drawer.closeDrawer(GravityCompat.START);
        } else {
            super.onBackPressed();
            disconect();
            finish();
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.connection_state, menu);
        if (isBtConnected) {
            menu.findItem(R.id.menu_connect).setVisible(false);
            menu.findItem(R.id.menu_disconnect).setVisible(true);
            menu.findItem(R.id.menu_refresh).setActionView(null);
        } else {
            if (mScanning) {
                menu.findItem(R.id.menu_connect).setTitle("Connecting");
                menu.findItem(R.id.menu_connect).setVisible(true);
                menu.findItem(R.id.menu_disconnect).setVisible(false);
                menu.findItem(R.id.menu_refresh).setActionView(
                        R.layout.actionbar_indeterminate_progress);
            }else{
                menu.findItem(R.id.menu_connect).setTitle("Connect");
                menu.findItem(R.id.menu_connect).setVisible(true);
                menu.findItem(R.id.menu_disconnect).setVisible(false);
                menu.findItem(R.id.menu_refresh).setActionView(null);
            }
        }
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch(item.getItemId()) {
            case R.id.menu_connect:
                disAutoCon = false;
                new InConnectBT().execute("");
                return true;
            case R.id.menu_disconnect:
                disAutoCon = true;
                try{
                    btSocket.close();
                }catch (Exception e){

                }

                return true;
            case android.R.id.home:
                onBackPressed();
                return true;
        }
        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_dashboard) {
            changeFragment(new FragmentDashboard());
        } else if (id == R.id.nav_location) {
            changeFragment(new FragmentMap());
        } else if (id == R.id.nav_location_history) {
            changeFragment(new FragmentMapHistory());
        } else if (id == R.id.nav_bluetooth) {
            changeFragment(new FragmentBluetoothSetting());
        } else if (id == R.id.nav_about) {
            changeFragment(new FragmentAbout());
        }
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    public void changeFragment(Fragment fragment){
        FragmentTransaction ft = getSupportFragmentManager().beginTransaction();
        ft.replace(R.id.frameContact, fragment);
        ft.commit();
    }

    private void msg(String s)
    {
        Toast.makeText(getApplicationContext(),s,Toast.LENGTH_SHORT).show();
    }

    public void disconect(){
        try {
            btSocket.close();
        }catch (Exception e){

        }
    }

    public void reconect(){
        new InConnectBT().execute("");
    }

    public class InConnectBT extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            String response = "No MacAddress" ;
            try
            {
                if (!isBtConnected && !macAddress.equals("") && !macAddress.equals(null))
                {
                    bluetoothAdapter = BluetoothAdapter.getDefaultAdapter();//get the mobile bluetooth device
                    BluetoothDevice dispositivo = bluetoothAdapter.getRemoteDevice(macAddress);//connects to the device's address and checks if it's available
                    btSocket = dispositivo.createInsecureRfcommSocketToServiceRecord(myUUID);//create a RFCOMM (SPP) connection
                    BluetoothAdapter.getDefaultAdapter().cancelDiscovery();
                    btSocket.connect();//start connection
                    response = "Success";
                    isBtConnected = true;
                }
            }
            catch (Exception e)
            {
                response = e.toString();
                isBtConnected = false;//if the try failed, you can check the exception here
            }

            return response;
        }

        @Override
        protected void onPostExecute(String result) {
            mScanning = false;
           // progress.dismiss();
            invalidateOptionsMenu();
           // msg(result);
            if(!isBtConnected && !macAddress.equals("") && !macAddress.equals(null) && !disAutoCon){
                new InConnectBT().execute("");
            }
        }

        @Override
        protected void onPreExecute() {
            mScanning = true;
            invalidateOptionsMenu();
           // progress = ProgressDialog.show(MainActivity.this, "Connecting...", "Please wait!!!");  //show a progress dialog
        }

        @Override
        protected void onProgressUpdate(Void... values) {}
    }
}
