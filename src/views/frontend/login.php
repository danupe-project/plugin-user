<?php danupe()->view()->get('plugin-user', '/frontend/header'); ?>
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">

    <?php echo danupe()->view()->get('plugin-user', 'alert'); ?>

    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <form action="/<?php echo danupe()->env()->get("DANUPE_ADMIN_PREFIX"); ?>/login_post" method="POST" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo danupe()->session()->get('csrf_token'); ?>">

        <div class="form-group">
            <?php echo danupe()->plugin('user', 'form')->label('email', 'Email'); ?>
            <?php echo danupe()->plugin('user', 'form')->input('email', '', danupe()->session()->old('email')); ?>
        </div>

        <div class="form-group">
            <?php echo danupe()->plugin('user', 'form')->label('password', 'Passwort'); ?>
            <?php echo danupe()->plugin('user', 'form')->password('password', '', danupe()->session()->old('password')); ?>
        </div>

        <?php echo danupe()->plugin('user', 'form')->submit('einloggen',['class'=>'btn']); ?>
    
    </form>
</div>
<?php danupe()->view()->get('plugin-user', '/frontend/footer'); ?>