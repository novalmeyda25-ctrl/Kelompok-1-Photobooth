<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamera WhimshyBooth</title>
</head>

<body>

    <h1>WhimshyBooth Camera</h1>

    <button id="startCamera">
        Aktifkan Kamera
    </button>

    <br><br>

    <video
        id="camera"
        width="640"
        height="480"
        autoplay
        playsinline>
    </video>

    <script>
        const video = document.getElementById('camera');
        const button = document.getElementById('startCamera');

        button.addEventListener('click', async function () {

            try {
                const stream =
                    await navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    });

                video.srcObject = stream;

            } catch (error) {
                console.error(error);
                alert('Kamera tidak bisa digunakan.');
            }

        });
    </script>

</body>
</html>