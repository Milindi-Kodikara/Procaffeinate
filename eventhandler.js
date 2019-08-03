var img;

function visaCard() {
var creditCard = document.getElementById("card").value;
var cardNumber = creditCard;
var pattern = /^(4){1}([ ]*\d){13,15}\s*$/;

    if(pattern.test(cardNumber)){
        if (document.getElementById("parapara").children.length == 0){
            show_image('./media/visa.png',30, 15,"Visa logo")
       }
    }
    else {
        document.getElementById("parapara").removeChild(img);
    }
}

function show_image(src, width, height, alt){
        img = document.createElement("img");
        img.src = src;
        img.width = width;
        img.height = height;
        img.alt = alt;
        document.getElementById("parapara").appendChild(img);
}

