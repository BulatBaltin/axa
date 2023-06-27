<div class='img-wrapper'>
    <div class='img-preview-box'>
        <div class="img-cancel-icon"><i class="fas fa-times"></i></div>
        <div class="img-preview">
            <? if(isset( $post )) : ?>
                <img id='image-id' src="<?= '/images/'.$post['image_path'] ?>" alt="<?= $post['title'] ?>">
            <? else :?>
                <img id='image-id' src="" alt="new image" ?>
            <? endif ?>
        </div>
        <div>
            <div class="img-icon"><i class="far fa-image"></i></div>
            <div class="img-text">Paste the image url below,<br/>to see a preview or download</div>
        </div>
    </div>
    <div class='input-data'>
        <div class="flex w-full border-gray-200" style="border-radius: 5px;">
            <input style="border: none;max-width: none;" type="text" name="image-file" id="file-to-upload" placeholder="Paste the image..."
            <? if(isset( $post )): ?>
            value="<?= '<post>'.$post['image_path'] ?>"
            <? endif ?>
            
            >

            <label for="submarine" style="border-radius: 0 5px 5px 0; border: 2px solid #eee;" class='px-2 m-0 cursor-pointer bg-gray-200'>
                <input id="submarine" type="file" name="input-name" hidden />
                <span style="line-height: 3rem;" class="text-3xl"><i class="far fa-image"></i>
                </span>
            </label>                    
        </div>
    </div>
</div>
