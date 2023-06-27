<div class="container-y">
  <div class="boxy">top left</div>
  <div class="boxy">top center</div>
  <div class="boxy">top right</div>
  <div class="boxy">center left</div>
  <div class="boxy">center center</div>
  <div class="boxy">center right</div>
  <div class="boxy">bottom left</div>
  <div class="boxy">bottom center</div>
  <div class="boxy">bottom right</div>
</div>

<div class="parent">
  <div class="box-center"></div>
</div>

<div class="container">
  <div class="box1"></div>
  <div class="box1"></div>
  <div class="box1"></div>
</div>
<div class="container">
  <div class="box2"></div>
  <div class="box2"></div>
  <div class="box2"></div>
</div>
<div class="container">
  <div class="box3"></div>
  <div class="box3"></div>
  <div class="box3"></div>
</div>
<div class="container">
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
</div>

<style>
:root {
  --dot-size: 16px;
}

* {
  box-sizing: border-box;
}

body {
  background-color: #fff;
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.container-y {
  min-height: 70vh;
  width: 420px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-content: center;
  margin-left: auto;
  margin-right: auto;
}

.boxy {
  position: relative;
  width: 120px;
  height: 120px;
  margin: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid tomato;
  border-radius: 4px;
  font-size: 17px;
}

.boxy::before {
  position: absolute;
  display: inline-block;
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 4px;
  background-color: rgba(0, 0, 0, 0.3);

  /*  Анимация  */
  animation: rotateWithOrigin 3000ms linear 1000ms infinite;
}

.boxy:nth-child(1)::before {
  transform-origin: top left;
}

.boxy:nth-child(2)::before {
  transform-origin: top center;
}

.boxy:nth-child(3)::before {
  transform-origin: top right;
}

.boxy:nth-child(4)::before {
  transform-origin: center left;
}

.boxy:nth-child(5)::before {
  transform-origin: center center;
}

.boxy:nth-child(6)::before {
  transform-origin: center right;
}

.boxy:nth-child(7)::before {
  transform-origin: bottom left;
}

.boxy:nth-child(8)::before {
  transform-origin: bottom center;
}

.boxy:nth-child(9)::before {
  transform-origin: bottom right;
}

.boxy::after {
  position: absolute;
  display: inline-block;
  content: "";
  width: var(--dot-size);
  height: var(--dot-size);
  background-color: blue;
  border-radius: 50%;
}

.boxy:nth-child(1)::after {
  top: calc(var(--dot-size) / -2);
  left: calc(var(--dot-size) / -2);
}

.boxy:nth-child(2)::after {
  top: calc(var(--dot-size) / -2);
  left: center;
}

.boxy:nth-child(3)::after {
  top: calc(var(--dot-size) / -2);
  right: calc(var(--dot-size) / -2);
}

.boxy:nth-child(4)::after {
  top: center;
  left: calc(var(--dot-size) / -2);
}

.boxy:nth-child(5)::after {
  top: center;
  left: center;
}

.boxy:nth-child(6)::after {
  top: center;
  right: calc(var(--dot-size) / -2);
}

.boxy:nth-child(7)::after {
  bottom: calc(var(--dot-size) / -2);
  left: calc(var(--dot-size) / -2);
}

.boxy:nth-child(8)::after {
  bottom: calc(var(--dot-size) / -2);
  left: center;
}

.boxy:nth-child(9)::after {
  bottom: calc(var(--dot-size) / -2);
  right: calc(var(--dot-size) / -2);
}

@keyframes rotateWithOrigin {
  0% {
    transform: rotate3d(0, 0, 1, 0deg);
  }

  100% {
    transform: rotate3d(0, 0, 1, 360deg);
  }
}

/* ================== */
.container {
  min-height: 33vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.box1 {
  width: 200px;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-left: 15px;
  margin-right: 15px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box1::before {
  display: inline-block;
  font-size: 20px;
}

.box1:nth-child(1) {
  /*   transform: scale(1.25); */
  background-color: orange;

  animation: animate125 3000ms infinite 1000ms;
}

.box1:nth-child(1)::before {
  content: "scale(1.25)";
}

.box1:nth-child(2) {
  /*  Оригинальный размер, значение по умолчанию  */
  /*   transform: scale(1); */
  background-color: #03a9f4;
}

.box1:nth-child(2)::before {
  content: "scale(1)";
}

.box1:nth-child(3) {
  /*   transform: scale(0.75); */
  background-color: palevioletred;

  animation: animate75 3000ms infinite 1000ms;
}

.box1:nth-child(3)::before {
  content: "scale(0.75)";
}

@keyframes animate125 {
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(1.25);
  }

  100% {
    transform: scale(1);
  }
}

@keyframes animate75 {
  0% {
    transform: scale(1);
  }

  50% {
    transform: scale(0.75);
  }

  100% {
    transform: scale(1);
  }
}

.box2 {
  width: 200px;
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-left: 10px;
  margin-right: 10px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box2::before {
  display: inline-block;
  font-size: 20px;
}

.box2:nth-child(1) {
  /*   transform: rotate(30deg); */
  background-color: orange;

  animation: animate30 3000ms infinite 1000ms;
}

.box2:nth-child(1)::before {
  content: "rotate(30deg)";
}

.box2:nth-child(2) {
  /*   transform: rotate(115deg); */
  background-color: #03a9f4;

  animation: animate115 3000ms infinite 1000ms;
}

.box2:nth-child(2)::before {
  content: "rotate(115deg)";
}

.box2:nth-child(3) {
  /*   transform: rotate(-45deg); */
  background-color: palevioletred;

  animation: animate45 3000ms infinite 1000ms;
}

.box2:nth-child(3)::before {
  content: "rotate(-45deg)";
}

@keyframes animate30 {
  0% {
    transform: rotate(0deg);
  }

  50% {
    transform: rotate(30deg);
  }

  100% {
    transform: rotate(0deg);
  }
}

@keyframes animate115 {
  0% {
    transform: rotate(0deg);
  }

  50% {
    transform: rotate(115deg);
  }

  100% {
    transform: rotate(0deg);
  }
}

@keyframes animate45 {
  0% {
    transform: rotate(0deg);
  }

  50% {
    transform: rotate(-45deg);
  }

  100% {
    transform: rotate(0deg);
  }
}

.box3 {
  width: 250px;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-left: 5px;
  margin-right: 5px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box3::before {
  font-size: 20px;
}

.box3:nth-child(1) {
  /*   transform: translateX(50px); */

  animation: animateX50 3000ms infinite 1000ms;
  background-color: orange;
}

.box3:nth-child(1)::before {
  content: "translateX(50px)";
}

.box3:nth-child(2) {
  /*   transform: translateY(110px); */

  animation: animateY110 3000ms infinite 1000ms;
  background-color: #03a9f4;
}

.box3:nth-child(2)::before {
  content: "translateY(110px)";
}

.box3:nth-child(3) {
  /*   transform: translate(-50px, -100px); */

  animation: animateX50Y100 3000ms infinite 1000ms;
  background-color: palevioletred;
}

.box3:nth-child(3)::before {
  content: "translate(-50px, -100px)";
}

@keyframes animateX50 {
  0% {
    transform: translateX(0);
  }

  50% {
    transform: translateX(50px);
  }

  100% {
    transform: translateX(0);
  }
}

@keyframes animateY110 {
  0% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(110px);
  }

  100% {
    transform: translateY(0);
  }
}

@keyframes animateX50Y100 {
  0% {
    transform: translate(0, 0);
  }

  50% {
    transform: translate(-50px, -100px);
  }

  100% {
    transform: translate(0, 0);
  }
}
/* ================= */
.parent {
  position: relative;
  max-width: 500px;
  height: 300px;
  border: 10px solid #303f9f;
  border-radius: 10px;
  background-color: #3f51b5;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box-center {
  width: 100px;
  height: 100px;
  border: 10px solid #ffa000;
  border-radius: 10px;
  background-color: #ffc107;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
.box {
  width: 220px;
  height: 120px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  margin-left: 5px;
  margin-right: 5px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box::before {
  display: inline-block;
  font-size: 20px;
}

.box:nth-child(1) {
  /*   transform: skewX(30deg); */

  animation: animateX30 3000ms infinite 1000ms;
  background-color: orange;
}

.box:nth-child(1)::before {
  content: "skewX(30deg)";
}

.box:nth-child(2) {
  /*   transform: skewY(30deg); */

  animation: animateY30 3000ms infinite 1000ms;
  background-color: #03a9f4;
}

.box:nth-child(2)::before {
  content: "skewY(30deg)";
}

.box:nth-child(3) {
  /*   transform: skew(-30deg, 30deg); */

  animation: animateX30Y30 3000ms infinite 1000ms;
  background-color: palevioletred;
}

.box:nth-child(3)::before {
  content: "skew(-30deg, 30deg)";
}

@keyframes animateX30 {
  0% {
    transform: skewX(0deg);
  }

  50% {
    transform: skewX(30deg);
  }

  100% {
    transform: skewX(0deg);
  }
}

@keyframes animateY30 {
  0% {
    transform: skewX(0deg);
  }

  50% {
    transform: skewY(30deg);
  }

  100% {
    transform: skewX(0deg);
  }
}

@keyframes animateX30Y30 {
  0% {
    transform: skew(0deg);
  }

  50% {
    transform: skew(30deg, 30deg);
  }

  100% {
    transform: skew(0deg);
  }
}

</style>
