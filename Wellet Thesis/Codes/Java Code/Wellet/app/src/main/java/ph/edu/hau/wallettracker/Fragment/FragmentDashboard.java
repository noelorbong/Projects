package ph.edu.hau.wallettracker.Fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.webkit.WebView;

import ph.edu.hau.wallettracker.R;


public class FragmentDashboard extends Fragment {
    WebView wv;
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        //returning our layout file
        //change R.layout.yourlayoutfilename for each of your fragments
        View view =  inflater.inflate(R.layout.frame_dashboard,
                container, false);

        wv = (WebView) view.findViewById(R.id.webview);
        wv.loadUrl("file:///android_asset/index.html");

        return  view;
        //return inflater.inflate(R.layout.activity_insert_data, container, false);
    }
}
