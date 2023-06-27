<div class="w-4/5 m-auto text-left">
    <div class="py-10">
        <h1 class="text-6xl">
            <?= $post['title'] ?>
        </h1>
    </div>
</div>
<div class="sm:grid grid-cols-3 gap-0 w-4/5 mx-auto py-10 border-b border-gray-200">
    <div class="">
        <img style="max-height:300px;" src="<?= '/images/'.$post['image_path'] ?>" alt="<?= $post['title'] ?>">
    </div>
    <div class="m-auto col-span-2">
        <span class="text-gray-500">
            By <span class="font-bold italic text-gray-800">Quickvoice with <?= User::Name( $post['user_id']) ?></span>, Created on <?= date('jS M Y', strtotime( $post['created_at'])) ?>  
            
            <span class="float-right">
            <a href="<?path('blog') ?>" 
            class="text-green-700 italic hover:text-blue-500 hover:no-underline pb-1 border-b-2">
                Back to Blog
            </a>
        </span>
            

        </span>

        <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
            <?= $post['description'] ?>
        </p>

    </div>
</div>
