<!-- https://freefrontend.com/css-dropdown-menus/ -->
<div>
<h2>Привет new php features!</h2>
</div>

<style>
.send-sms {
  width: 10rem;
  height: 3rem;
  border-radius: 6px;
  background-color: whitesmoke;
  overflow: hidden;
  box-shadow: 0px 3px 1px -1px rgba(0, 0, 0, 0.2),
    0px 1px 1px 0px rgba(0, 0, 0, 0.14), 0px 1px 3px 0px rgba(0, 0, 0, 0.12);
}
</style>

<div style="margin: 1rem;">
  <button class="send-sms" id='send-sms'>
    Send SMS
  </button>
</div>
<div id='sms-box'style="margin: 1rem;">
  <textarea name="sms-text" id="sms-text" cols="30" rows="10"></textarea>
</div>
<div id='sms-result'style="margin: 1rem;">

</div>

<div>
<?

$arg = 'bar';
byVal($arg);
byRef($arg);

?>
</div>
<?
f3dot(1);
f3dot(1, 2);
f3dot(1, 2, 3);
f3dot(1, 2, 3, 4);
f3dot(1, 2, 3, 4, 5);

?>

<style>
:root {
  --button-background: dodgerblue;
  --button-color: white;
  
  --dropdown-highlight: dodgerblue;
  --dropdown-width: 260px;
  --dropdown-background: white;
  --dropdown-color: black;
}
/* Center the planet */
.body-box {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 20vh;
  background-color: #222229;
}

/* Boring button styles */
a.button {
  /* Frame */
  display: inline-block;
  padding: 20px 28px;
  border-radius: 50px;
  box-sizing: border-box;
  
  /* Style */
  border: none;
  background: var(--button-background);
  color: var(--button-color);
  font-size: 24px;
  cursor: pointer;
  /* text-decoration: none; */
}

a.button:active {
  filter: brightness(75%);
}

/* Dropdown styles */
.dropdown {
  position: relative;
  padding: 0;
  margin-right: 1em;
  
  /* border: none; */
  border: 2 solid black;
}

.dropdown summary {
  list-style: none;
  list-style-type: none;
}

.dropdown > summary::-webkit-details-marker {
  display: none;
}

.dropdown summary:focus {
  outline: none;
}

.dropdown summary:focus a.button {
  border: 2px solid green;
}

.dropdown summary:focus {
  outline: none;
}

.dropdown ul {
  position: absolute;
  margin: 20px 0 0 0;
  padding: 20px 0;
  width: var(--dropdown-width);
  left: 50%;
  margin-left: calc((var(--dropdown-width) / 2)  * -1);
  box-sizing: border-box;
  z-index: 200;
  
  background: var(--dropdown-background);
  border-radius: 6px;
  list-style: none;
}

.dropdown ul li {
  padding: 0;
  margin: 0;
}

.dropdown ul li a:link, .dropdown ul li a:visited {
  display: inline-block;
  padding: 10px 0.8rem;
  width: 100%;
  box-sizing: border-box;
  
  color: var(--dropdown-color);
  text-decoration: none;
}

.dropdown ul li a:hover {
  background-color: var(--dropdown-highlight);
  color: var(--dropdown-background);
}

/* Dropdown triangle */
.dropdown ul::before {
  content: ' ';
  position: absolute;
  width: 0;
  height: 0;
  top: -10px;
  left: 50%;
  margin-left: -10px;
  border-style: solid;
  border-width: 10px 10px 10px 0px;
  /* border-color: transparent var(--dropdown-background) transparent transparent; */
  border-color: transparent red transparent transparent;
}


/* Close the dropdown with outside clicks */
.dropdown > summary::before {
  display: none;
}

.dropdown[open] > summary::before {
    content: ' ';
    display: block;
    position: fixed;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    z-index: 100;
}

</style>
<div class="controls body-box">

    <details class="dropdown" onclick="this.classList.toggle('active');">
        <summary role="button">
        <a class="button a-button">Covered and heated?</a>
        </summary>
        <ul>
        <li><a href="#">Yes please</a></li>
        <li><a href="#">No thanks</a></li>
        </ul>
    </details>

