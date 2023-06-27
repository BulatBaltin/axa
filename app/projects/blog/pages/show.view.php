<div class="w-80 m-auto text-left">
    <div class="py-10">
        <h1 class="text-4xl">
            <?= $post['title'] ?>
        </h1>
    </div>
</div>
<div class="grid grid-cols-3 gap-10 w-80 mx-auto py-10">
    <div class="">
        <img style="max-width:100%;" src="<?= '/images/'.$post['image_path'] ?>" alt="<?= $post['title'] ?>">
    </div>
    <div class="col-span-2">
        <span class="text-gray-500">
            By <span class="font-bold italic text-gray-700">Quickvoice with <?= User::Name( $post['user_id']) ?></span>, Created on <?= date('jS M Y', strtotime( $post['created_at'])) ?>  
            
            <span class="float-right">
            <a href="<?path('blog') ?>" 
            class="text-green-700 italic hover:text-blue-500 hover:no-underline">
                Back to Blog &rarr;
            </a>
            </span>
        </span>

        <p style="white-space: pre-line" class="text-xl text-gray-700 pt-5 pb-10 leading-8 font-light">
            <?= $post['description'] ?>
        </p>

        <div>
            <span class="float-right">
                <form action="<?path('blog.post-delete',['id' => $post['id'] ]) ?>" method="post">
                <?= csrf() ?>
                <?= method('delete') ?>
                    <button class="btn-no-border bg-transparent cursor-pointer text-red-500 mr-5 px-3 ml-5" type="submit">
                    Delete
                    </button>
                </form>
            </span>
            <span class="float-right  mr-5">
                <a href="<?path('blog.post-edit',['id'=> $post['id'] ]) ?>" 
                class="bg-green-500 text-gray-700 italic hover:text-blue-600 hover:no-underline rounded p-3">
                    Edit
                </a>
            </span>
        </div>
    </div>
</div>
