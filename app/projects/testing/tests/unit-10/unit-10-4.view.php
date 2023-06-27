<h1>CSS-анимация</h1>
<br>
<p>
Анимация объявляется директивой @keyframes, которая позволяет описать набор кадров (frames, состояний) анимации, которых должно быть как минимум два (начальный и конечный).
</p>
<br>
<p>
Кадры определяют в какой момент времени изменяются анимируемые свойства, и описываются ключевыми словами from (псевдоним 0%) и to (псевдоним 100%) или, чаще всего, в виде процентов в промежутке 0%-100%, так как проценты позволяют указать произвольное значение.
</p>
<br>
<p>
animation: [name] [duration] [timing-function] [delay] [iteration-count] [direction] [fill-mode] [play-state]
</p>
<h2>The animation starts when hovering over an element</h2>
<div class="box"></div>

<img src="https://image.flaticon.com/icons/svg/2917/2917242.svg" alt="Солнышко" width="300" height="300">

<form class="controls-form">
  <div class="options">
    <label>
      <input type="radio" name="option" value="normal" checked>
      normal
    </label>

    <label>
      <input type="radio" name="option" value="reverse">
      reverse
    </label>

    <label>
      <input type="radio" name="option" value="alternate">
      alternate
    </label>

    <label>
      <input type="radio" name="option" value="alternate-reverse">
      alternate-reverse
    </label>
  </div>

  <button type="submit" name="submit">Start</button>
</form>

<div class="canvas">
  <div class="circle"></div>
</div>

<style>
body {
  text-align: center;
  font-family: sans-serif;
  background-color: #f9f9fd;
}

h1 {
  font-size: 24px;
}

.box {
  width: 300px;
  height: 300px;
  margin-left: auto;
  margin-right: auto;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

/* Adds animation when hovering. */
.box:hover {
  animation-name: changeBgColor;
  animation-duration: 3000ms;
}

@keyframes changeBgColor {
  0% {
    background-color: teal;
  }

  50% {
    background-color: orange;
  }

  100% {
    background-color: deepskyblue;
  }
}
img {
  animation-name: spin;
  animation-duration: 5s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
/* ============ */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  background-color: #f9f9fd;
}

.controls-form {
  margin-bottom: 20px;
  padding: 10px;
  text-align: center;
}

.controls-form > .options {
  margin-bottom: 20px;
}

.controls-form button {
  min-width: 200px;
  padding: 10px 30px;
  font-family: inherit;
  font-size: 18px;
  letter-spacing: 0.03em;
  cursor: pointer;
}

.controls-form input {
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

.controls-form label {
  display: inline-flex;
  align-items: center;
  margin-right: 5px;
  margin-left: 5px;
  font-size: 18px;
  cursor: pointer;
}

.canvas {
  display: flex;
  align-items: center;
  width: 600px;
  height: 300px;
  margin-left: auto;
  margin-right: auto;
  padding: 10px;
  border-radius: 10px;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.circle {
  width: 150px;
  height: 150px;
  background-color: orange;
  border: 5px solid black;
  border-radius: 50%;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.circle.is-animated {
  animation-name: move;
  animation-duration: 1.5s;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
}

@keyframes move {
  0% {
    transform: translatex(0);
  }

  100% {
    transform: translatex(420px);
  }
}

</style>

<script>
const ctrlsForm = document.querySelector(".controls-form");
const circle = document.querySelector(".circle");

ctrlsForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const { submit: submitBtn, option } = e.currentTarget.elements;

  circle.style.animationDirection = option.value;
  circle.classList.toggle("is-animated");

  const isAnimated = circle.classList.contains("is-animated");

  option.forEach((el) => (el.disabled = isAnimated));

  submitBtn.textContent = isAnimated ? "Stop" : "Start";
});
</script>