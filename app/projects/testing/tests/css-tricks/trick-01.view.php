<!-- https://bennettfeely.com/clippy/ -->
<style>
  .body-box{
    background-color: red;
    background-blend-mode: screen;
    min-height: 500px;
    /* background-image: image('paris.jpg'); */
    /* background-image: url('paris.jpg'); */
    background-image: url(/images/paris.jpg);

    clip-path: polygon(100% 0, 100% 57%, 51% 100%, 0 100%, 0 0);
  }
</style>
<? $image = __DIR__.'/images/paris.jpg'; ?>
<? $image = 'https://picsum.photos/id/237/320/240'; ?>

<div class='body-box'>
Hi there
<br>

<? if(file_exists(__DIR__.'/images/paris.jpg')) { 
  echo "<br>I found it " . __DIR__.'/images/paris.jpg'; 
} else { 
  echo "<br>NO luck for " . __DIR__.'/images/paris.jpg'; 
}
?>

<?= __DIR__ ?>
</div>