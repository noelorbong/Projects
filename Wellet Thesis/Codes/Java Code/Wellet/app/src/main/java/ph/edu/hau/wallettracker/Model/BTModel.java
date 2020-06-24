package ph.edu.hau.wallettracker.Model;

public class BTModel {

    public String getBtName() {
        return BtName;
    }

    public void setBtName(String btName) {
        BtName = btName;
    }

    public String getBtAddress() {
        return BtAddress;
    }

    public void setBtAddress(String btAddress) {
        BtAddress = btAddress;
    }

    public int getBtId() {
        return BtId;
    }

    public void setBtId(int btId) {
        BtId = btId;
    }

    private int BtId;
    private String BtName = "";
    private String BtAddress = "";
}
