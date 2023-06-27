<h1><?= $text ?></h1>
<div>
  <input class="edit-table" type="text"><input class="button-table" type="submit">
  <input class="edit-table" type="text"><span class="button-table"><i class="fas fa-ellipsis-h"></i></span>
</div>


  <style>
/* input[type="text"] { */
.edit-table {
    width: 200px;
    height: 20px;
    padding-right: 50px;
}

/* input[type="submit"] { */
.button-table {
    margin-left: -50px;
    display: inline-block;
    height: 50px;
    width: 50px;
    background: blue;
    color: white;
    border: 0;
    -webkit-appearance: none;
}
</style>

<div class="contain">

<form class="controls-form">
  <label>
    Username
    <input type="text" name="username" autofocus placeholder="Jacob Mercer"/>
  </label>
  <label>
    Email
    <input type="email" name="email" />
  </label>
  <label>
    Email
    <input type="email" name="email" />
  </label>
  <label>
    Password
    <input type="password" name="password" minlength="5" maxlength="12" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;" />
  </label>

  <p>Choose a color:</p>
  <label>
    <input type="radio" name="color" value="red" checked />
    Red
  </label>
  <label>
    <input type="radio" name="color" value="white" />
    White
  </label>
  <label>
    <input type="radio" name="color" value="green" />
    Green
  </label>

  <!-- <div style="display:flex;"> -->
  <p>What are your hobbies?</p>
  <label>
    <input type="checkbox" name="hobby" value="music" checked />
    Music
  </label>
  <label>
    <input type="checkbox" name="hobby" value="sports" checked />
    Sports
  </label>
  <label>
    <input type="checkbox" name="hobby" value="reading" />
    Reading
  </label>
  <!-- </div> -->

  <label>
  Weight with 0.1 step value:
  <input type="number" name="weight" min="0" max="150" step="0.1" value="0" />
</label>

<label>
  Height with 0.4 step value:
  <input type="number" name="height" min="0" max="200" step="0.4" value="0" />
</label>  

<label>
    Phone number
    <input type="tel" name="phone_number" />
  </label>

  <label>
  Interest rate:
  <input
    type="range"
    name="interest_rate"
    value="40"
    min="0"
    max="300"
    step="20"
  />
</label>

<p>Selected value: <span class="js-selected-value">40</span></p>

<label>
    Date
    <input type="date" min="1920-01-01" max="2020-01-01" />
  </label>

  <label>
    Time
    <input type="time" />
  </label>

  <label>
    Date and time
    <input type="datetime-local" min="1920-01-01T00:00" max="2020-01-01T00:00" />
  </label>

  <label>
    Feedback
    <textarea name="feedback" rows="5" placeholder="Type your message here..."></textarea>
  </label>

  <label for="size">Size</label>

<label for="month">Month</label>
<select name="month" id="month">
  <optgroup label="Summer">
    <option value="s6">June</option>
    <option value="s7">July</option>
    <option value="s8">August</option>
  </optgroup>

  <optgroup label="Autumn">
    <option value="s9">September</option>
    <option value="s10">October</option>
    <option value="s11">November</option>
  </optgroup>
</select>

<label for="fav">Choose your favourite browser</label>
<input list="browsers" name="fav" id="fav" />

<datalist id="browsers">
  <option>Edge</option>
  <option>Firefox</option>
  <option>Chrome</option>
  <option>Opera</option>
  <option>Safari</option>
</datalist>

<label for="state">Choose your state</label>
<input type="text" name="state" id="state" list="states" />
<datalist id="states">
  <option value="AL">Alabama</option>
  <option value="AK">Alaska</option>
  <option value="AZ">Arizona</option>
  <option value="AR">Arkansas</option>
</datalist>
<!-- Группировка -->
<fieldset>
    <legend>Enter your contact details</legend>
    <label>
      Name
      <input type="text" name="username" />
    </label>
    <label>
      Email
      <input type="email" name="email" />
    </label>
  </fieldset>

  <fieldset>
    <legend>Your favourite programming language</legend>
    <label>
      <input type="checkbox" name="language" value="python">
      Python
    </label>
    <label>
      <input type="checkbox" name="language" value="js">
      JavaScript
    </label>
    <label>
      <input type="checkbox" name="language" value="ruby">
      Ruby
    </label>
  </fieldset>

  <fieldset>
    <legend>I want to receive</legend>
    <label>
      <input type="checkbox" name="newsletter" value="weekly">
      The weekly newsletter
    </label>
    <label>
      <input type="checkbox" name="newsletter" value="company_offers">
      Offers from the company
    </label>
    <label>
      <input type="checkbox" name="newsletter" value="associated_offers">
      Offers from associated companies
    </label>
  </fieldset>

