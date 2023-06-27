<p>
@media media-type and (media-feature) {
  /*
  * Набор CSS-правил, которые нужно применить к документу,
  * если условие проверки медиатипа и выражения истинно
  */
}
</p>
<h1>Медиа-типы</h1>
<p>
<br>all - если не указать тип носителя, по умолчанию будет использовано это значение, которое означает любое устройство.
<br>print - соответствует принтерам и устройствам, предназначенным для воспроизведения печатного варианта, например веб-браузеру, отображающему документ в режиме «Предварительный просмотр».
<br>screen - описывает устройства с физическим экраном: смартфоны, планшеты, мониторы, телевизоры и т. д. То есть всё, что не охватывает тип print.
</p>
<h1>Медиа-функции</h1>
<p>
Две наиболее часто используемые медиа-функции, которые позволяют определять ширину вьюпорта браузера - min-width и max-width. Указывается минимальная (min-width) или максимальная (max-width) допустимые ширины вьюпорта, при которых применяются правила из медиа-запросов.
</p>
<h1>Логические операторы</h1>
<p>
@media only|not media-type only|and|not (media-feature) {
  /*
    Набор CSS-правил, которые нужно применить к документу,
    если условие проверки медиатипа и выражения истинно
  */
}</p>

<div class="container responsive">
  <p class="label">I'm a responsive container</p>
</div>
<div class="container adaptive">
  <p class="label">I'm an adaptive container</p>
</div>


<style>
/* Base styles */
body {
  padding-left: 15px;
  padding-right: 15px;
  color: #2a2a2a;
  background-color: #fff;
  font-size: 16px;
  line-height: 1.5;
  font-family: sans-serif;
}

/* From 600px and wider, override the background, font and color. */
@media screen and (min-width: 600px) {
  body {
    background-color: #2196f3;
    font-size: 20px;
    color: #fff;
  }
}

/* From 600px and wider, override the background. */
@media screen and (min-width: 900px) {
  body {
    background-color: #4caf50;
  }
}

/*  */
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: sans-serif;
}

/* Common container styles. */
.container {
  min-width: 320px;
  margin-left: auto;
  margin-right: auto;
  background-color: #ffc107;

  /*  Text styles  */
  text-align: center;
  line-height: 180px;
  font-size: 32px;
  white-space: nowrap;
}

/* Set the maximum width of the responsive container. */
.container.responsive {
  max-width: 1140px;
  margin-bottom: 40px;
}

/* Set the base width of a adaptive container. */
.container.adaptive {
  max-width: 400px;
}

@media screen and (min-width: 600px) {
  .container {
    background-color: #00bcd4;
  }
  /* Change the current width of the adaptive container at each breakpoint. */
  .container.adaptive {
    max-width: 600px;
  }
}

@media screen and (min-width: 900px) {
  .container {
    background-color: #8bc34a;
  }
  /* Change the current width of the adaptive container at each breakpoint. */
  .container.adaptive {
    max-width: 900px;
  }
}

@media screen and (min-width: 1140px) {
  .container {
    background-color: #ff5252;
  }
  /* Change the current width of the adaptive container at each breakpoint. */
  .container.adaptive {
    max-width: 1140px;
  }
}

.container .label {
  margin-top: 0;
}

</style>