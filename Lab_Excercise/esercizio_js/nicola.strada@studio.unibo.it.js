//Strada Nicola
images = document.querySelectorAll("img");
setStartSlide();
setListenerOnImage();

function setStartSlide(){
    images[0].setAttribute("class", "current");
    for (var i = 2; i < images.length; i++){
        images[i].style.visibility = 'hidden';
    }
}

function changeCurrentImage(image, position){
    console.log(position);
    if(!(images[position].classList.contains("current"))){
        resetImage();
        if(position == 0){
            images[position].setAttribute("class", "current");
            images[position].style.visibility = 'visible';
            images[position + 1].style.visibility = 'visible';
        }
        else if(position == images.length - 1){
            images[position].setAttribute("class", "current");
            images[position].style.visibility = 'visible';
            images[(position - 1)].style.visibility = 'visible';
        }
        else{
            images[position].setAttribute("class", "current");
            images[position].style.visibility = 'visible';
            images[position + 1].style.visibility = 'visible';
            images[position - 1].style.visibility = 'visible';
        }
    }
}

function resetImage(){
    images.forEach(image => {
        image.setAttribute("class", "");
        image.style.visibility = 'hidden';
    });
}

function setListenerOnImage(){
    images.forEach(image => {
        image.addEventListener("click", function event(){
            changeCurrentImage(image, Array.from(images).indexOf(image));
        });
    });
}