</div>

<style>
.html-body{
   padding:0px;
   margin:0px;
   background:#191A1D;
   font-family: 'Karla', sans-serif;
   width:100vw;
}
body * {
   margin:0;
   padding:0;
}

/* HTML Nav Styles */
/* HTML Nav Styles */
/* HTML Nav Styles */
nav menuitem {
   position:relative;
   display:block;
   opacity:0;
   cursor:pointer;
}

nav menuitem > menu {
   position: absolute;
   pointer-events:none;
}
nav > menu { display:flex; }

nav > menu > menuitem { pointer-events: all; opacity:1; }
menu menuitem a { white-space:nowrap; display:block; }
   
menuitem:hover > menu {
   pointer-events:initial;
}
menuitem:hover > menu > menuitem,
menu:hover > menuitem{
   opacity:1;
}
nav > menu > menuitem menuitem menu {
   transform:translateX(100%);
   top:0; right:0;
}
/* User Styles Below Not Required */
/* User Styles Below Not Required */
/* User Styles Below Not Required */

nav { 
   margin-top: 40px;
   margin-left: 40px;
}

nav a {
   background:#75F;
   color:#FFF;
   min-width:190px;
   transition: background 0.5s, color 0.5s, transform 0.5s;
   margin:0px 6px 6px 0px;
   padding:20px 40px;
   box-sizing:border-box;
   border-radius:3px;
   box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
   position:relative;
}

nav a:hover:before {
   content: '';
   top:0;left:0;
   position:absolute;
   background:rgba(0, 0, 0, 0.2);
   width:100%;
   height:100%;
}

nav > menu > menuitem > a + menu:after{
   content: '';
   position:absolute;
   border:10px solid transparent;
   border-top: 10px solid white;
   left:12px;
   top: -40px;  
}
nav menuitem > menu > menuitem > a + menu:after{ 
   content: '';
   position:absolute;
   border:10px solid transparent;
   border-left: 10px solid white;
   top: 20px;
   left:-180px;
   transition: opacity 0.6, transform 0s;
}

nav > menu > menuitem > menu > menuitem{
   transition: transform 0.6s, opacity 0.6s;
   transform:translateY(150%);
   opacity:0;
}
nav > menu > menuitem:hover > menu > menuitem,
nav > menu > menuitem.hover > menu > menuitem{
   transform:translateY(0%);
   opacity: 1;
}

menuitem > menu > menuitem > menu > menuitem{
   transition: transform 0.6s, opacity 0.6s;
   transform:translateX(195px) translateY(0%);
   opacity: 0;
} 
menuitem > menu > menuitem:hover > menu > menuitem,  
menuitem > menu > menuitem.hover > menu > menuitem{  
   transform:translateX(0) translateY(0%);
   opacity: 1;
}

</style>


<div class='html-body'>

<nav>
		<menu>
			<menuitem id="demo1">
				<a>drop</a>
				<menu>
					<menuitem><a>about</a></menuitem>
               <menuitem>
                  <a>settings</a>
                  <menu>
                     <menuitem><a>Test 1</a></menuitem>
                     <menuitem><a>Test 2</a></menuitem>
                     <menuitem><a>Test 3</a></menuitem>
                     <menuitem><a>Test 4</a></menuitem>
                  </menu>  
               </menuitem>
					<menuitem><a>help</a></menuitem>
					<menuitem id="demo2">
						<a>more</a>
						<menu>
							<menuitem id="demo3">
								<a>deeper</a>
								<menu>
									<menuitem><a>deep 1</a></menuitem>
									<menuitem><a>deep 2</a></menuitem>
									<menuitem><a>deep 3</a></menuitem>
								</menu>
							</menuitem>
							<menuitem><a>test</a></menuitem>
						</menu>
					</menuitem>
				</menu>
			</menuitem>
         <menuitem><a>no drop</a></menuitem>
		</menu>
	</nav>
</div>