<!-- Группировка через div -->

<div class="form-group" role="group" aria-labelby="contact-details-head">
    <p id="contact-details-head">Enter your contact details</p>
    <label>
      Name
      <input type="text" name="username" />
    </label>
    <label>
      Email
      <input type="email" name="email" />
    </label>
  </div>

  <div class="form-group" role="group" aria-labelby="language-head">
    <p id="language-head">Your favourite programming language</p>
    <label>
      <input type="checkbox" name="language" value="python">
      Python
    </label>
    <label>
      <input type="checkbox" name="language" value="js">
      JavaScript
    </label>
    <label>
      <input type="checkbox" name="language" value="ruby">
      Ruby
    </label>
  </div>

  <div class="form-group" role="group" aria-labelby="newsletter-head">
    <p id="newsletter-head">I want to receive</p>
    <label>
      <input type="checkbox" name="newsletter" value="weekly">
      The weekly newsletter
    </label>
    <label>
      <input type="checkbox" name="newsletter" value="company_offers">
      Offers from the company
    </label>
    <label>
      <input type="checkbox" name="newsletter" value="associated_offers">
      Offers from associated companies
    </label>
  </div>
<!-- BORDER -->

<div class="form-item">
     <span class="label">Логин:</span>
     <span class="field"><input type="text" name="login" value="" class="form-text"></span>
   </div>
   <div class="form-item">
     <span class="label">Пароль:</span>
     <span class="field"><input type="password" name="pass" class="form-text"></span>
   </div>

<div style='width:120px; height: 120px; background: rgba(229, 103, 23, 0.8) ;'></div>
<div style='width:120px; height: 120px; background: rgba(229, 103, 23, 0.075) ;'></div>
<div style='width:120px; height: 120px; background: rgba(229, 103, 23, 0.6) ;'></div>

<button type="submit">Submit</button>
</form>
<div class='new-p'>
<p>
Lorem ipsum dolor, sit amet consectetur adipisicing elit. In laborum dolor ratione voluptatem eaque ex, dignissimos rem eligendi voluptates cum voluptatum maiores sapiente corporis tempore quia adipisci impedit dolores magni!
Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque ducimus animi iure illo itaque incidunt ea error dolore, libero assumenda. Architecto non minus, repellat ullam distinctio facere officia cum impedit.
</p>

</div>

<div class="card">
30 50 60
</div>

</div>

<style>
.card {
  font-size: 3vw;
  width: 2ch;
}  
.new-p p {
  column-count: 3;
  gap: 2rem;
}  
body {
  font-family: sans-serif;
  line-height: 1.5;
}

input {
  padding: 8px;
  font-family: inherit;
}

label {
  display: flex;
  flex-direction: column;
  margin-bottom: 8px;
}
.contain{
  margin: 2rem;
}

.controls-form button {
  min-width: 200px;
  padding: 10px 30px;
  font-family: inherit;
  font-size: 18px;
  letter-spacing: 0.03em;
  cursor: pointer;
}
label {
  display: flex;
  /* align-items: center; */
}

input, textarea {
  padding: 8px;
  font-family: inherit;
  font-size: inherit;
  /* Add a blur effect to the shadow: */
  /* box-shadow: 5px 5px 5px 5px #DDDDDD; */
  }
textarea {
  resize: none;
}
select {
  font-size: 16px;
}
/* label {
  display: block;
  margin-bottom: 4px;
} */

select {
  padding: 10px;
  font-size: 18px;
}
fieldset {
  padding: 10px 20px;
}
legend {
  padding: 10px 10px;
  background: yellow;
}
.form-group {
  display: flex;
  flex-direction: column;
  padding: 10px;
  margin-bottom: 10px;
  border: 1px solid black;
  border-radius: 4px;
}

.form-group p {
  margin-top: 0;
  margin-bottom: 10px;
  font-weight: 700;
  font-size: 20px;
}
/* ======== */
textarea:focus, input:focus, input[type]:focus, .uneditable-input:focus {   
    /* border-color: rgba(229, 103, 23, 0.8);
    box-shadow: 0 1px 1px rgba(229, 103, 23, 0.075) inset, 0 0 8px rgba(229, 103, 23, 0.6); */
    border-color: rgba(96, 125, 139, 0.8);
    box-shadow: 0 1px 1px rgba(96, 125, 139, 0.075) inset, 0 0 8px rgba(96, 125, 139, 0.6);
    outline: 0 none;
}
</style>
<script>
const rangeInput = document.querySelector('input[type="range"]')
const output = document.querySelector('.js-selected-value');
rangeInput.addEventListener('input', e => output.textContent = e.target.value)
</script>