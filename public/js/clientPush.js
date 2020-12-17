const publicVapidKey = 'BAs0IRY4WemWjcsn21eoAJFOdSonw7QgtyLH8A2uUS9lClaLJ8VHorgWwMvDKg16-dr8SQPVLsruqFRqvkO2nfI';
var subscriberData = {};

$.ajax({
    url: "https://api.ipify.org/?format=json",
    type: "GET",
    async :false,
    success: function(ip) {
        if(ip){
            subscriberData.ipAddress= ip;
            //Saving Ip and Ip location To database API
            // fetch('http://192.168.1.148:3000/route/webPushNotification/ipLocation',{
            fetch('https://login.kesari.in/route/webPushNotification/ipLocation',{
                method:'POST',
                body:JSON.stringify(ip),
                headers:{
                    'content-type':'application/json'
                }
            });
        }else{
            subscriberData.ipAddress= {ip : ""};
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        subscriberData.ipAddress= {ip : ""};
    }
});

//get Location
// if ('geolocation' in navigator) {
//     navigator.geolocation.getCurrentPosition(showPosition);
//     function showPosition(position) {
//         var crd = position.coords;
//         subscriberData.location= crd.latitude+","+crd.longitude;
//     }
// }else{
//     console.log("in Else as no Geolocation")
// }

// check for service worker
if('serviceWorker' in navigator){
    send().catch(function(err){
        console.log("serviceWorker-err-> ",err);
    })
}else{
    console.log("in else-> no service worker")
}

async function send(){
    //Register service worker
    var register = await navigator.serviceWorker.register('/pushNotification/service-worker.js',{
        scope: '/pushNotification/'
    });
    
    //Register push
    var subscription = await register.pushManager.subscribe({
        userVisibleOnly : true,
        applicationServerKey : urlBase64ToUint8Array(publicVapidKey)
    });
    subscriberData.subscription= subscription;

    // if(!subscriberData.location){
    //     subscriberData.location= "";
    // }

    //Saving subscriber To database API
    // await fetch('http://192.168.1.148:3000/route/webPushNotification/subscribe',{
    await fetch('https://login.kesari.in/route/webPushNotification/subscribe',{
        method:'POST',
        body:JSON.stringify(subscriberData),
        headers:{
            'content-type':'application/json'
        }
    });
}

function urlBase64ToUint8Array(base64String) {
    const padding = '='.repeat((4 - base64String.length % 4) % 4);
    const base64 = (base64String + padding)
      .replace(/-/g, '+')
      .replace(/_/g, '/');
  
    const rawData = window.atob(base64);
    const outputArray = new Uint8Array(rawData.length);
  
    for (let i = 0; i < rawData.length; ++i) {
      outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}