<style>
.body-2 {
  background: #4AA6FB;
  display: flex;
  font-family: sans-serif;
  justify-content: center;
  margin: 0;
}
.dots {
  display: flex;
  margin-top: 30px;
  padding: 10px;
}
.cut {
  clip-path: polygon(49.94543% 0%, 49.146605% 0.56499168%, 47.908524% 1.8619327%, 46.53612% 3.2937721%, 45.334324% 4.2634587%, 44.449473% 4.6785326%, 43.75% 4.8902239%, 43.123985% 4.967017%, 42.459505% 4.9773959%, 32.434877% 4.9773959%, 22.41025% 4.9773959%, 12.385622% 4.9773959%, 2.3609941% 4.9773959%, 1.7494639% 5.0755373%, 0.9648305% 5.3952797%, 0.28803037% 5.9746007%, 0% 6.8514776%, 0% 29.608196%, 0% 52.364914%, 0% 75.121632%, 0% 97.87835%, 0.17916238% 98.658483%, 0.67451585% 99.313006%, 1.4228599% 99.763343%, 2.3609941% 99.930917%, 25.989505% 99.930917%, 49.618015% 99.930917%, 73.246526% 99.930917%, 96.875036% 99.930917%, 97.979739% 99.839309%, 98.960507% 99.515581%, 99.662509% 98.886379%, 99.930917% 97.87835%, 99.930917% 75.233185%, 99.930917% 52.588019%, 99.930917% 29.942854%, 99.930917% 7.2976888%, 99.75287% 6.3432143%, 99.283323% 5.6113835%, 98.619164% 5.1426321%, 97.857283% 4.9773959%, 87.768866% 4.9773959%, 77.680448% 4.9773959%, 67.592031% 4.9773959%, 57.503614% 4.9773959%, 56.936197% 4.9640164%, 56.17412% 4.8766449%, 55.305914% 4.6444314%, 54.420113% 4.1965263%, 53.323874% 3.214925%, 51.989005% 1.8085795%, 50.75102% 0.54707587%);
}
.cut2 {
  clip-path: polygon(49.94543% 0%, 49.631999% 0.12564846%, 49.187804% 0.4688613%, 48.640661% 0.97903993%, 48.018387% 1.605585%, 47.3488% 2.2978983%, 46.659716% 3.0053809%, 45.978952% 3.6774339%, 45.334324% 4.2634587%, 42.618384% 6.7500473%, 39.935164% 8.743094%, 37.227225% 10.296864%, 34.437125% 11.465622%, 31.507425% 12.303633%, 28.380682% 12.865161%, 24.999456% 13.204473%, 21.306307% 13.375833%, 18.127097% 13.266869%, 14.650937% 13.191619%, 11.100005% 13.527542%, 7.6964784% 14.652097%, 4.6625364% 16.942746%, 2.2203573% 20.776948%, 0.5921189% 26.532164%, 0% 34.585852%, 0% 39.201516%, 0% 43.81718%, 0% 48.432844%, 0% 53.048507%, 0% 57.664171%, 0% 62.279835%, 0% 66.895499%, 0% 71.511163%, 0.37122067% 75.655781%, 1.506588% 80.247442%, 3.4386599% 84.97803%, 6.1999946% 89.539433%, 9.8231496% 93.623537%, 14.340684% 96.922228%, 19.785154% 99.127392%, 26.189119% 99.930917%, 33.206023% 99.598265%, 38.745175% 98.670068%, 43.261202% 97.250968%, 47.208726% 95.445606%, 51.042372% 93.358623%, 55.216765% 91.094659%, 60.186528% 88.758356%, 66.406286% 86.454354%, 72.757944% 85.114156%, 78.860888% 84.911615%, 84.53075% 85.376904%, 89.58316% 86.040195%, 93.833751% 86.431657%, 97.098153% 86.081462%, 99.191998% 84.519782%, 99.930917% 81.276787%, 99.930917% 74.373149%, 99.930917% 67.469512%, 99.930917% 60.565874%, 99.930917% 53.662237%, 99.930917% 46.7586%, 99.930917% 39.854963%, 99.930917% 32.951325%, 99.930917% 26.047688%, 99.483948% 23.602291%, 98.249148% 21.274547%, 96.385677% 19.128688%, 94.052694% 17.228949%, 91.409359% 15.639561%, 88.614834% 14.424756%, 85.828276% 13.648769%, 83.208846% 13.375833%, 79.780489% 13.234012%, 76.02116% 12.843221%, 72.072026% 12.184289%, 68.074254% 11.238045%, 64.16901% 9.9853175%, 60.497461% 8.4069355%, 57.200773% 6.4837289%, 54.420113% 4.1965263%, 53.612432% 3.3746811%, 52.867835% 2.5981691%, 52.190258% 1.8867921%, 51.583637% 1.260352%, 51.051908% 0.73865107%, 50.599007% 0.34149057%, 50.228869% 0%);
}
.container {
  display: flex;
  height: 400px;
  justify-content: center;
  left: 50%;
  overflow: hidden;
  position: absolute;
  transform: translateX(-50%);
  transition: transform 300ms cubic-bezier(0.4, 0.0, 0.2, 1);;
  width: 325px;
}
.dot {
  background: #fff;
  border-radius: 50%;
  height: 10px;
  margin-right: 5px;
  width: 10px;
}
.dot:last-child {
  margin-right: 0;
}
.drop {
  background: #fff;
  border-radius: 1.2px;
  height: 5px;
  transform: translateY(5px);
  transition: transform 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
  width: 5px;
}
.shadow {
            background-image: url(data:image/png;base64,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RluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0JakgRluSCmK0Jakg9ev98ixnllTUOUIOxAwdAIGQr15UvnomALRAMzm9eZ2rJUlv0LRN9aWvNcOf61MaiTkScwYq6ty9gWvzWtHuz6DJ7SSygTjEGyDkwDw3ZDas9/7pV69GOzn97J+UpF9HvRfMy9nu/54B8xwIeTpwjVQZoKLJDbNnjV5fyEtPjxxzJx9xOy84fO4Fz5gBMxr6UXdzZeQtSW+FDH3nZtvOzYZvza/9hQWHecHRKzXxpUbad7mbH0MYTzfMc+J8mB7JOVDlSMqBRQ6s85yQl5PfDzR576QkFaO5/HmGJvef7walc0KuiDkwy4GYIyEHqnzd9MgxdzLAR3ya4cELXYs3MD0yyxvWROrcT40wfAzDHzLMcl/oVZj8sy8/yxhxSTdVhmuyDfSNaxg6t+1aGOazxzlt6KeTZ8z32neXb/NjPnjhK/LK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);
  height: 440px;
  justify-content: center;
  left: 50%;
  opacity: 0;
  position: absolute;
  transform: translateX(-50%) translateY(4px);
  transition: opacity 150ms cubic-bezier(0.4, 0.0, 0.2, 1);
  width: 365px;
}
.list {
  left: 50%;
  position: absolute;
  transform: translateX(-50%);
  top: 120px;
  width: 325px;
}
.list ul {
  margin: 0;
  padding: 0;
}
.list li {
  align-items: center;
  border-bottom: 1px solid #bdbdbd;
  display: flex;
  font-size: 24px;
  height: 50px;
  margin-left: 40px;
  opacity: 0;
  list-style: none;
  transition: opacity 100ms cubic-bezier(0.4, 0.0, 0.2, 1);
  user-select: none;
  -moz-user-select: none;
}
.list li:hover {
  background: #f5f5f5;
}
.dots.active .container {
  transform: translateX(-50%) translateY(20px);
}
.dots.active .drop {
  transform: translateY(212px) scale(108);
}
.dots.active .list li {
  cursor: pointer;
  opacity: 1;
  transition: opacity 200ms 100ms cubic-bezier(0.4, 0.0, 0.2, 1);
}
.dots.active .list li:nth-child(2) {
  transition-delay: 130ms;
}
.dots.active .list li:nth-child(3) {
  transition-delay: 160ms;
}
.dots.active .list li:nth-child(4) {
  transition-delay: 190ms;
}
.dots.active .list li:nth-child(5) {
  transition-delay: 220ms;
}
.dots.active .shadow {
  opacity: 1;
  transition: opacity 150ms 150ms cubic-bezier(0.4, 0.0, 0.2, 1);
}
.cursor {
  -webkit-tap-highlight-color: transparent;
  cursor: pointer;
  height: 40px;
  position: absolute;
  top: 25px;
  width: 80px;
}

