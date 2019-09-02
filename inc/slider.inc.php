     <div class="w3-content w3-display-container">

          <div class="w3-display-container mySlides">
            <img src="images/slider1.jpg" style="width:100%" alt="sliderimg1">
            <div class="w3-display-bottomleft w3-large w3-container w3-padding-16 w3-black">
              Social Gathering
            </div>
          </div>

          <div class="w3-display-container mySlides">
            <img src="images/slider2.jpg" style="width:100%" alt="sliderimg2">
            <div class="w3-display-bottomright w3-large w3-container w3-padding-16 w3-black">
             Accepting Everyone 
            </div>
          </div>

          <div class="w3-display-container mySlides">
            <img src="images/slider3.jpg" style="width:100%" alt="sliderimg3">
            <div class="w3-display-topleft w3-large w3-container w3-padding-16 w3-black">
              Volunteer
            </div>
          </div>
          <button class="w3-button w3-display-left w3-black" onclick="plusDivs(-1)">&#10094;</button>
          <button class="w3-button w3-display-right w3-black" onclick="plusDivs(1)">&#10095;</button>
      </div>  
      <script > 
          var slideIndex = 1;
          showDivs(slideIndex);

          function plusDivs(n) {
            showDivs(slideIndex += n);
          }

          function showDivs(n) {
            var i;
            var x = document.getElementsByClassName("mySlides");
            if (n > x.length) {slideIndex = 1}    
            if (n < 1) {slideIndex = x.length}
            for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";  
            }
            x[slideIndex-1].style.display = "block";  
          }
      </script> 
        <div class="icon-bar">
          <a href="#" class="facebook"><i class="fa fa-facebook"></i></a> 
          <a href="#" class="twitter"><i class="fa fa-twitter"></i></a> 
          <a href="#" class="google"><i class="fa fa-google"></i></a> 
          <a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
          <a href="#" class="youtube"><i class="fa fa-youtube"></i></a> 
        </div>      