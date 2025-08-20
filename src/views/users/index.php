<?php
danupe()->view()->get('plugin-user', 'header');
?>
<div class="container w-full mx-auto">
    <?php danupe()->view()->get('plugin-user', 'pageTitle', ['title' => $title]); ?>
    <?php danupe()->view()->get('plugin-user', 'pageNavigation'); ?>
    <?php echo danupe()->table()
        ->setAjax(true)
        ->setUrl(danupe()->plugin('user', 'admin')->getPrefix() . '/users/table')
        ->setData($users) // initial headers
        ->setLinks(['edit' => ['icon'=>'fas fa-edit','key' => 'id', 'url' => '/' . danupe()->plugin('user', 'admin')->getPrefix() . '/users/edit/']])
        ->render(); ?>
</div>
<?php danupe()->view()->get('plugin-user', 'footer'); ?>