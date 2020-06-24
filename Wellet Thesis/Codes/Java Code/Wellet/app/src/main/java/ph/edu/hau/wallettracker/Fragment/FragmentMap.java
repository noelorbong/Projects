package ph.edu.hau.wallettracker.Fragment;

import android.app.Activity;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import ph.edu.hau.wallettracker.MainActivity;
import ph.edu.hau.wallettracker.R;


public class FragmentMap extends Fragment {

    WebView myWebView;
    public MainActivity mainActivity;
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        //returning our layout file
        //change R.layout.yourlayoutfilename for each of your fragments
        View view =  inflater.inflate(R.layout.frame_map,
                container, false);

        mainActivity = (MainActivity) getActivity();
        myWebView = (WebView) view.findViewById(R.id.webview);

//        final Activity activity = this.mainActivity;

        WebSettings webSettings = myWebView.getSettings();
        webSettings.setJavaScriptEnabled(true);


        myWebView.setWebViewClient(new WebViewClient() {
            public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
            //    Toast.makeText(activity, "Oh no! " + description, Toast.LENGTH_SHORT).show();
                myWebView.loadUrl("file:///android_asset/error.html");
            }
        });

        myWebView.loadUrl("http://wallettracker.1apps.com/index.html");


        return  view;
        //return inflater.inflate(R.layout.activity_insert_data, container, false);
    }
}
