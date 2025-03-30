
<div class="w-full">
        <div class="tabs tabs-boxed flex-nowrap gap-1">
            <?php
            $navigation = danupe()->config()->getAllByKey('navigation', 1);
            $subNavigation = [];
            foreach ($navigation as $key => $value) {
                if (danupe()->data()->get($value, 'parent') == danupe()->data()->get($_SERVER, 'REQUEST_URI')) {
                    $subNavigation[$key] = $value;
                }
            }
            if ($subNavigation) {
                foreach ($subNavigation as $key => $value) {
                    echo '<div class="tab"><a href="' . $key . '">' . danupe()->data()->get($value, 'title') . '</a></div>';
                }
            }
            ?>
        </div>
    </div>