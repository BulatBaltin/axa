<!-- https://bennettfeely.com/clippy/ -->
<style>
  .body-box{
    background-color: red;
    background-blend-mode: screen;
    min-height: 500px;
    /* background-image: image('paris.jpg'); */
    /* background-image: url('paris.jpg'); */
    background-image: url(/images/paris.jpg);

    clip-path: polygon(100% 0, 100% 57%, 51% 100%, 0 100%, 0 0);
  }
</style>
<? $image = './images/paris.jpg'; ?>
<? $image = 'https://picsum.photos/id/237/320/240'; ?>

<div class='body-box'>
Hi there
<br>

<? if(file_exists('./images/paris.jpg')) { 
  echo "<br>I found it " . '/images/paris.jpg'; 
} else { 
  echo "<br>NO luck for " . '/images/paris.jpg'; 
}
?>

<?= __DIR__ ?>
</div>

<script>
$(document).ready(function() {

// alert('JUMP_IN');  

const one = 1, two = 2, three = 3;

console.log({ one, two, three });
console.log('%c My friends', 'color: oringe; font-size: 20px;');
console.table([ one, two, three ]);

console.time('looper');
let i = 0;
while(i < 1000000) {
  ++i;
}
console.timeEnd('looper');
// 
const deleteMe = ()  => console.trace('bye bye DB');
deleteMe();
deleteMe();
// 
const Turtle = {
  name: 'Bob',
  legs: 4,
  shell: true,
  meal: 'berries',
  diet: 10,
}

// Bad code
function feedBad(animal) {
  return `Feed ${animal.name} ${animal.meal} kilos of ${animal.diet}`
}
// Good code
function feedGood({name, meal, diet}) {
  return `Feed(2) ${name} ${meal} kilos of ${diet}`
}
// Good code
function feedGood2(animal) {
  const {name, meal, diet} = animal;
  return `Feed(2) ${name} ${meal} kilos of ${diet}`
}
// 
const {name, legs, meal} = Turtle;
console.log(`Turtle ${name} ${legs}, ${meal}`);

// Loops
const orders = [1,2,3,4,5,6,7,8,]
let total = orders.reduce((acc, curr) => acc+curr);
console.log(`Total = ${total}`);
// 2.
let totals = orders.map( v => v * 1.2);
console.table(totals);
// 3.
let filts = orders.filter( v => v > 3);
console.table(filts);






});
</script>
