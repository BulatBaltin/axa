<style>
:root {
  --select-border: #777;
  --select-focus: blue;
  --select-arrow: var(--select-border);
}

*,*::before,*::after {
  box-sizing: border-box;
}
select {
  /* // A reset of styles, including removing the default dropdown arrow */
  appearance: none;
  /* // Additional resets for further consistency */
  background-color: transparent;
  border: none;
  padding: 0 1em 0 0;
  margin: 0;
  width: 100%;
  font-family: inherit;
  font-size: inherit;
  cursor: inherit;
  line-height: inherit;
  outline: none;
}

.select {
  width: 100%;
  min-width: 15ch;
  max-width: 30ch;
  border: 1px solid var(--select-border);
  border-radius: 0.25em;
  padding: 0.25em 0.5em;
  font-size: 1.25rem;
  cursor: pointer;
  line-height: 1.1;
  background-color: #fff;
  background-image: linear-gradient(to top, #f9f9f9, #fff 33%);
  display: grid;
  grid-template-areas: "select";
  align-items: center;
  position: relative;
}
.select::after {
  content: "";
  width: 0.8em;
  height: 0.5em;
  background-color: var(--select-arrow);
  clip-path: polygon(100% 0%, 0 0%, 50% 100%);
  justify-self: end;
}
select,
.select:after {
  grid-area: select;
}

select:focus+.focus {
  position: absolute;
  top: -1px;
  left: -1px;
  right: -1px;
  bottom: -1px;
  border: 2px solid var(--select-focus);
  border-radius: inherit;
}

</style>    

<div class="select" style="max-width: 20rem;margin-left: 3rem;margin-top:2rem;">
  <select id="standard-select">
    <option value="Option 1">Option 1</option>
    <option value="Option 2">Option 2</option>
    <option value="Option 3">Option 3</option>
    <option value="Option 4">Option 4</option>
    <option value="Option 5">Option 5</option>
    <option value="Option length">
      Option that has too long of a value to fit
    </option>
  </select>
  <span class="focus"></span>
</div>