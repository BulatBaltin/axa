<div class='box m-20' style="margin-top:10rem;">
<h1>Timeline vertical</h1>
  <h2>
    <!-- <a href="" class="typewrite" data-period="2000" data-type='[ "Hi, I am a Software Engineer.", "I am Creative.", "I Love PHP and Design.", "I Love to Develop." ]'> -->
      <span class="wrap"></span>
    <!-- </a> -->
  </h2>
  <div class="timeline">
  <div class="container left">
    <div class="content-left">
      <h2>2017</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vitae quisquam architecto iusto qui repellendus placeat itaque nesciunt impedit aliquid, velit sed cupiditate, quas voluptate voluptatibus corrupti fugiat sequi ut fuga.em ipsum..</p>
    </div>
  </div>
  <div class="container right">
    <div class="content-right">
      <h2>2016</h2>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit maxime magni soluta distinctio iure assumenda magnam. Rerum odio asperiores porro minus magni! Culpa, atque repudiandae quibusdam facilis omnis nisi reprehenderit.em ipsum..</p>
    </div>
  </div>
  <div class="container left">
    <div class="content-left">
      <h2>2015</h2>
      <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Velit maxime magni soluta distinctio iure assumenda magnam. Rerum odio asperiores porro minus magni! Culpa, atque repudiandae quibusdam facilis omnis nisi reprehenderit.em ipsum..</p>
    </div>
  </div>
</div>
</div>

<style>
/* https://www.w3schools.com/howto/howto_css_timeline.asp */

* {
  box-sizing: border-box;
}

/* Set a background color */
body {
  background-color: #474e5d;
  font-family: Helvetica, sans-serif;
}

/* The actual timeline (the vertical ruler) */
.timeline {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
}

/* The actual timeline (the vertical ruler) */
.timeline::after {
  content: '';
  position: absolute;
  width: 6px;
  background-color: white;
  top: 0;
  bottom: 0;
  left: 50%;
  margin-left: -3px;
}

/* Container around content */
.container {
  padding: 10px 40px;
  position: relative;
  background-color: inherit;
  width: 50%;
}

/* The circles on the timeline */
.container::after {
  content: '';
  position: absolute;
  width: 25px;
  height: 25px;
  right: -17px;
  background-color: white;
  border: 4px solid #FF9F55;
  top: 15px;
  border-radius: 50%;
  z-index: 1;
}

/* Place the container to the left */
.left {
  left: 0;
}

/* Place the container to the right */
.right {
  left: 50%;
}

/* Add arrows to the left container (pointing right) */
.left::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  right: 30px;
  border: medium solid white;
  border-width: 10px 0 10px 10px;
  /* border-color: transparent transparent transparent white; */
  border-color: transparent transparent transparent cyan;

  animation: animateX50 1000ms forwards 0ms;  

}

/* Add arrows to the right container (pointing left) */
.right::before {
  content: " ";
  height: 0;
  position: absolute;
  top: 22px;
  width: 0;
  z-index: 1;
  left: 30px;
  border: medium solid white;
  border-width: 10px 10px 10px 0;
  border-color: transparent cyan transparent transparent;

  animation: animateX50-right 1000ms forwards 0ms;  

}

/* Fix the circle for containers on the right side */
.right::after {
  left: -16px;
}

/* The actual content */
.content {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-radius: 6px;
}
.content-left {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-right: 10px solid cyan;
  /* border-right-color: cyan; */
  border-radius: 6px;
  opacity: 0.3;
  /* transition: all 0.8s linear; */
  animation: animateX50 1000ms forwards 0ms;  
  /* transform: translatex(50px); */
}
.content-right {
  padding: 20px 30px;
  background-color: white;
  position: relative;
  border-left: 10px solid cyan;
  /* border-right-color: cyan; */
  border-radius: 6px;
  opacity: 0.3;
  /* transition: all 0.8s linear; */
  animation: animateX50-right 1000ms forwards 0ms;  
  /* transform: translatex(50px); */
}

/* .content-left::before {
  content: 'translatex(-150px)'; */
  /* transform: translatex(50px); */
/* } */
/* .content-left::after {
  content: '';
  transform: translatex(50px);
} */
@keyframes animateX50 {
  0% {
    transform: translateX(-100px);
  }

  70% {
     opacity: 0.5;
  }

  100% {
    transform: translateX(0);
    opacity: 1;
  }
}
@keyframes animateX50-right {
  0% {
    transform: translateX(100px);
  }

  70% {
     opacity: 0.5;
  }

  100% {
    transform: translateX(0);
    opacity: 1;
  }
}


/* Media queries - Responsive timeline on screens less than 600px wide */
@media screen and (max-width: 600px) {
/* Place the timelime to the left */
  .timeline::after {
    left: 31px;
  }

/* Full-width containers */
  .container {
    width: 100%;
    padding-left: 70px;
    padding-right: 25px;
  }

/* Make sure that all arrows are pointing leftwards */
  .container::before {
    left: 60px;
    border: medium solid white;
    border-width: 10px 10px 10px 0;
    border-color: transparent white transparent transparent;
  }

/* Make sure all circles are at the same spot */
  .left::after, .right::after {
    left: 15px;
  }

/* Make all right containers behave like the left ones */
  .right {
    left: 0%;
  }
}

</style>
