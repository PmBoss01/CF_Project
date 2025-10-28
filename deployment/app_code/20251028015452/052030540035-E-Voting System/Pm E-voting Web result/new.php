<!DOCTYPE html>
<html>
<head>
    <title>Notification Sound Example</title>
</head>
<body>
    <button id="playSound">Play Notification Sound</button>
    <!---<button id="stopSound">Stop Notification Sound</button>-->
    <audio id="notificationSound" src="audio/notification.mp3" loop="true"></audio>

    <script>
        // Get references to the buttons and audio element
        const playButton = document.getElementById('playSound');
        //const stopButton = document.getElementById('stopSound');
        const notificationSound = document.getElementById('notificationSound');

        // Add click event listener to the "Play Notification Sound" button
        playButton.addEventListener('click', function() {
            notificationSound.play();
        });

        // Add click event listener to the "Stop Notification Sound" button
        stopButton.addEventListener('click', function() {
            notificationSound.pause();
            notificationSound.currentTime = 0;
        });

        // Automatically play the sound when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            notificationSound.play();
        });
    </script>
</body>
</html>
