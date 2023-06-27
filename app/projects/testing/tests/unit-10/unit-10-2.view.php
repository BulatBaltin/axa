<h1>CSS-переходы</h1>
<div class="box"></div>
<h1>A transition is triggered when hovering over a container</h1>

<div class="flex-container">
  <div class="circle">500ms</div>
  <div class="circle">1500ms</div>
  <div class="circle">3000ms</div>
</div>

<h1>A transition is triggered when hovering over a container</h1>

<div class="container">
  <div class="circle"></div>
  <div class="circle"></div>
  <div class="circle"></div>
  <div class="circle"></div>
  <div class="circle"></div>
  <div class="circle"></div>
</div>

<style>
body {
  margin: 0;
  min-height: 100vh;
  /* display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f9f9fd; */
}

.box {
  margin: 5rem;
  width: 200px;
  height: 200px;
  border-radius: 10px;
  background-color: tomato;
  box-shadow: 0px 5px 3px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  /*  Задаём значения перехода  */
  transition-property: background-color, transform;
  transition-duration: 500ms;
  transition-timing-function: linear;
  transition-delay: 0;
}

/* При ховере меняем значения анимируемых свойств */
.box:hover {
  background-color: teal;
  transform: rotate(180deg);
}

* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  text-align: center;
}

h1 {
  font-size: 24px;
}

.flex-container {
  margin: 2rem;
  border: 2px dashed #2a2a2a;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 300px);
}

.circle {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100px;
  height: 100px;
  flex-shrink: 0;
  margin-left: 30px;
  margin-right: 30px;
  border-radius: 50%;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  transition-property: transform;
}

.flex-container:hover .circle {
  transform: scale(1.5);
}

.circle:nth-child(1) {
  background-color: orange;

  transition-duration: 500ms;
}

.circle:nth-child(2) {
  background-color: #03a9f4;

  transition-duration: 1500ms;
}

.circle:nth-child(3) {
  background-color: palevioletred;

  transition-duration: 3000ms;
}
.container {
  border: 2px dashed #2a2a2a;
  border-radius: 4px;
  padding: 10px;
}

.circle {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  transform: translatex(0);
  transition-property: transform;
  transition-duration: 2000ms;
}

.circle:not(:last-child) {
  margin-bottom: 5px;
}

.container:hover .circle {
  transform: translatex(calc(100vw - 86px));
}

.circle:nth-child(1) {
  background-color: #f44336;
  transition-timing-function: linear;
}

.circle:nth-child(2) {
  background-color: #3f51b5;
  transition-timing-function: ease;
}

.circle:nth-child(3) {
  background-color: #00bcd4;
  transition-timing-function: ease-in;
}

.circle:nth-child(4) {
  background-color: #4caf50;
  transition-timing-function: ease-out;
}

.circle:nth-child(5) {
  background-color: #ffeb3b;
  transition-timing-function: ease-in-out;
}

.circle:nth-child(6) {
  background-color: #e91e63;
  transition-timing-function: cubic-bezier(0.39, 1.03, 0.82, 0.08);
}

</style>