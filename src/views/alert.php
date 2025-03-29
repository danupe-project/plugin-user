<?php 

if (danupe()->session()->has('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (danupe()->session()->get('errors') as $error): ?>
                <?php foreach ($error as $key => $value): ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (danupe()->session()->has('success') && is_array(danupe()->session()->get('success'))) : ?>
    <div class="alert alert-success">
        <ul>
            <?php foreach (danupe()->session()->get('success') as $success): ?>
                <?php foreach ($success as $key => $value): ?>
                    <li><?php echo $value; ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if (danupe()->session()->has('success') && !is_array(danupe()->session()->get('success'))) : ?>
    <div class="alert alert-success">
        <?php echo danupe()->session()->get('success'); ?>
    </div>
<?php endif; ?>


<br />