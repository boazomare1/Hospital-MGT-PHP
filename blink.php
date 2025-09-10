<!DOCTYPE html>
<html>
<head>
    <style>
        .blink {
            animation: blink-animation 1s steps(2, start) infinite;
            -webkit-animation: blink-animation 1s steps(2, start) infinite;
            font-weight: bold;
            font-size: 24px;
            color: green;
        }

        @keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }

        @-webkit-keyframes blink-animation {
            to {
                visibility: hidden;
            }
        }
    </style>
</head>
<body>
    <p class="blink">Blinking text!</p>
</body>
</html>
