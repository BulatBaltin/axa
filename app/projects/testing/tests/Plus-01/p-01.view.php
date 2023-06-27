<h1>Animated text</h1>
<!-- https://codepen.io/kozyritsky/pen/JwqbdL -->
<div class="wrapper">
  <h1 class="title">Добавим немного магии</h1>
</div>
<br>
<p class="line-1 anim-typewriter">Animation typewriter style using css steps()

</p>
<style>
/* *{
  padding: 0;
  margin: 0;
} */

body{
  background: #042f36;
}
.wrapper{
  display: flex;
  flex-wrap: wrap;
  width: 100%;
  justify-content: center;
  margin-top: 5%;
}

.title{
  width: 21ch;
  overflow: hidden;
  color: white;
  font-size: 40px;
  font-family: monospace;
  white-space: nowrap;
  border-right: 4px solid orange;
  animation: printed-text 5s steps(21),
             flashin-border .75s step-start infinite
             ;
}

@keyframes flashin-border{
  0%{
    border-color: orange;
  }
  50%{
    border-color: transparent;
  }
  100%{
    border-color: orange;
  }
}

@keyframes printed-text{
  from {
    width: 0%;
  }
}
@keyframes printed-text-back{
  from {
    width: 100%;
  }
  to {
    width: 0%;
  }
}

/* Google Fonts */
@import url(https://fonts.googleapis.com/css?family=Anonymous+Pro);

/* Global */
html{
  min-height: 100%;
  overflow: hidden;
}
body{
  height: calc(100vh - 8em);
  padding: 4em;
  color: rgba(255,255,255,.75);
  font-family: 'Anonymous Pro', monospace;  
  background-color: rgb(25,25,25);  
}
.line-1{
    position: relative;
    top: 50%;  
    width: 24em;
    margin: 0 auto;
    border-right: 2px solid rgba(255,255,255,.75);
    font-size: 180%;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    transform: translateY(-50%);    
}

/* Animation */
.anim-typewriter{
  animation: typewriter 4s steps(44) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 24em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}

</style>