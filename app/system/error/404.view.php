<div class="w-4/5 p-10 text-center">
    <h1 class="p-10 text-5xl">404 Error</h1>
    <h2 class="text-3xl">
        Not found<br><br>
        <? if( is_array(ROUTER::cargo() ) ) {
            $cargo = ROUTER::cargo();
            foreach($cargo as $note) {
                echo $note . '<br>'; 
            }
        } ?><br>
    </h2>
</div>