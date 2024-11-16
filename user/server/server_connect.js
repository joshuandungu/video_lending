const ws = new WebSocket("ws://localhost:8080/notifications");

ws.onmessage = (event) => {
    const notification = JSON.parse(event.data);
    alert(`Notification: ${notification.message}`);
};
