let audio = new Audio('sentimental.mp3');
let isPlaying = false;

document.getElementById('botonReproducir').addEventListener('click', function() {
    if (isPlaying) {
        audio.pause();
        isPlaying = false;
    } else {
        audio.play()
        isPlaying = true;
    }
});