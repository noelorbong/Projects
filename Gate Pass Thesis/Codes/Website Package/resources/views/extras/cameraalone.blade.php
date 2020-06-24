<html>
<head>
    <meta name="viewport" content="width=device-width, minimum-scale=0.1">
</head>
<body style="margin: 0px; background: #0e0e0e;">
    <img id="camera" style="height:100%; width: 100%; object-fit: contain;display: block;margin-left: auto; margin-right: auto;" src="http://gatepass:8081/" >
</body>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
    var windowLocation;
    var updatedAt;
    (function() {
        windowLocation = window.location.protocol + "//" + window.location.hostname + ":8081/";
        document.getElementById('camera').src = windowLocation; 
        setInterval(function(){ getPlate() }, 2000);

    })();

function getPlate(){
        $.ajax({url: "/getplate", success: function(responseData){
            // console.log(responseData.plate_detected.updated_at);
            if(updatedAt != responseData.plate_detected.updated_at){
                updatedAt = responseData.plate_detected.updated_at;
                testConnection();
            }
             
        }});
}

  function testConnection(){
        document.getElementById('camera').src = windowLocation; 
        console.log("Update Camera");
    }
</script>
</html>