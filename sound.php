<!DOCTYPE html>
<html>
<head>
  <title>Button Sound Example</title>
</head>
<body>
  <button id="myButton">Click Me!</button>

  <script>
    const button = document.getElementById('myButton');

    // Function to play the sound
    function playSound() {
      const audio = new Audio('C:\Users\User\Downloads\aria.mp3'); // Replace 'path/to/your/soundfile.mp3' with the actual path to your sound file
      audio.play();
    }

    // Attach the playSound function to the button's click event
    button.addEventListener('click', playSound);
  </script>
</body>
</html>
