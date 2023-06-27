<div class="row">
        <div class="col-md-12">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote" placeholder="Description" name="description-test" required><?= $test ?></textarea>
            </div>
        </div>
</div>

<? if(count($description) > 0) :?>
<? foreach($description as $index => $text) : if(!empty($text)) : 
    ?>
    <div class="row">
        <div class="col-md-6">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote<?=$index?>" placeholder="Description" name="description[<?=$index?>]" required><?= $text ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote-trans<?=$index?>" placeholder="Description" name="description_trans[<?=$index?>]" required><?=$description_trans[$index] ?? ''?></textarea>
            </div>
        </div>
    </div>
<? endif; endforeach?>
<? endif ?>

<script type="text/javascript"> 
$(document).ready(function(){
    $('#summernote').summernote();

<? foreach($description as $index => $text) : if(!empty($text)) : ?>
        $('#summernote<?=$index?>').summernote();
        $('#summernote-trans<?=$index?>').summernote();
<? endif; endforeach?>
    });
</script>    