<h1>
Методология БЭМ (Блок, Элемент, Модификатор) создана в Яндексе
</h1>
<h2>
Блок
</h2>
<p>
Блок
Функционально независимый компонент, который может быть использован повторно. Блок можно поставить в другую часть страницы или проекта, и он будет иметь смысл. Например, блоком может быть галерея, статья, шапка, форма, виджет сайдбара, сам сайдбар, навигация и т. д.

Имя класса блока:

Может состоять только из латинских букв, цифр и тире.
Должно отвечать на вопрос «Что это?» - widget, gallery, navigation, post.
Не должно отвечать на вопрос «Как выглядит?» - red-text, round-button и т. п.    
</p>
<h2>
Элемент
</h2>
<p>
Составная часть блока, которая не имеет смысла и не может использоваться отдельно от него.
</p>
<p>
<br>Обязательно формируется по схеме блок__элемент. Имя блока задаёт пространство имён, которое гарантирует зависимость его элементов.
<br>Должно отвечать на вопрос «Что это?», например блок__item, блок__title, блок__link, блок__image и т. п.
<br>Не должно отвечать на вопрос «Как выглядит?», например блок__big-link, блок__blue-text, блок__round-button и т. п.
</p>
<h2>
Модификатор
</h2>
<p>
Дополнительный класс-модификатор определяющий изменение внешнего вида, состояния или поведения блока либо элемента.
</p>
<p>
Должно быть простым, описывающим вносимое изменение.
Обязательно формируется по схеме блок--модификатор или блок__элемент--модификатор.
</p>

<div class="alert">You have new unread messages.</div>
<div class="alert alert--success">Transaction completed successfully.</div>
<div class="alert alert--error">Transaction error.</div>
<div class="alert alert--warning">The site is undergoing maintenance.</div>

<!-- SVG sprite with one icon to avoid repeating its markup -->
<svg aria-hidden="true" style="position:absolute;width:0;height:0" xmlns="http://www.w3.org/2000/svg" overflow="hidden"><defs><symbol id="cart" viewBox="0 0 32 32"><path fill="var(--color1, #455a64)" d="M29.217 27.826a3.478 3.478 0 11-6.956 0 3.478 3.478 0 016.956 0zM15.304 27.826a3.478 3.478 0 11-6.956 0 3.478 3.478 0 016.956 0z"/><path fill="var(--color2, #ffc107)" d="M31.826 5.105a.696.696 0 00-.521-.235H6.262a.696.696 0 00-.682.834l2.783 13.913c.067.32.347.556.682.556a.706.706 0 00.092 0l20.869-2.783a.698.698 0 00.598-.6v-.003l1.391-11.13a.69.69 0 00-.169-.553l.001.001z"/><path fill="var(--color3, #fafafa)" d="M11.826 17.391a.695.695 0 01-.685-.577l-.001-.004-1.391-8.348a.695.695 0 011.371-.233l.001.004 1.391 8.348a.695.695 0 01-.686.81zm3.478-.695h-.003a.696.696 0 01-.693-.63v-.003l-.696-7.652a.696.696 0 01.627-.758l.006-.001a.695.695 0 01.755.63l.696 7.652a.695.695 0 01-.63.755l-.063.006zM18.782 16a.696.696 0 01-.696-.696V8.348a.696.696 0 111.392 0v6.956a.696.696 0 01-.696.696zm3.479-.696h-.078a.696.696 0 01-.619-.765l.001-.007.696-6.261a.705.705 0 01.772-.619.696.696 0 01.615.768l-.696 6.261a.696.696 0 01-.691.623zm3.478-.695a.696.696 0 01-.673-.869l-.001.005 1.391-5.565a.696.696 0 011.357.305l-.009.036.001-.005-1.391 5.565a.697.697 0 01-.675.527z"/><path fill="var(--color1, #455a64)" d="M28.521 22.956H12.464a4.884 4.884 0 01-4.775-3.914L4.298 2.086H.695a.696.696 0 110-1.392h4.174c.335 0 .615.237.681.552l.001.005 3.503 17.516a3.487 3.487 0 003.41 2.796h16.057a.696.696 0 110 1.392z"/></symbol></defs></svg>

<button type="button" class="button">
  <svg class="button__icon button__icon--start" width="20" height="20">
    <use href="#cart"></use>
  </svg>
  <span class="button__label">Add to cart</span>
</button>

<button type="button" class="button">
  <span class="button__label">Add to cart</span>
  <svg class="button__icon button__icon--end" width="20" height="20">
    <use href="#cart"></use>
  </svg>
</button>

<button type="button" class="button">
  <span class="button__label">Add to cart</span>
</button>

<button type="button" class="button" aria-label="Add to cart">
  <svg class="button__icon" width="20" height="20">
    <use href="#cart"></use>
  </svg>
</button>

<style>
body {
  font-family: sans-serif;
  background-color: #f9f9fd;
}

/* Base styles  */
.alert {
  max-width: 400px;
  border-radius: 4px;
  padding: 20px;
  font-size: 16px;
  color: #2a2a2a;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  /*  Example styles  */
  margin: 10px;
}

/* Modifiers */
.alert--success {
  background-color: #388e3c;
  color: #fff;
}

.alert--error {
  background-color: #f44336;
  color: #fff;
}

.alert--warning {
  background-color: #ffc107;
}

/* * {
  box-sizing: border-box;
}

body {
  margin: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f9f9fd;
} */

.button {
  display: inline-flex;
  flex-shrink: 0;
  align-items: center;
  padding: 10px 20px;
  border: none;
  margin: 5px;
  border-radius: 4px;
  font-family: sans-serif;
  font-size: 16px;
  box-shadow: 0px 3px 1px -2px rgba(0, 0, 0, 0.2),
    0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
}

.button__icon {
  display: inline-flex;
}

.button__icon--start {
  margin-right: 10px;
}

.button__icon--end {
  margin-left: 10px;
}
</style>
