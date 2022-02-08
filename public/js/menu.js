titles = document.querySelectorAll(".filter-title");
filts = document.querySelectorAll(".fil-params");
filterImg = document.querySelectorAll(".filter-img");

for(let i = 0;i < titles.length;i++){
    titles[i].onclick = function(){
        for(let n = 0; n < titles.length;n++){
            if ((n!=i) && (filts[n].classList.contains("fil-active"))) {
                filts[n].classList.remove("fil-active");
            }
            if(filterImg[n].src="/images/home/arrow-up.png"){
                filterImg[n].src="/images/home/arrow-down.png";
            }
        }
        filts[i].classList.toggle("fil-active");
        if(filts[i].classList.contains("fil-active")){
            filterImg[i].src="/images/home/arrow-up.png";
        }else{
            filterImg[i].src="/images/home/arrow-down.png";
        }

    };

}