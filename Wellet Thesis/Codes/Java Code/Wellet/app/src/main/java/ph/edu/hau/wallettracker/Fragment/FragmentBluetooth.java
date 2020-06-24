package ph.edu.hau.wallettracker.Fragment;

import android.bluetooth.BluetoothAdapter;
import android.bluetooth.BluetoothDevice;
import android.bluetooth.BluetoothSocket;
import android.content.Intent;
import android.os.Bundle;
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

import ph.edu.hau.wallettracker.DeviceList;
import ph.edu.hau.wallettracker.MainActivity;
import ph.edu.hau.wallettracker.Model.BTModel;
import ph.edu.hau.wallettracker.R;


public class FragmentBluetooth extends Fragment {

    //widgets
    Button btnPaired;
    ListView devicelist;
    private BluetoothSocket btSocket = null;
    //Bluetooth
    private BluetoothAdapter myBluetooth = null;
    private Set<BluetoothDevice> pairedDevices;
    public static String EXTRA_ADDRESS = "device_address";
    public MainActivity mainActivity;
    public MainActivity.InConnectBT inConnectBT;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        //returning our layout file
        //change R.layout.yourlayoutfilename for each of your fragments
        View view =  inflater.inflate(R.layout.frame_bluetooth,
                container, false);

        mainActivity = (MainActivity) getActivity();
        //Calling widgets
        btnPaired = (Button)view.findViewById(R.id.button);
        devicelist = (ListView)view.findViewById(R.id.listView);

        //if the device has bluetooth
        myBluetooth = BluetoothAdapter.getDefaultAdapter();

        if(myBluetooth == null)
        {
            //Show a mensag. that the device has no bluetooth adapter
            Toast.makeText(getActivity(), "Bluetooth Device Not Available", Toast.LENGTH_LONG).show();
        }
        else if(!myBluetooth.isEnabled())
        {
            //Ask to the user turn the bluetooth on
            Intent turnBTon = new Intent(BluetoothAdapter.ACTION_REQUEST_ENABLE);
            startActivityForResult(turnBTon,1);
        }

        pairedDevicesList(); // added 10/08/2017
        btnPaired.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v)
            {
                pairedDevicesList();
            }
        });
        try {
            btSocket.close();
        }catch (Exception ex){}

        return  view;
        //return inflater.inflate(R.layout.activity_insert_data, container, false);
    }

    private void pairedDevicesList()
    {
        pairedDevices = myBluetooth.getBondedDevices();
        ArrayList list = new ArrayList();

        if (pairedDevices.size()>0)
        {
            for(BluetoothDevice bt : pairedDevices)
            {
                list.add(bt.getName() + "\n" + bt.getAddress()); //Get the device's name and the address
            }
        }
        else
        {
            Toast.makeText(getActivity(), "No Paired Bluetooth Devices Found.", Toast.LENGTH_LONG).show();
        }

        final ArrayAdapter adapter = new ArrayAdapter(getActivity(),android.R.layout.simple_list_item_1, list);
        devicelist.setAdapter(adapter);
        devicelist.setOnItemClickListener(myListClickListener); //Method called when the device from the list is clicked
    }

    private AdapterView.OnItemClickListener myListClickListener = new AdapterView.OnItemClickListener()
    {
        public void onItemClick (AdapterView<?> av, View v, int arg2, long arg3)
        {
            // Get the device MAC address, the last 17 chars in the View
            BTModel btModel = new BTModel();
            String info = ((TextView) v).getText().toString();
            String address = info.substring(info.length() - 17);
            mainActivity.macAddress = address;
            mainActivity.btName = info.substring(0,info.length() - 17);

            btModel.setBtId(mainActivity.btId);
            btModel.setBtName(mainActivity.btName.trim());
            btModel.setBtAddress(mainActivity.macAddress.trim());

            if(mainActivity.btSize > 0){
                mainActivity.updateDb(btModel);
            }else{
                mainActivity.insertDb(btModel);
            }

            mainActivity.disconect();
            mainActivity.reconect();

            final FragmentTransaction ft = getFragmentManager().beginTransaction();
            ft.replace(R.id.frameContact, new FragmentBluetoothSetting(), "NewFragmentTag");
            ft.commit();
//            // Make an intent to start next activity.
//            Intent i = new Intent(DeviceList.this, MainActivity.class);
//            //Change the activity.
//            i.putExtra(EXTRA_ADDRESS, address); //this will be received at ledControl (class) Activity
//            startActivity(i);
        }
    };
}
