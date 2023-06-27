<div class="box" >
<button class="btn">Active button</button>
<button class="btn" disabled>Disabled button</button>
<h2>
checkbox
</h2>
<p>
Применяется к радиокнопкам и чекбоксам, и позволяет выбрать только отмеченные поля. Например, пусть при выборе чекбокса текст метки становится синим. Используя селектор + можно выбрать метку когда чекбокс отмечен, но для этого необходимо чтобы тег <b>label</b> был в разметке после чекбокса.  
</p>
<br>
<form class="form">
  <div role="group" class="form-group">
    <b class="form-caption">What are your hobbies?</b>

    <div class="form-field">
      <input type="checkbox" class="form-input" name="hobby" value="sports" id="sports">
      <label class="form-label" for="sports">Sports</label>
    </div>

    <div class="form-field">
      <input type="checkbox" class="form-input" name="hobby" value="music" id="music">
      <label class="form-label" for="music">Music</label>
    </div>

    <div class="form-field">
      <input type="checkbox" class="form-input" name="hobby" value="books" id="books">
      <label class="form-label" for="books">Books</label>
    </div>
  </div>

  <button type="submit">Submit</button>
</form>

<h2>
  :in-range и :out-of-range
</h2>
<p>Эти псевдоклассы применяются к элементам <range>, <number> и <date>, если у них указаны атрибуты min и max.</p>

<form class="form">
  <div class="form-field">
    <label for="amount-1" class="form-label">How many pizzas do you want to order?</label>
    <input type="number" required min="1" max="10" step="1" value="0" name="amount-1" id="amount-1" class="form-input">
  </div>
    <div class="form-field">
    <label for="amount-2" class="form-label">How many pizzas do you want to order?</label>
    <input type="number" required min="1" max="10" step="1" value="3" name="amount-2" id="amount-2" class="form-input">
  </div>
    <div class="form-field">
    <label for="amount-3" class="form-label">How many pizzas do you want to order?</label>
    <input type="number" required min="1" max="10" step="1" name="amount-3" id="amount-3" class="form-input">
  </div>

  <label class="form-label">
    <span class="label-text">Username</span>
    <input type="text" class="form-input" name="username" required minlength="3">
  </label>

  <label class="form-label">
    <span class="label-text">Email</span>
    <input type="email" class="form-input" name="mail" required>
  </label>

  <label class="form-label">
    <span class="label-text">Username</span>
    <input type="text" class="form-input" name="username" placeholder="Jacob Mercer">
  </label>

  <label class="form-label">
    <span class="label-text">Email</span>
    <input type="email" class="form-input" name="mail" placeholder="jacob@mail.com">
  </label>

  <label class="form-label">
    <span class="label-text">Username</span>
    <input type="text" class="form-input" name="username" placeholder="Jacob Mercer" minlength="3" required>
  </label>

  <label class="form-label">
    <span class="label-text">Email</span>
    <input type="email" class="form-input" name="mail" placeholder="jacob@mail.com" required>
  </label>

  <button type="submit">Submit</button>
</form>

<!-- :focus-within -->
<h1>:focus-within</h1>
<form class="form">
  <label class="form-label">
    <span class="label-text">Username</span>
    <input type="text" class="form-input" name="username" required minlength="3" placeholder=" ">
  </label>

  <label class="form-label">
    <span class="label-text">Email</span>
    <input type="email" class="form-input" name="mail" required placeholder=" ">
  </label>

  <button type="submit">Submit</button>
</form>
</div>

<style>
/* Selecting .form-label when the checkbox preceding it in markup is checked */
.form-input:checked + .form-label {
  color: #2196f3;
}

/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form-caption {
  display: block;
  text-transform: uppercase;
  margin-bottom: 16px;
}

.form-group {
  margin-bottom: 24px;
}

.form-field {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
}

.form-label {
  margin-left: 4px;
  cursor: pointer;
}

button {
  display: inline-flex;
  padding: 12px 32px;
  border: none;
  border-radius: 4px;
  background-color: #2196f3;
  color: #fff;
  font-size: inherit;
  cursor: pointer;
}

button:hover,
button:focus {
  background-color: #1976d2;
}


.box {
  margin: 2rem 10rem;
}
.btn:enabled {
  box-shadow: 0px 3px 1px -2px rgb(0 0 0 / 20%),
    0px 2px 2px 0px rgb(0 0 0 / 14%), 0px 1px 5px 0px rgb(0 0 0 / 12%);
}

.btn:disabled {
  background-color: lightgray;
  color: #2a2a2a;
}


/* Example styles */
* {
  box-sizing: border-box;
}

body {
  /* min-height: 100vh;
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center; */
  color: #2a2a2a;
  font-family: sans-serif;
  line-height: 1.5;
}

.btn {
  display: inline-flex;
  margin: 0 4px;
  padding: 12px 24px;
  border: none;
  border-radius: 4px;

  font-family: sans-serif;
  font-size: 16px;

  background-color: #2196f3;
  color: #fff;
  cursor: pointer;
}

.btn:hover,
.btn:focus {
  background-color: #1976d2;
}
.form-input:in-range {
  border-color: #4caf50;
}

.form-input:out-of-range {
  border-color: #f44336;
}

/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form-field {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.form-label {
  margin-bottom: 8px;
  cursor: pointer;
}

.form-input {
  padding: 8px;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  font-family: sans-serif;
  font-size: 16px;
  outline: none;
}

button {
  display: inline-flex;
  padding: 12px 32px;
  border: none;
  border-radius: 4px;
  background-color: #2196f3;
  color: #fff;
  font-size: inherit;
  cursor: pointer;
}

button:hover,
button:focus {
  background-color: #1976d2;
}

.form-input:valid {
  border-color: #4caf50;
}

.form-input:invalid {
  border-color: #f44336;
}

/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form-label {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.label-text {
  margin-bottom: 4px;
}

.form-input {
  padding: 8px;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  font-family: inherit;
  font-size: 16px;
  outline: none;
}
.form-input:placeholder-shown {
  border-color: #ffa000;
}

.form-input:not(:placeholder-shown) {
  border-color: #2196f3;
}


/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form-label {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.label-text {
  margin-bottom: 4px;
}

.form-input {
  padding: 8px;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  font-family: inherit;
  font-size: 16px;
  outline: none;
}


.form-input::placeholder {
  color: #9e9e9e;
}

.form-input:not(:placeholder-shown):required:valid {
  border-color: green;
}

.form-input:not(:placeholder-shown):required:invalid {
  border-color: red;
}

/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form-label {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.label-text {
  margin-bottom: 4px;
}

.form-input {
  padding: 8px;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  font-family: inherit;
  font-size: 16px;
  outline: none;
}

.form-input::placeholder {
  color: #9e9e9e;
}
.form:focus-within {
  border-color: #2196f3;
}

.form-label:focus-within {
  color: #2196f3;
}

.form-input:not(:placeholder-shown):required:valid {
  border-color: #4caf50;
}

.form-input:not(:placeholder-shown):required:invalid {
  border-color: #f44336;
}

/* Example styles */
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}

.form {
  width: 100%;
  padding: 24px;
  border-radius: 4px;
  border: 2px dashed #2a2a2a;
}

.form-label {
  display: flex;
  flex-direction: column;
  margin-bottom: 16px;
}

.label-text {
  margin-bottom: 4px;
}

.form-input {
  padding: 8px;
  border: 1px solid #2a2a2a;
  border-radius: 4px;
  font-family: inherit;
  font-size: 16px;
  outline: none;
}

</style>