package ph.edu.hau.wallettracker.Database;

import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.support.v7.app.AppCompatActivity;

import java.util.ArrayList;
import java.util.List;

import ph.edu.hau.wallettracker.Model.BTModel;

public class SqlLiteHelper  extends AppCompatActivity {

    public static int dbversion = 2;
    public static String dbname = "WalletApp";
    public static String dbTable = "WalletInfo";

    public static String cul2_btName = "BTName";
    public static String cul3_btAddress = "BTAddress";

    private static class DatabaseHelper extends SQLiteOpenHelper {
        public DatabaseHelper(Context context) {
            super(context, dbname, null, dbversion);
        }

        @Override
        public void onCreate(SQLiteDatabase db) {
            db.execSQL("CREATE TABLE IF NOT EXISTS " + dbTable + " (_id INTEGER PRIMARY KEY autoincrement,"
                    + cul2_btName
                    + ", " + cul3_btAddress
                    + " )");
        }

        @Override
        public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
            db.execSQL("DROP TABLE IF EXISTS " + dbTable);
            onCreate(db);
        }
    }

    //establsh connection with SQLiteDataBase
    private final Context c;
    private DatabaseHelper dbHelper;
    private SQLiteDatabase sqlDb;

    public SqlLiteHelper(Context context) {
        this.c = context;
    }

    public SqlLiteHelper open() throws SQLException {
        dbHelper = new DatabaseHelper(c);
        sqlDb = dbHelper.getWritableDatabase();
        return this;
    }

    public  void insertData(BTModel btModel){
        _insertData(btModel);
    }
    public  List<BTModel> fetchAllData(){
        return _fetchAllData();
    }
    public  void updateData(BTModel btModel){
        _updateData(btModel);
    }
    private void _insertData(BTModel btModel) {
        sqlDb.execSQL("INSERT INTO " + dbTable + " ("
                + cul2_btName
                + ", " + cul3_btAddress
                + ") VALUES("
                + "'" + btModel.getBtName() + "'"
                + ",'" + btModel.getBtAddress() + "'"
                + ")");
    }
    private List<BTModel> _fetchAllData() {
        List<BTModel> btList = new ArrayList<>();
        BTModel btModel;

        String query = "SELECT _id, "
                + cul2_btName
                + ", " + cul3_btAddress
                + " FROM " + dbTable;
        Cursor c = sqlDb.rawQuery(query, null);
        int i = 0;
        if (c != null) {
            if (c.moveToFirst()) {
                do {
                    btModel = new BTModel();

                    btModel.setBtId(c.getInt(c.getColumnIndex("_id")));
                    btModel.setBtName(c.getString(c.getColumnIndex(cul2_btName)));
                    btModel.setBtAddress(c.getString(c.getColumnIndex(cul3_btAddress)));
                    btList.add(btModel);
                    i++;
                } while (c.moveToNext());
            }
        }
        c.close();

        return btList;
    }
    private void _updateData(BTModel btModel) {
        sqlDb.execSQL("UPDATE "+dbTable+" SET "
                +cul2_btName+"='"+btModel.getBtName()+"'"
                + ", "+cul3_btAddress+"='"+ btModel.getBtAddress()+"' "
                +"  WHERE _id=" + btModel.getBtId());
    }
}
