<?php
danupe()->view()->get('plugin-user', 'header');
?>
<!--Container-->
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">


        <?php dump($users); ?>

    </div>

</div>
<!--/container-->

<?php danupe()->view()->get('plugin-user', 'footer'); ?>