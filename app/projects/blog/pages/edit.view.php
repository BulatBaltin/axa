<div class="w-60 m-auto text-left">
    <div class="py-10">
        <h1 class="text-5xl">
            Edit Post
        </h1>
    </div>
</div>
<div class="w-60 m-auto">
<form action="<? path('blog.post-update',['id'=> $post['id'] ]) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf() ?>
    <?= method('PUT') ?>

    <input 
        type="text"
        name="title"
        value="<?= $post['title']?>"
        class="bg-transparent block w-full h-20 text-2xl mb-5"
        style='max-width: none;font-size: 1.25rem;'>

    <textarea name="description" class="p-3 w-full h-60 rounded text-xl"><?= $post['description']?></textarea>

    <? include('include/image-preview.view.php') ?>

    <button type="submit"
    class="cursor-pointer btn-no-border bg-blue-500 uppercase text-gray-50 text-xs font-extrabold py-3 px-8 rounded-3xl mt-5"
    >
        Update Post
    </button>

    <span class="float-right mt-5">
        <a href="<?path('blog') ?>" 
        class="text-green-700 italic hover:text-blue-500 hover:no-underline">
            Back to Blog &rarr;
        </a>
    </span>

</form>
</div>

<? HTML::LinkLocalJS('app/blog/image.view.js') ?>

