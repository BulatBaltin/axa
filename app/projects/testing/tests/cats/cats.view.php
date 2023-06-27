<div class="container">
  <div class="thumb">
    <img src="https://images.pexels.com/photos/58997/pexels-photo-58997.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=320" alt="two-yellow-labrador-retriever-puppies">
    <p class="label">Dog</p>
  </div>

  <div class="thumb">
    <img src="https://images.pexels.com/photos/2558605/pexels-photo-2558605.jpeg?auto=compress&cs=tinysrgb&dpr=2&&w=320" alt="adorable-animal-blur-cat">
    <p class="label">Cat</p>
  </div>

  <div class="thumb">
    <img src="https://images.pexels.com/photos/1300361/pexels-photo-1300361.jpeg?auto=compress&cs=tinysrgb&dpr=2&w=320" alt="black-hog-prone-lying-on-soil-under-shade-of-tree">
    <p class="label">Pig</p>
  </div>
</div>

<div class="container">
  <div class="box">1</div>
  <div class="box">2</div>
  <div class="box">3</div>
  <div class="box">4</div>
</div>

<div class="thumb">
  <img src="https://images.pexels.com/photos/33492/cat-red-cute-mackerel.jpg?auto=compress&cs=tinysrgb&h=480&w=640" alt="">
</div>

<div class="q-box">
  <div class="overlay">
    <p>This content is hidden through transformation and only appears when hovering over <code>div.box</code></p>
  </div>
</div>

<div style="margin: 1rem 4rem;border: 1px solid green; border-radius: 6px; padding:1rem;">
  <label class="check-container">Very important checkbox 
    <input type="checkbox" name="check" id="">
    <span class="checkmark"></span>
  </label>
</div>

<div style="margin: 1rem 4rem;border: 1px solid green; border-radius: 6px; padding:1rem;">
  <input type="checkbox" class="custom-checkbox" id="happy" name="happy" value="yes">
  <label for="happy">Happy</label>
</div>

<div style="margin:1rem;">
<details>
  <summary>This is details of my report </summary>
  <h1>Heading -1</h1>
  <p>
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquam repellat commodi accusamus, recusandae similique quidem debitis libero ullam! Dolor non debitis quia magni odit aliquam pariatur voluptatibus laboriosam repellendus rem?
    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis alias omnis earum error eaque minus non aliquam ullam totam illo harum, accusamus commodi beatae debitis reprehenderit. Debitis asperiores dolores repudiandae?
  </p>
</details>
<input type="color" name="yes" id="no-007">
<input type="range" name="yes-range" id="range-007" value="2" min="1" max="10">
<input type="datetime-local">
<input type="week">
</div>
<style>
  progress {
    width: 200px;
    height: 50px;
  }
</style>
<div style="margin:1rem;">
  <meter value="70" max="100" min="10"></meter>
  
  <progress></progress>
</div>
<div style="margin:1rem;">
  <input type="text" name="tt" id="id-cars" list='cars'>
  <datalist id="cars">
    <option value="1">Zaz Priora</option>
    <option value="2">Zaz Retro</option>
    <option value="3">Zaz Avrora</option>
    <option value="4">Zaz Neolist</option>
    <option value="5">Zaz Hi-hop</option>
    <option value="6">Zaz Extra</option>
  </datalist>
</div>
<style>
 /* Checkbox */
 .custom-checkbox {
  position: absolute;
  z-index: -1;
  opacity: 0;
}

.custom-checkbox+label {
  display: inline-flex;
  align-items: center;
  user-select: none;
}
.custom-checkbox+label::before {
  content: '';
  display: inline-block;
  width: 2em;
  height: 2em;
  flex-shrink: 0;
  flex-grow: 0;
  border: 1px solid #adb5bd;
  border-radius: 0.25em;
  margin-right: 1.5em;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: 50% 50%;
}

.custom-checkbox:checked+label::before {
  border-color: #0b76ef;
  background-color: #0b76ef;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
}
/* стили при наведении курсора на checkbox */
.custom-checkbox:not(:disabled):not(:checked)+label:hover::before {
  border-color: #b3d7ff;
}
/* стили для активного состояния чекбокса (при нажатии на него) */
.custom-checkbox:not(:disabled):active+label::before {
  background-color: #b3d7ff;
  border-color: #b3d7ff;
}
/* стили для чекбокса, находящегося в фокусе */
.custom-checkbox:focus+label::before {
  box-shadow: 0 0 0 0.3rem rgba(0, 123, 255, 0.25);
}
/* стили для чекбокса, находящегося в фокусе и не находящегося в состоянии checked */
.custom-checkbox:focus:not(:checked)+label::before {
  border-color: #80bdff;
}
/* стили для чекбокса, находящегося в состоянии disabled */
.custom-checkbox:disabled+label::before {
  background-color: #e9ecef;
}

/* end */
body {
  background-color: #f9f9fd;
}

img {
  display: block;
  max-width: 100%;
  height: auto;
}

.container {
  display: flex;
  justify-content: center;
  margin: 0 auto;
}

.thumb {
  position: relative;
  margin: 10px;
  border-radius: 4px;
  overflow: hidden;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.thumb > .label {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  padding: 8px 16px;
  border-bottom-left-radius: 4px;

  font-family: sans-serif;
  font-size: 24px;
  background-color: #2196f3;
  color: #fff;
}

body {
  margin: 0;
  font-family: sans-serif;
  background-color: #f9f9fd;
}
.container {
  min-height: 50vh;
  position: relative;
}

.box {
  position: absolute;
  height: 150px;
  width: 150px;

  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 4px;
  font-size: 64px;
  color: #fff;

  box-shadow: 0px 5px 10px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box:nth-child(1) {
  top: 20px;
  left: 130px;
  background-color: #1789fc;

  z-index: 2;
}

.box:nth-child(2) {
  top: 30px;
  left: 230px;
  background-color: #ef233c;

  z-index: 2;
}

.box:nth-child(3) {
  top: 140px;
  left: 220px;
  background-color: #ffd07b;
  z-index: 1;
}

.box:nth-child(4) {
  top: 120px;
  left: 120px;
  background-color: #4caf50;
}

img {
  display: block;
  max-width: 100%;
  height: auto;
}

.thumb {
  border: 10px solid green;
  border-radius: 50px;
  width: 480px;

  overflow: hidden;
}

.q-box {
  position: relative;
  width: 300px;
  height: 300px;
  margin-left: auto;
  margin-right: auto;
  background-color: #bdbdbd;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  overflow: hidden;
}

.q-box:hover .overlay {
  transform: translatex(0);
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: #3f51b5;

  transform: translatex(-100%);
  transition: transform 250ms ease;
}

.overlay > p {
  color: #fff;
  padding: 10px;
  margin: 0;
  font-size: 18px;
}

.overlay code {
  display: inline-block;
  padding: 2px 4px;
  border-radius: 2px;
  background-color: #fff;
  color: #2a2a2a;
}

/* Checks: Customize the label (the check-container) */
.check-container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.check-container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.check-container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.check-container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.check-container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.check-container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

</style>