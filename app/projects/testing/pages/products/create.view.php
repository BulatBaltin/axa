<div class="w-4/5 m-auto text-left">
    <div class="py-10">
        <h1 class="text-5xl">
            Create product
        </h1>
    </div>
</div>
<div class="w-4/5 m-auto">
    <form action="<?path('product-store',['slug'=> 'new-product']) ?>" method="POST" enctype="multipart/form-data">
    <?= csrf() ?>

    <input 
        type="text"
        name="title"
        placeholder="Title ..."
        class="bg-transparent block border-b-2 w-full h-20 text-4xl outline-none">
    <textarea name="description"
        placeholder="Description ..."
        class="bg-gray-50 py-20 block border-b-2 w-full h-20 text-2xl outline-none">
        </textarea>

        <? include(PARTIALS .'image-preview.view.php') ?>

        <button type="submit"
        class="bg-blue-500 uppercase text-gray-50 text-xs font-extrabold my-5 py-3 px-8 rounded-3xl"
        >
            Submit product
        </button>
    </form>
</div>

<? HTML::LinkLocalJS('app/blog/image.view.js') ?>
