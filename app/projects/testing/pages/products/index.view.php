<div class="w-4/5 m-auto text-center">
    <div class="py-10 border-b border-gray-200">
        <h1 class="text-5xl">
            Blog Posts
        </h1>
    </div>
</div>
<? 
if( Session::has('message')) { ?>
    <div class="w-4/5 m-auto mt-10 pl-2">
        <p class="w-3/6 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4 px-8">
            <?= Session::say('message')?>
        </p>
    </div>
<? } ?>

<div class="pt-10 w-4/5 m-auto">
    <a class="bg-blue-500 uppercase text-gray-100 text-xs font-extrabold py-3 px-8 rounded-3xl"
    href="<?path('blog.post-create') ?>">Create New Post</a>
</div>

<? foreach($posts as $post) : ?>

<div class="sm:grid grid-cols-3 gap-20 w-4/5 mx-auto py-10 border-b border-gray-200">
    <div class="">
        <img style="max-height:200px;" src="<?= '/images/'.$post['image_path'] ?>" alt="<?= $post['title'] ?>">
    </div>
    <div class="col-span-2">
        <h2 class="text-gray-700 font-bold text-3xl pb-4">
            <?= $post['title'] ?>
        </h2>
        <span class="text-gray-500">
            By <span class="font-bold italic text-gray-800">Quickvoice with <?= User::Name( $post['user_id']) ?></span>, Created on <?= date('jS M Y', strtotime( $post['created_at'])) ?>
        </span>
        <p class="text-xl text-gray-700 pt-8 pb-10 leading-8 font-light">
            <?= TruncateSafe($post['description'], 200, '...') ?>
        </p>
        <a class="bg-blue-500 uppercase text-gray-50 text-xs font-extrabold py-3 px-8 rounded-3xl"
        href="<?path('blog.post-show',['slug'=> $post['slug']]) ?>">Keep reading</a>

        <span class="float-right">
            <a href="<?path('blog.post-edit',['id'=> $post['id'] ]) ?>" 
            class="text-gray-700 italic hover:text-blue-600 hover:no-underline pb-1 border-b-2">
                Edit
            </a>
        </span>
        <span class="float-right">
            <form action="<?path('blog.post-delete',['id' => $post['id'] ]) ?>" method="post">
            <?= csrf() ?>
            <?= method('delete') ?>
                <button class="text-red-500 pr-3" type="submit">
                Delete
                </button>
            </form>
        </span>
    </div>
</div>
<? endforeach ?>