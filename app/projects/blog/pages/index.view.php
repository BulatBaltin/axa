<!-- <button id='click-ajax'>
Test ajax call
</button> -->

<div id="test-ajax">
</div>

<div class="w-80 m-auto text-center">
    <div class="py-5">
        <h1 class="text-4xl">
            Blog Posts
        </h1>
    </div>
</div>
<? 
if( Session::has('message')) { ?>
    <div class="w-80 m-auto mt-10 pl-2">
        <p class="w-50 mb-4 text-gray-50 bg-green-500 rounded-2xl py-4 px-8">
            <?= Session::say('message')?>
        </p>
    </div>
<? } ?>

<div class="pt-5 w-80 m-auto">
    <a class="bg-blue-500 uppercase text-gray-100 text-xs font-extrabold py-3 px-8 rounded-3xl"
    href="<?path('blog.post-create') ?>">Create New Post</a>
</div>

<? foreach($posts as $post) : ?>

<div class="grid grid-cols-3 gap-16 w-80 mx-auto py-10">
    <div class="">
        <img style="max-height:200px;max-width:100%;" src="<?= '/images/'.$post['image_path'] ?>" alt="<?= $post['title'] ?>">
    </div>
    <div class="col-span-2">
        <h2 class="text-gray-600 font-bold text-3xl pb-5">
            <?= $post['title'] ?>
        </h2>
        <span class="text-gray-500">
            By <span class="font-bold italic text-gray-800">Quickvoice with <?= User::Name( $post['user_id']) ?></span>, Created on <?= date('jS M Y', strtotime( $post['created_at'])) ?>
        </span>
        <p class="text-xl text-gray-700 pt-5 pb-10 leading-8 font-light">
            <?= TruncateSafe($post['description'], 200, '...') ?>
        </p>
        <a class="bg-blue-500 uppercase text-gray-50 text-xs font-extrabold py-3 px-8 rounded-3xl"
        href="<?path('blog.post-show',['slug'=> $post['slug']]) ?>">Keep reading</a>

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
            class="text-gray-700 italic hover:text-blue-600 hover:no-underline">
                Edit
            </a>
        </span>
    </div>
</div>
<? endforeach ?>

<script>
$(document).ready(
    function() {
        $('#click-ajax').click( function() {
            // alert('HERE');
            $.post( "<?path('blog.blog-ajax') ?>", 
            {'table_name': 'Ajax test', 'data': 567}, 
            function(data1, success) { 
                $('#test-ajax').html(data1);
                     
            });
            }
        );

    }
);
</script>