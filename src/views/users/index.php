<?php
danupe()->view()->get('plugin-user', 'header');
?>
<div class="container w-full mx-auto">
    <?php danupe()->view()->get('plugin-user', 'pageTitle', ['title' => $title]); ?>
    <?php danupe()->view()->get('plugin-user', 'pageNavigation'); ?>
    <?php echo danupe()->table()->setData($users)->setLinks(['edit' => ['icon'=>'fas fa-edit','key' => 'id', 'url' => '/' . danupe()->plugin('user', 'admin')->getPrefix() . '/users/edit/']])->render(); ?>
</div>
<?php danupe()->view()->get('plugin-user', 'footer'); ?>