</style>

<!-- <div class='body-2'>

<div class="dots" onclick="this.classList.toggle('active');">
  <div class="dot"></div>
  <div class="dot"></div>
  <div class="shadow cut"></div>
  <div class="container cut">
    <div class="drop cut2"></div>
  </div>
  <div class="list">
    <ul>
      <li>
        Mark as read
      </li>
      <li>
        Flag as important
      </li>
    </ul>
  </div>
  <div class="dot"></div>
</div>
<div class="cursor"
     onclick="document.querySelector('.dots').classList.toggle('active');"></div>

</div> -->

<!-- Example 4 -->
<style>
.body-4 {background-color : #ededed; font-family : "Open Sans", sans-serif;}

h1 {padding: 40px; text-align: center; font-size: 1.5em;}

li a {text-decoration : none; color : #2d2f31;}


.body-4 nav {
  width : 300px; 
  background: #d9d9d9;
  margin : 0rem auto; 
}

.body-4 span {
  padding : 30px;
  background : #2d2f31; 
  color : white;
  font-size : 1.2em;
  font-variant : small-caps;
  cursor : pointer;
  display: block;
}

.body-4 span::after {
  float: right;
  right: 10%;
  content: "+";
}

.body-4 .slide {
  /* clear:both; */
  width:100%;
  height:0px;
  overflow: hidden;
  text-align: center;
  transition: height .4s ease;
}

.body-4 .slide li {padding : 30px;}

#touch {position: absolute; opacity: 0; height: 0px;}    

#touch:checked + .slide {height: 300px;} 

</style>

<div class='body-4' style="margin-top: 5rem;">
<h1>CSS Dropdown Menu</h1>

<nav>

  <label for="touch"><span>I can catch titre</span></label>               
  <input type="checkbox" id="touch"> 

  <ul class="slide">
    <li><a href="#">Lorem Ipsum</a></li> 
    <li><a href="#">Lorem Ipsum</a></li>
    <li><a href="#">Lorem Ipsum</a></li>
    <li><a href="#">Lorem Ipsum</a></li>
  </ul>

</nav> 
</div>

 <!-- child element -->
<style>
li > div {
  background-color: blue;
  color: white;
}
</style>
<ul>
    <li>
        <div>Searching algorithms</div> 
  
        <ul> 
            <li>Binary search</li> 
            <li>Linear search</li> 
        </ul>
    </li> 
  
    <li>
        <div>Sorting Algorithms</div> 
        <ul> 
            <li>Merge sort</li> 
            <li>Quick sort</li> 
        </ul>
    </li>
</ul>

<!-- sibling element -->
<style>
div + p {
  background-color: green;
  color: white;
}
</style>
<div>
  After it is a sibling
</div>
<p>
  I am a sibling
</p>


<script>

// For the thumbnail demo! :]

var count = 1
setTimeout(demo, 500)
setTimeout(demo, 700)
setTimeout(demo, 900)
setTimeout(reset, 2000)

setTimeout(demo, 2500)
setTimeout(demo, 2750)
setTimeout(demo, 3050)


var mousein = false
function demo() {
   if(mousein) return
   document.getElementById('demo' + count++)
      .classList.toggle('hover')
   
}

function demo2() {
   if(mousein) return
   document.getElementById('demo2')
      .classList.toggle('hover')
}

function reset() {
   count = 1
   var hovers = document.querySelectorAll('.hover')
   for(var i = 0; i < hovers.length; i++ ) {
      hovers[i].classList.remove('hover')
   }
}

document.addEventListener('mouseover', function() {
   mousein = true
   reset()
})

</script>
<script>
$(document).ready(function () {

  $('.send-sms').click( function() {
    // alert('SMS');
    $.post(
      "<?= path('bulkgate-sms-ajax') ?>",
      { 
        id: '1234', 
        smile: 'Smeilik', 
        sms_text: $('#sms-text').val()
      },
      function(response) {
        alert($('#sms-text').val()+'\n'+response['html']);
        $('#sms-result').html(response['html']);
      }
    , 'json');
  });  

});
</script>
