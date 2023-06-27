<div class="box" >
<form>
  <label>
    English text
    <input id="english_text" type="text" name="text" title="English text." value="<?=$english?>" />
  </label>
  <label>
    Dutch text
    <input id="dutch_text" type="text" name="text" title="Dutch text." value="<?=$dutch?>" />
  </label>
<label>
    Username
    <input type="text" name="text" required pattern="^[a-zA-Z]+\s[a-zA-Z]+$" title="Username must be two words separated by space." />
  </label>
  <label>
    Password
    <input type="password" name="password" required minlength="6" maxlength="12" 
    pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Please include at least 1 uppercase character, 1 lowercase character, and 1 number." />
  </label>
   <label>
    How many pizzas do you want to order?
    <input type="number" name="amount" required min="1" max="10" />
  </label>
  <button id="submit" type="button">Submit</button>
</form>

</div>

<style>
body {
  font-family: sans-serif;
  line-height: 1.5;
  color: #2a2a2a;
}
.box {
  margin: 2rem 10rem;
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
</style>
<script>
  $(document).ready(function(){
    $('#submit').click(function(){
      alert('HERE');
      $.ajax({
        url: '<?= path('translate') ?>',
        method: 'post',
        dataType: 'json',
        data: { text: $('#english_text').val() },
        success: function(result) {
          $('#dutch_text').val(result['dutch']);
        }

      });
    });

  });
</script>