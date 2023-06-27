
<div id='main-banner'>
<div style="background-image: url('/images/home_bg05.jpg');" class="background-image mt-auto">
<!-- <img src="/images/home_bg.jpg" alt="Not found"> -->
    <div class="flex text-gray-100 pt-10">
        <div class="ml-5 pt-5 pl-10 pr-5 text-left" 
style="height:350px; background-color: rgba(0,150,255,0.4);">

            <h1 class="text-white text-3xl uppercase font-bold pb-10">
                <?= $project ?>
            </h1>
            <h2 class="text-white text-lg uppercase font-bold pb-3">
                <?= $tagline ?>
            </h2>
            <h3 class="text-yellow text-lg uppercase font-bold pb-3">
                <?= $subtitle ?>
            </h3>
            <div style="width: 200px;height:5px;background-color: yellow;margin-bottom:3rem;">
            </div>
            <div>
                <a href="<? path('blog')?>" class="uppercase bg-blue-500 text-gray-100 text-base font-extrabold py-3 px-8 rounded-3xl mr-3">Read More</a>
                <a href="/dashboard" class="uppercase bg-blue-500 text-gray-100 text-base font-extrabold py-3 px-8 rounded-3xl ml-3">Dashboard</a>
            </div>
        </div>

        <div class="" style="font-size:1rem;margin-top:-3rem;padding:none;margin-left:33rem;">
<div  style="font-style: italic;font-weight: bold;text-align: right;color:#ccc;">Wisdom of the day</div>
<div class="text-gray-700 leading-8 font-light" style="color:yellow;">

<svg style='height: 0.8rem; width: 1rem;margin-right:0.5rem;margin-bottom:5px;'>
    <use fill="yellow" xlink:href="/images/icons/sprite2.svg#quote-left"></use>
</svg>
<?=$wisdom?>
<svg style='height: 0.8rem; width: 1rem;margin-left:0.5rem;margin-bottom:5px;'>
    <use fill="yellow" xlink:href="/images/icons/sprite2.svg#quote-right"></use>
</svg>
</div>
        </div>
    </div>
</div>
<div class="mt-5 grid grid-cols-2 gap-20 mx-auto py-10" style="max-width: 80%;">
    <div>
        <img src="/images/hummingbird.jpg" alt="hummingbird.jpg" style="max-width: 100%;">
    </div>
    <div class="m-auto text-left block">
        <h2 class="text-3xl font-extrabold text-gray-600">
            You have to run twice as fast
        </h2>
        <p class="py-8 text-gray-500 text-sm">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Dignissimos velit fugit, quod vitae sit repellendus eligendi veritatis aperiam architecto error enim dolores porro assumenda? Numquam, reprehenderit earum. Magni, sint consectetur.
        </p>
        <p class="font-extrabold text-gray-600 text-sm pb-10">
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. At similique unde quidem ipsum qui inventore veritatis. Numquam autem aspernatur
        </p>
        <a href="/blog" style="margin-top:3rem;"
        class="uppercase bg-blue-500 text-gray-100 text-base font-extrabold py-3 px-8 rounded-3xl">Find out more</a>
    </div>
</div>
<div style="position: relative; overflow: hidden; height:100px;">
<div class="bg-gray-700" style="position: absolute; top:40px; left:-20px; width: 110%; height:200px; transform: rotate(-3deg);">
</div>
</div>
<div class="text-center p-10 bg-gray-700 text-white">
    <h2 class="text-2xl pb-2">
        We are experts in ...
    </h2>
    <span class="font-bold block text-2xl py-2 text-gray-400">
        Project development 
    </span>
    <span class="font-bold block text-2xl py-2 text-gray-400">
        Web Design
    </span>
    <span class="font-bold block text-2xl py-2 text-gray-400">
        PHP frameworks, Laravel, Symfony, Dlight
    </span>
    <span class="font-bold block text-2xl py-2 text-gray-400">
        Administrative Panels, Wordpress, Laravel Nova
    </span>
</div>
<div class="text-center py-10">
    <span class="uppercase text-xl font-bold text-gray-400">
        Blog
    </span>
    <h2 class="text-2xl font-bold py-10">
        Recent post
    </h2>
    <!-- <p class="m-auto text-gray-500">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis, sunt ipsa nulla necessitatibus, nostrum aliquam qui temporibus consequatur totam, consequuntur natus autem quam. Repudiandae debitis, iure id veritatis eos quos?
    </p> -->
</div>

<div class="grid grid-cols-2 mx-auto py-5 w-80">
    <div class="flex bg-yellow-700 text-gray-100 p-16">
        <div class="m-auto block">
            <span class="uppercase text-xl">
                <?= $post['title'] ?>
            </span>
            <h3 class="text-xl font-bold py-10">
                <?= TruncateSafe( $post['description'], 150, '...') ?>
            </h3>
            <a href="<? path('blog-last-post')?>" 
            class="uppercase border-white bg-transparent text-gray-100 text-xs font-extrabold py-3 px-8 rounded-3xl">
                Find out more
             </a>
        </div>
    </div>
    <div class="bg-gray-400">
        <img class="block"  src="/images/<?= $post['image_path'] ?>" alt="<?= $post['image_path'] ?>" style="object-fit:contain;max-height: 100%;max-width: 100%;">
    </div>

</div>
</div>