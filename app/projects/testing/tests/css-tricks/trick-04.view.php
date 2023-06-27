<!-- https://www.youtube.com/watch?v=wfaDzSL6ll0 -->
<!-- https://bennettfeely.com/clippy/ -->
<style>
  .body-box{
    background-color: red;
    height: 300px;
    width: 100%;
    clip-path: polygon(100% 0, 100% 57%, 51% 100%, 0 100%, 0 0);
    position: absolute;
    z-index: -1;
  }
  .wrapper {
    max-width: 400px;
    margin-top: 5rem;
    margin-inline: auto;
    border: 3px solid oringe;
    background-color: yellow;
  }
  .wrapper > * {
    font-size: 2rem;
    padding: 1rem;
  }
  .header_primary {
    background-color: #555;
    color: #eee;
    /* display: grid; */
  }
  .flex-column {
    display: flex;
  }
  .flex-column > * {
    flex: 1 1 1;
  }

  .even-columns {
    display: grid;
    /* display: flex; */
    grid-template-columns: repeat(auto-fix, minmax(250px, 1fr));
    gap: 2rem;
  }
  .even-columns > :nth-child(2) {
    background-color: #888;
  }
</style>

<!-- <div class="flex-column"> -->
<div class="even-columns">

<div class="wrapper">
<div class="header_primary">
  My wrapper div
  Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus perspiciatis 
</div>

  <div>
    Hi there
  </div>
</div>

<div class="wrapper">
<div class="header_primary">
  My wrapper div
  Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus perspiciatis 
</div>

  <div>
    Hi there
  </div>
</div>

</div>
