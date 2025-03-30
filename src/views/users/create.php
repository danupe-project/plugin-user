<?php danupe()->view()->get('plugin-user', 'header'); ?>
<?php danupe()->view()->get('plugin-user', 'pageTitle', ['title' => $title]); ?>
<?php danupe()->view()->get('plugin-user', 'alert'); ?>

<div class="mb-4">
    <a href='/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/users' class="btn btn-solid-secondary">Users</a>
</div>


<form method="POST" action="/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/users/create_post" class="grid grid-cols-1 md:grid-cols-2 gap-4">


    <?php echo danupe()->plugin('user', 'form')->csrf(); ?>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('email', 'Email Address'); ?>
        <?php echo danupe()->plugin('user', 'form')->input('email', '', danupe()->session()->old('email')); ?>
    </div>
    <div class="form-group">
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('password', 'Password'); ?>
        <?php echo danupe()->plugin('user', 'form')->password('password', '', danupe()->session()->old('password')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('password_confirmation', 'Confirm Password'); ?>
        <?php echo danupe()->plugin('user', 'form')->password('password_confirmation', '', danupe()->session()->old('password_confirmation')); ?>
    </div>

    <div class="form-group">
        <?php echo danupe()->plugin('user', 'form')->label('role', 'Role'); ?>
        <?php echo danupe()->plugin('user', 'form')->select('role', danupe()->plugin('user', 'role')->getAll(), danupe()->session()->old('role'), ['class' => 'form-select w-full']); ?>
    </div>

    <div></div> <!-- Empty div for alignment -->

    <?php echo danupe()->plugin('user', 'form')->submit(); ?>
</form>

<?php danupe()->view()->get('plugin-user', 'footer'); ?>