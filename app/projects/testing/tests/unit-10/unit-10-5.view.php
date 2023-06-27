<h1>Перспектива</h1>
<br>
<p>
Это еще одна функция трансформации для свойства transform, которая позволяет задать перспективу одному элементу, к которому применяется.
</p>
<p>
Задав perspective(400px) мы говорим браузеру о необходимости рендерить div.box в 3D-пространстве, добавляя элементу глубину сцены и объём. Значение 400px это расстояние до сцены, на которой находится элемент. Чем меньше значение, тем зритель ближе к сцене и наоборот.
</p>
<p>
Свойство perspective. Позволяет создать одинаковую перспективу целой группе элементов на сцене. Это свойство задаётся общему контейнеру группы элементов (сцене), в нашем случае div.scene.
</p>

<br>
<h2>Функция perspective()</h2>
<div class="container">
  <div class="scene">
    <div class="box rotate-x">rotateX(60deg)</div>
  </div>

  <div class="scene">
    <div class="box rotate-y">rotateY(60deg)</div>
  </div>
</div>

<div class="scene">
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
  <div class="box"></div>
</div>


<style>
/* body {
  font-family: "Open Sans", sans-serif;
  margin: 0;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  background-color: #f9f9fd;
} */

p {
  margin-bottom: 20px;
  font-size: 18px;
}

.scene {
  height: 200px;
  width: 200px;
  border: 2px solid black;
  border-radius: 4px;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}

.box {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  border-radius: 4px;
  color: white;
  font-size: 20px;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  /*   transition: transform 0.5s ease-in-out; */
}

.box.rotate-x {
  /*   transform: perspective(400px) rotateX(45deg); */
  animation: rotateX 1500ms infinite alternate ease-in-out 1000ms;
}

.box.rotate-y {
  /*   transform: perspective(400px) rotateY(45deg); */
  animation: rotateY 1500ms infinite alternate ease-in-out 1000ms;
}

.box.rotate-x {
  background-color: tomato;
}

.box.rotate-y {
  background-color: blue;
}

.scene + .scene {
  margin-left: 50px;
}

.container {
  display: flex;
}

@keyframes rotateX {
  0% {
    transform: perspective(400px) rotateX(0deg);
  }

  100% {
    transform: perspective(200px) rotateX(80deg);
  }
}

@keyframes rotateY {
  0% {
    transform: perspective(400px) rotateY(0deg);
  }

  100% {
    transform: perspective(400px) rotateY(60deg);
  }
}

/* =================== */

/* body {
  margin: 0;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #f9f9fd;
}
*/
.scene {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  width: 390px;
  border: 3px solid black;
  border-radius: 4px;
  margin: -10px;
  background-color: #fff;
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  /*  Set the perspective of the entire scene.  */
  perspective: 400px;
}

.box {
  flex-basis: 100px;
  height: 100px;
  margin: 10px;
  border-radius: 4px;
  transform: rotateY(45deg);
  box-shadow: 0px 2px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);

  animation: rotateY 3000ms infinite alternate backwards ease-in-out 1000ms;
}

.box:nth-child(1) {
  background-color: #f44336;
}

.box:nth-child(2) {
  background-color: #9c27b0;
}

.box:nth-child(3) {
  background-color: #3f51b5;
}

.box:nth-child(4) {
  background-color: #03a9f4;
}

.box:nth-child(5) {
  background-color: #009688;
}

.box:nth-child(6) {
  background-color: #4caf50;
}

.box:nth-child(7) {
  background-color: #ffc107;
}

.box:nth-child(8) {
  background-color: #795548;
}

.box:nth-child(9) {
  background-color: #e91e63;
}

@keyframes rotateY {
  0% {
    transform: perspective(400px) rotateY(60deg);
  }

  100% {
    transform: perspective(400px) rotateY(-60deg);
  }
}
</style>