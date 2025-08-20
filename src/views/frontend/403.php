<?php danupe()->view()->get('plugin-user', '/frontend/header'); ?>
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
    <?php echo danupe()->language()->get('auth.error_403') ?? 'Error 403'; ?>
    <div class="mt-4 text-sm text-gray-600 dark:text-gray-300">
        <?php echo danupe()->language()->get('auth.forbidden') ?? ''; ?>
    </div>
</div>
<?php danupe()->view()->get('plugin-user', '/frontend/footer'); ?>