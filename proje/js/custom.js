randomChange = document.getElementById('randomChange')
images = ['gifs/gif1.gif','gifs/gif2.gif','gifs/gif3.gif','gifs/gif4.gif','gifs/gif5.gif','gifs/gif6.gif']
imgCount = images.length
number = Math.floor(Math.random()* imgCount);
window.onload = function(){
    randomChange.style.backgroundImage = 'url('+images[number]+')'
    randomChange.style.backgroundSize = "Cover";
    randomChange.style.backgroundImage.style.maxWidth = '100%';
    randomChange.style.backgroundImage.style.height = 'auto';
}
// Get the modal
var modal1 = document.getElementById('id01');
var modal2 = document.getElementById('id02');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
    else if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

function openModal() {
    document.getElementById("myModalBackdrop").style.display = "block";
    document.getElementById("myModal").style.display = "block";
}