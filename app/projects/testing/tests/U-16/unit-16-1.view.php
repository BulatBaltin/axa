<h1>Адаптивная графика: плотность пикселей</h1>
<!-- !-- Image format from an image service.: https://picsum.photos/id/237/ширина/высота --> 
<img src="https://picsum.photos/id/237/320/240" srcset="https://picsum.photos/id/237/320/240 1x, https://picsum.photos/id/237/640/480 2x" alt="Cute puppy" width="320" height="240">

<div class="box"></div>

<!-- x1 -->
<img src="https://picsum.photos/id/237/320/240" alt="Cute puppy" width="320" height="240">

<!-- x2 -->
<img src="https://picsum.photos/id/237/640/480" alt="Cute puppy" width="320" height="240">

<!-- x3 -->
<img src="https://picsum.photos/id/237/960/720" alt="Cute puppy" width="320" height="240">

<div class="thumb">
  <img class="image" src="https://unsplash.it/960/480" alt="">
</div>

<h1>
Атрибут sizes
</h1>
<img
  srcset="photo-300.jpg 300w, photo-600.jpg 600w, photo-1200.jpg 1200w"
  sizes="(min-width: 900px) 600px, (min-width: 600px) 300px, 100vw"
  src="photo-300.jpg"
  alt="Описание изображения для всех версий"
/>

<h1>Picture</h1>
<div class="container">
  <div class="thumb">
    <picture>
      <source srcset="https://picsum.photos/id/237/400/600" media="(max-width: 600px)">
      <source srcset="https://picsum.photos/id/237/800/400" media="(min-width: 601px)">
      <img src="https://picsum.photos/id/237/300/200" alt="Cute puppy">
    </picture>
  </div>
  </div>

  <div class="container">
  <div class="thumb">
    <picture>
      <source srcset="https://picsum.photos/id/237/400/600 400w, https://picsum.photos/id/237/800/1200 800w" media="(max-width: 600px)" sizes="(min-width: 480px) 480px, 100vw">
      <source srcset="https://picsum.photos/id/237/800/400 800w, https://picsum.photos/id/237/1600/800 1600w" media="(min-width: 601px)" sizes="(min-width: 800px) 800px, 100vw">
      <img src="https://picsum.photos/id/237/300/200" alt="Cute puppy">
    </picture>
  </div>
  </div>

<style>
.thumb {
  max-width: 960px;
  min-width: 320px;
  margin: 0 auto;
}

img .image{
  display: block;
  max-width: 100%;
  height: auto;
}
/* 1x screens, default value, 320x240 image */
.box {
  width: 320px;
  height: 240px;
  background-image: url("https://picsum.photos/id/237/320/240");
  background-size: 320px 240px;
}

/* 2x screens, retina, 640x480 image */
@media screen and (min-device-pixel-ratio: 2),
  screen and (min-resolution: 192dpi),
  screen and (min-resolution: 2dppx) {
  .box {
    background-image: url("https://picsum.photos/id/237/640/480");
  }
}

body {
  color: #2a2a2a;
  line-height: 1.5;
  font-family: sans-serif;
}

img {
  display: block;
  max-width: 100%;
  height: auto;
}

.container {
  max-width: 1200px;
  padding-left: 15px;
  padding-right: 15px;
  margin-left: auto;
  margin-right: auto;
}

.thumb {
  display: flex;
  justify-content: center;
}

body {
  margin: 0;
  color: #2a2a2a;
  line-height: 1.5;
  font-family: sans-serif;
}

img {
  display: block;
  max-width: 100%;
  height: auto;
}

.container {
  max-width: 1200px;
  padding-left: 15px;
  padding-right: 15px;
  margin-left: auto;
  margin-right: auto;
}

.thumb {
  display: flex;
  justify-content: center;
}
</style>