<div class='box m-20' style="margin-top:10rem;">
<h1>Animated text</h1>
  <h2>
    <!-- <a href="" class="typewrite" data-period="2000" data-type='[ "Hi, I am a Software Engineer.", "I am Creative.", "I Love PHP and Design.", "I Love to Develop." ]'> -->
      <span class="wrap"></span>
    <!-- </a> -->
  </h2>
  <div id='hook-0'> 
  </div>
  <div id='hook-1'> 
  </div>
  <div id='hook-2'> 
  </div>

  <div class='flex'>
  <a class="grow_box" href="<? path('404') ?>">Create Database</a>
  <button id='create-db' class="grow_box">Create Database (2)</button>
  <button class="grow_spin">GROW SPIN</button>
  </div>
  <div class='row'>
    <div class="box-container">
            <!-- <div class="circle service-item"> -->
          <div class="img-container">
            <div class="circle">
              <i class="fa fa-laptop"></i>
            </div>
          </div>
          <div class="service-text">
            <h3>Web Design</h3>
            <p>Lorem ipsum dolor sit amet elit. Phase nec preti mi. Curabi facilis ornare velit non</p>
          </div>
    </div>
    <div class="box-container">
            <!-- <div class="circle service-item"> -->
          <div class="img-container">
            <div class="circle">
              <i class="fas fa-code"></i>
            </div>
          </div>
          <div class="service-text">
            <h3>Web Development</h3>
            <p>Lorem ipsum dolor sit amet elit. Phase nec preti mi. Curabi facilis ornare velit non</p>
            <p>Lorem ipsum dolor sit amet elit. Phase nec preti mi. Curabi facilis ornare velit non</p>
          </div>
    </div>
    <div class="box-container">
            <!-- <div class="circle service-item"> -->
          <div class="img-container">
            <div class="circle">
              <i class="fab fa-php"></i>
            </div>
          </div>
          <div class="service-text">
            <h3>PHP Frameworks</h3>
            <p>Lorem ipsum dolor sit amet elit. Phase nec preti mi. Curabi facilis ornare velit non</p>
            <p>Lorem ipsum dolor sit amet elit. Phase nec preti mi. Curabi facilis ornare velit non</p>
          </div>
    </div>
  </div>
</div>

<script>
$(document).ready(
    function() {
        $('#create-db').click( function() {
            // alert('HERE-2');
            $.post( "<? path('db-create-ajax') ?>", 
            {'table_name': 'Ajax test', 'data': 567}, 
            function(data1, success) { 
                $('#hook-0').html(data1);
                // $('#hook-0').html(data1);
            });
            }
        );
    }
);
</script>

<style>
/* https://www.sliderrevolution.com/resources/css-button-hover-effects/   */
button {
  font-size: 1.25em;
  background: #3498db;
  color: #fff;
  border: 0.25rem solid #3498db;
  border-radius: 5px;
  padding: 0.85em 0.75em;
  margin: 1rem;
  position: relative;
  z-index: 1;
  overflow: hidden;
}
button:hover {
  /* color: #3498db; */
  color: cyan;
}
button::after {
  content: "";
  /* background: #ecf0f1; */
  background: red;
  border: 0.25rem solid red;
  border-radius: 5px;
  /* color: black; */
  position: absolute;
  z-index: -1;
  padding: 0.85em 0.75em;
  display: block;
}
button[class^="grow"]::after {
  transition: all 0.3s ease;
}
button[class^="grow"]:hover::after {
  transition: all 0.3s ease-out;
}
button.grow_box::after {
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  transform: scale(0, 0);
}
button.grow_box:hover::after {
  transform: scale(1, 1);
}
button.grow_spin::after {
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  transform: scale(0, 0) rotate(-180deg);
}
button.grow_spin:hover::after {
  transform: scale(1, 1) rotate(0deg);
}

/* https://stackoverflow.com/questions/17212094/fill-background-color-left-to-right-css   */
.service-text {
  padding: 2rem;
  align-self: stretch;
  transition: all 0.5s ease;
  background: linear-gradient(to right, red 50%, blue 50%);
  background-size: 200% 100%;
  background-position:right bottom;  
}  
.box-container {
  margin: 1rem;
  display: flex;
  align-items: flex-start;
  max-width: 600px;
  height: 200px;
  overflow: hidden;
  background-color: red;
  border-radius: 5px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

}  
.img-container {
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  width: 300px;
  height: 200px;
  background-color: blue;
}
.circle {
  font-size: 3rem;
  display: flex;
  justify-content: center;
  align-items: center;
  /* flex-shrink: 0; */
  width: 200px;
  height: 200px;
  /* margin-left: 30px;
  margin-right: 30px; */
  border-radius: 50%;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  transition-property: transform;
}

.box-container:hover .circle {
  transform: scale(1.2);
}
.box-container:hover .service-text {
  background-position:left bottom;  
}

.circle:nth-child(1) {
  background-color: orange;

  transition-duration: 500ms;
}

.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
}
.row {
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.service-icon {
    position: relative;
    width: 150px;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #EF233C;
    background: #fff; 
}

  body {
  background-color:#345678;
  /* text-align: center;
  color:#fff;
  padding-top:10em; */
}

* { 
  color:#fff; text-decoration: none;
} 
.box {
  height: 100vh;
  /* overflow: scroll; */
}
h2 a span {
  font-size: 2rem;
  font-weight: bold;
  color: red;
}
</style>

<script>

var TxtType = function(el, toRotate, period) {
        this.toRotate = toRotate;
        this.el = el;
        this.loopNum = 0;
        this.period = parseInt(period, 10) || 2000;
        this.txt = '';
        this.tick();
        this.isDeleting = false;
    };

    TxtType.prototype.tick = function() {
        var i = this.loopNum % this.toRotate.length;
        var fullTxt = this.toRotate[i];

        if (this.isDeleting) {
        this.txt = fullTxt.substring(0, this.txt.length - 1);
        } else {
        this.txt = fullTxt.substring(0, this.txt.length + 1);
        }

        this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

        var that = this;
        var delta = 200 - Math.random() * 100;

        if (this.isDeleting) { delta /= 2; }

        if (!this.isDeleting && this.txt === fullTxt) {
        delta = this.period;
        this.isDeleting = true;
        } else if (this.isDeleting && this.txt === '') {
        this.isDeleting = false;
        this.loopNum++;
        delta = 500;
        }

        setTimeout(function() {
        that.tick();
        }, delta);
    };

    window.onload = function() {
        var elements = document.getElementsByClassName('typewrite');
        for (var i=0; i<elements.length; i++) {
            var toRotate = elements[i].getAttribute('data-type');
            var period = elements[i].getAttribute('data-period');
            if (toRotate) {
              new TxtType(elements[i], JSON.parse(toRotate), period);
            }
        }
        // INJECT CSS to create a caret
        var css = document.createElement("style");
        css.type = "text/css";
        css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
        document.body.appendChild(css);
    };

</script>

