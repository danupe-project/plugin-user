<a
    class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200"
    href="/<?php echo danupe()->plugin('user', 'admin')->getPrefix(); ?>/">
    <?php echo danupe()->config()->get('core.meta.title'); ?>
</a>

<ul class="mt-6">
    <?php
    $navigationItems = danupe()->config()->getAllByKey("navigation", 1);


    if (!function_exists('sortMenuArray')) {

        function sortMenuArray(array $menu): array
        {
            uasort($menu, function ($a, $b) {
                if ($a['sort'] == 1) return -1;
                if ($b['sort'] == 1) return 1;
                return $a['sort'] <=> $b['sort'];
            });
            return $menu;
        }
    }
    $navigationItems = sortMenuArray($navigationItems);

    foreach ($navigationItems as $url => $navigationItem) {
        if (danupe()->data()->get($navigationItem, 'parent', false) == false) { ?>
            <li class="relative px-6 py-3">
                <a href="<?php echo $url; ?>" class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200">
                    <i class="<?php echo danupe()->data()->get($navigationItem, 'icon'); ?> mr-3"></i>
                    <span class="ml-4"><?php echo danupe()->data()->get($navigationItem, 'title'); ?></span>
                </a>
            </li>
    <?php
        }
    }
    ?>
</ul>