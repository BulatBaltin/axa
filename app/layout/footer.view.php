<footer id="footer" class="bg-gray-800 py-10 mt-20 text-left" >
    <div class="grid grid-cols-3 w-80 pt-3 m-auto">
        <div>
            <h3 class="text-l font-bold text-gray-100">
                Pages
            </h3> 
            <ul class="py-4 text-sm text-gray-400">
                <li class="pb-1"> <a href="/">Home</a> </li>
                <li class="pb-1"> <a href="/blog">Blog</a> </li>
                <li class="pb-1"> <a href="/login">Login</a> </li>
                <li class="pb-1"> <a href="/register">Register</a> </li>
            </ul>
        </div>
        <div>
            <h3 class="text-l font-bold text-gray-100">
                Find us
            </h3> 
            <ul class="py-4 text-sm text-gray-400">
                <li class="pb-1"> <a href="/">What we do</a> </li>
                <li class="pb-1"> <a href="/blog">Address</a> </li>
                <li class="pb-1"> <a href="/login">Phone</a> </li>
                <li class="pb-1"> <a href="/register">Contacts</a> </li>
            </ul>
        </div>
        <div>
            <h3 class="text-l font-bold text-gray-100">
                Latest posts
            </h3> 
            <ul class="py-4 text-sm text-gray-400">
                <li class="pb-1"> <a href="/">Why we love IT</a> </li>
                <li class="pb-1"> <a href="/blog">Why we love design</a> </li>
                <li class="pb-1"> <a href="/login">Why to use Delight</a> </li>
                <li class="pb-1"> <a href="/register">Why PHP is the best</a> </li>
            </ul>
        </div>
    </div>
    <p class="text-center w-80 pb-3 m-auto text-xs text-gray-400 pt-5">
    Copyright 2011 - <?= (new DateTime())->format('Y')?> 
    </p>
</footer>
