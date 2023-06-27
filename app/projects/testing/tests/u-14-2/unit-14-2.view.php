<h1>Mobile-first CSS</h1>
<p>
<br>Технически реализация Mobile First довольно проста - стили для мобильных устройств это базовые стили вне медиа-запросов, после чего, для каждой точки перелома добавялется медиа-запрос в котором переопределяются необходимые базовые стили, стили из предыдущего промежутка или добавляются новые. Поэтому в медиа-запросах, в основном, используется медиа-функция min-width.
<br>
<br>
.element {
  /* Базовые стили */
}

@media screen and (min-width: ширина-планшета) {
  .element {
    /* Стили планшета */
  }
}

@media screen and (min-width: ширина-десктопа) {
  .element {
    /* Стили десктопа */
  }
}
</p>

<div class="container">
  <div class="element">1</div>
  <div class="element">2</div>
  <div class="element">3</div>
  <div class="element">4</div>
  <div class="element">5</div>
  <div class="element">6</div>
</div>

<style>
* {
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
}

/* 
 * Base container and element styles for mobile devices.
 * All blocks go underneath each other, so there are no unnecessary flexbox styles.
 */
.container {
  max-width: 1170px;
  min-width: 320px;
  margin-left: auto;
  margin-right: auto;
  border: 1px solid black;
  border-radius: 10px;
  padding: 10px;
}

.element {
  padding: 20px;
  border-radius: 10px;
  text-align: center;
  font-size: 24px;
  color: #fff;
}

/* 
 * Override or add new styles for blocks on wider screens.
 */
@media screen and (min-width: 768px) {
  .container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }

  .element {
    flex-basis: calc(100% / 2);
    font-size: 32px;
  }
}

@media screen and (min-width: 1024px) {
  .element {
    flex-basis: calc(100% / 3);
  }
}
.element:nth-child(0) {
    background-color: #F44336;
}
.element:nth-child(1) {
    background-color: #3F51B5;
}
.element:nth-child(2) {
    background-color: #4CAF50;
}
.element:nth-child(3) {
    background-color: #00BCD4;
}
.element:nth-child(4) {
    background-color: #E91E63;
}
.element:nth-child(5) {
    background-color: #009688;
}
/* 

$colors: "#F44336", "#3F51B5", "#4CAF50", "#00BCD4", "#E91E63", "#009688";

@each $color in $colors {
  $idx: index($colors, $color);

  .element:nth-child(#{$idx}) {
    background-color: #{$color};
  }
} */
</style>