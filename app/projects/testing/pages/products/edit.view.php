<div class="w-4/5 m-auto text-left">
    <div class="py-10">
        <h1 class="text-5xl">
            Edit Post
        </h1>
    </div>
</div>
<div class="w-4/5 m-auto">
    <form action="<?path('blog.post-update',['id'=> $post['id'] ]) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf() ?>
    <?= method('PUT') ?>

    <input 
        type="text"
        name="title"
        value="<?= $post['title']?>"
        class="bg-transparent block border-b-2 w-full h-20 text-4xl outline-none">
    <textarea name="description"
        class="py-3 bg-gray-50 block border-b-2 w-full h-60 text-2xl outline-none">
        <?= $post['description']?>
        </textarea>

        <? include(PARTIALS .'image-preview.view.php') ?>

        <button type="submit"
        class="bg-blue-500 uppercase text-gray-50 text-xs font-extrabold my-5 py-3 px-8 rounded-3xl"
        >
            Update Post
        </button>
    </form>

</div>

<? HTML::LinkLocalJS('app/blog/image.view.js') ?>

