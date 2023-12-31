<h1>Анимируемые свойства</h1>
<form class="controls-form">
  <div class="options">
    <label>
      <input type="radio" name="option" value="animateMargin" checked>
      margin-left
    </label>

    <label>
      <input type="radio" name="option" value="animateTransform">
      transform
    </label>
  </div>

  <button type="submit" name="submit">Start</button>
</form>

<div id="root"></div>

<style>
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
}

#root {
  border: 3px dashed tomato;
  margin-top: 10px;
  padding: 10px;
}

.controls-form {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
  padding: 10px;
  text-align: center;
}

.controls-form > .options {
  margin-right: 20px;
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

.box {
  width: 50px;
  height: 50px;
  border-radius: 4px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box:not(:last-child) {
  margin-bottom: 10px;
}

.box.is-animated {
  animation-duration: 3s;
  animation-iteration-count: infinite;
  animation-direction: alternate;
  animation-timing-function: linear;
}

@keyframes animateMargin {
  0% {
    margin-left: 0px;
  }

  100% {
    margin-left: calc(100vw - 110px);
  }
}

@keyframes animateTransform {
  0% {
    transform: translateX(0);
  }

  100% {
    transform: translateX(calc(100vw - 110px));
  }
}
</style>

<script>

const rootEl = document.querySelector("#root");
const ctrlsForm = document.querySelector(".controls-form");

const boxesFragment = makeBoxesFragment(3000);
const boxes = [...boxesFragment.children];

rootEl.appendChild(boxesFragment);

ctrlsForm.addEventListener("submit", (e) => {
  e.preventDefault();
  const { submit: submitBtn, option } = e.currentTarget.elements;

  boxes.forEach((box) => {
    box.style.animationName = option.value;
    box.classList.toggle("is-animated");
  });

  const isAnimated = boxes[0].classList.contains("is-animated");
  option.forEach((el) => (el.disabled = isAnimated));
  submitBtn.textContent = isAnimated ? "Stop" : "Start";
});

function makeBoxesFragment(quantity) {
  const fragment = document.createDocumentFragment();
  const box = document.createElement("div");
  box.classList.add("box");

  for (let i = 0; i < quantity; i += 1) {
    const clone = box.cloneNode();
    clone.style.backgroundColor = getRandomColor();
    fragment.appendChild(clone);
  }
  
  return fragment;
}

function getRandomColor() {
  return `#${Math.floor(Math.random() * 16777215).toString(16)}`;
}

</script>