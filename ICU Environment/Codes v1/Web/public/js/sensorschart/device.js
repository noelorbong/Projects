$(function() { 
    deviceStateRequest();
    setInterval(function(){ deviceStateRequest() }, 2000);
});

function deviceStateRequest(){
    var fanState = 0;
    var alarmState = 0;
  $.ajax({url: "/devicestate/", success: function(responseData){

      $.each(responseData.fan, function(i, item) {
        fanState = item.value ;
      });
      
      if(fanState== 1){
            document.getElementById("electricFan").src = "/img/icons/icon_fan_on.png";
          }else{
            document.getElementById("electricFan").src = "/img/icons/icon_fan_off.png";
          }

      $.each(responseData.alarm, function(i, item) {
        alarmState = item.value ;
      });

      if(alarmState == 1){
            document.getElementById("alarmBuzzer").src = "/img/icons/icon_alarm_on.png";
          }else{
            document.getElementById("alarmBuzzer").src = "/img/icons/icon_alarm_off.png";
          }
                            
  }});
}