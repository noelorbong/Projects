package ph.edu.hau.wallettracker.Fragment;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentTransaction;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Set;

import ph.edu.hau.wallettracker.MainActivity;
import ph.edu.hau.wallettracker.R;


public class FragmentBluetoothSetting extends Fragment {

    public MainActivity mainActivity;
    private TextView txtBlueName, txtBlueAddress, txtBlueConnection;
    String connection_state = "";
    Button btnNewDevice;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        //returning our layout file
        //change R.layout.yourlayoutfilename for each of your fragments
        View view =  inflater.inflate(R.layout.frame_bluetooth_setting,
                container, false);
        mainActivity = (MainActivity) getActivity();
        txtBlueName = (TextView)view.findViewById(R.id.txtBlueName);
        txtBlueAddress = (TextView)view.findViewById(R.id.txtBlueAddress);
        txtBlueConnection = (TextView)view.findViewById(R.id.txtBlueConnection);
        btnNewDevice = (Button)view.findViewById(R.id.btnNewDevice);

        txtBlueAddress.setText(mainActivity.macAddress.trim());
        txtBlueName.setText(mainActivity.btName.trim());

        btnNewDevice.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                final FragmentTransaction ft = getFragmentManager().beginTransaction();
                ft.replace(R.id.frameContact, new FragmentBluetooth(), "NewFragmentTag");
                ft.commit();
            }
        });

        autoScroll();
        return  view;
    }

    public void autoScroll() {
        final Handler handler = new Handler();
        final Runnable runnable = new Runnable() {
            @Override
            public void run() {

                if(mainActivity.mScanning) {
                    txtBlueConnection.setText("Connecting..");
                }else{
                    connection_state = (mainActivity.isBtConnected == true) ? "Connected" : "Disconnected";
                    txtBlueConnection.setText(connection_state.trim());
                }

                handler.postDelayed(this, 0);
            }
        };
        handler.postDelayed(runnable, 0);
    }
}
