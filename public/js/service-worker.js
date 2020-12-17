self.addEventListener('push',function(event){
    var data =event.data.json();
    event.waitUntil(
        self.registration.showNotification(
            data.title,
            data.option
        )
    );
    return;
});

self.addEventListener('notificationclick', function(event) {
    if (clients.openWindow) {
        return clients.openWindow(event.notification.data);
    }
});