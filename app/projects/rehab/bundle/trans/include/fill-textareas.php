<div class="row">
        <div class="col-md-12">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote" placeholder="Description" name="description-test" required><?= $description ?></textarea>
            </div>
        </div>
</div>


<? for($i = 0; $i < count($htmls); $i++) : if(!empty($htmls[$i])) : 
    ?>
    <div class="row">
        <div class="col-md-6">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote<?=$i?>" placeholder="Description" name="description[<?=$i?>]" required><?= $htmls[$i] ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div>
<!-- <label for="Description">Description</label> -->
<textarea type="text" class="form-control" id="summernote-trans<?=$i?>" placeholder="Description" name="description_trans[<?=$i?>]" required></textarea>
            </div>
        </div>
    </div>
<? endif; endfor?>

<script type="text/javascript"> 
$(document).ready(function(){
    $('#summernote').summernote();

    <? for($i = 0; $i < count($htmls); $i++) : if(!empty($htmls[$i])) : ?>
        $('#summernote<?=$i?>').summernote();
        $('#summernote-trans<?=$i?>').summernote();
    <? endif; endfor?>
    });
</script>    