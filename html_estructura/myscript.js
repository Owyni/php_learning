const audio = document.getElementById('myAudio');
const botonReproducir = document.getElementById('botonReproducir');
const botonPausa = document.getElementById('botonPausa');

botonReproducir.addEventListener('click', function () {
    audio.play();
    botonReproducir.classList.add('hide');
    botonPausa.classList.remove('hide');
});

botonPausa.addEventListener('click', function () {
    audio.pause();
    botonPausa.classList.add('hide');
    botonReproducir.classList.remove('hide');
});

audio.addEventListener('ended', function () {
    botonPausa.classList.add('hide');
    botonReproducir.classList.remove('hide');
});