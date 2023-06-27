
<div class="card">
  <h1 class="card__title">Card title</h1>
  <p class="card__excerpt">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quos dicta, harum nam, ad possimus sed recusandae necessitatibus vel repellat voluptatem qui, error excepturi! Tenetur quos ipsa quod quia, veritatis vero.</p>
  <a href="" class="card__link">Read more</a>
</div>

<div class="m-10">
<section id="deals">
  <section class="sale-item">
    <h1 class="mb-5">Computer Starter Kit</h1>
    <p>This is the best computer money can buy, if you don’t have much money.
    <ul>
      <li>Computer
      <li>Monitor
      <li>Keyboard
      <li>Mouse
    </ul>
    <img src="images/computer.jpg"
         alt="You get: a white computer with matching peripherals.">
    <div class='p-3'></div>
    <button>BUY NOW</button>
  </section>
  <section class="sale-item">
  <h1 class="mb-5">Computer Starter Kit</h1>
    <p>This is the best computer money can buy, if you don’t have much money.
    <ul>
      <li>Computer
      <li>Monitor
      <li>Keyboard
      <li>Mouse
    </ul>
    <img src="images/computer.jpg"
         alt="You get: a white computer with matching peripherals.">
    <div class='p-3'></div>
    <button>BUY NOW</button>
  </section>
</section>
</div>

<footer class="page-footer">
  <a class="logo" href="">Takworld</a>
</footer>

<style>

#deals{
  display: flex;      
  flex-flow: row wrap;
  justify-content: space-evenly;
  align-items: flex-start;
}
.sale-item {
  display: flex;        /* Lay out each item using flex layout */
  flex-flow: column;    /* Lay out item’s contents vertically  */
  align-items: flex-start;
  padding: 10px;
  border: 2px dashed white;
  border-radius: 5px;
  /* justify-content: space-evenly; */
  /* flex: 1 1 0; */
}
.sale-item > img {
  order: -1;            /* Shift image before other content (in visual order) */
  align-self: center;   /* Center the image cross-wise (horizontally)         */
}
.sale-item > button {
  margin-top: auto;     /* Auto top margin pushes button to bottom */
}


* {
  box-sizing: border-box;
}

/* body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  margin: 0;
  font-family: sans-serif;
  line-height: 1.5;
  background-color: #f9f9fd;
} */

main {
  flex-grow: 1;
}

.page-header {
  display: flex;
  align-items: center;
  padding: 10px 20px;
  background-color: #2196f3;
}

.page-header__logo {
  margin-right: 50px;
}

.logo {
  display: inline-flex;
  border: 1px solid #fff;
  border-radius: 4px;
  padding: 10px;
  text-decoration: none;
  color: #fff;
  text-transform: uppercase;
}

.nav {
  padding: 0;
  margin: 0;
  list-style: none;
  display: flex;
}

.nav__item:not(:last-child) {
  margin-right: 10px;
}

.nav__link {
  display: block;
  padding: 15px 30px;
  border: 1px solid #fff;
  border-radius: 4px;
  text-decoration: none;
  color: #fff;
}

.page-footer {
  display: flex;
  justify-content: flex-end;
  padding: 20px;
  background-color: #607d8b;
}

* {
  box-sizing: border-box;
}

body {
  /* margin: 0;
  padding-left: 15px;
  padding-right: 15px;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: sans-serif;
  line-height: 1.5; */
  background-color: #607d8b;
}

.card {
  max-width: 480px;
  padding: 16px;
  border-radius: 4px;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  /*  Example styles  */
  margin-left: auto;
  margin-right: auto;
}

.card__title {
  margin: 0;
}

.card__link {
  display: inline-flex;
  align-items: center;
  padding: 10px 25px;
  border-radius: 4px;
  text-decoration: none;
  color: #fff;
  background-color: #1976d2;
  box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2),
    0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
  transition: background-color 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

.card__link:hover {
  text-decoration: underline;
}

.card__link::before {
  content: "";
  display: inline-flex;
  width: 24px;
  height: 24px;
  margin-right: 10px;
  background-image: url(https://www.flaticon.com/svg/static/icons/svg/321/321834.svg);
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
  transition: transform 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

/* Nested selectors */
.card:hover .card__link {
  background-color: #388e3c;
}

.card:hover .card__link::before {
  transform: rotate(180deg);
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