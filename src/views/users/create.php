<?php

danupe()->view()->get('plugin-user', 'header');

use Danupe\Plugin\User\Classes\Form;
use Danupe\Plugin\User\Models\Role;

?>
<!--Container-->
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">
        <?php if (danupe()->session()->has('errors')): ?>
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

        <br />

        <form method="POST" action="/<?php echo danupe()->env()->get('DANUPE_ADMIN_PREFIX'); ?>/users/create_post" class="grid grid-cols-1 md:grid-cols-2 gap-4">


            <?php echo Form::csrf(); ?>

            <div class="form-group">
                <?php echo Form::label('email', 'Email Address', ['class' => 'block mb-1']); ?>
                <?php echo Form::input('email', '', danupe()->session()->old('email'), ['class' => 'form-input w-full']); ?>
            </div>
            <div class="form-group">
            </div>

            <div class="form-group">
                <?php echo Form::label('password', 'Password', ['class' => 'block mb-1']); ?>
                <?php echo Form::password('password', '', danupe()->session()->old('password'), ['class' => 'form-input w-full']); ?>
            </div>

            <div class="form-group">
                <?php echo Form::label('password_confirmation', 'Confirm Password', ['class' => 'block mb-1']); ?>
                <?php echo Form::password('password_confirmation', '', danupe()->session()->old('password_confirmation'), ['class' => 'form-input w-full']); ?>
            </div>

            <?php
            $roles = new Role();
            ?>

            <div class="form-group">
                <?php echo Form::label('role', 'Role', ['class' => 'block mb-1']); ?>
                <?php echo Form::select('role_id', $roles->all('select'), null, ['class' => 'form-select w-full']); ?>
            </div>

            <div></div> <!-- Empty div for alignment -->

            <button type="submit" class="btn btn-primary w-full md:w-auto bg-white p-2 border rounded hover:bg-gray-200">Submit</button>
        </form>

    </div>

</div>
<!--/container-->

<?php danupe()->view()->get('plugin-user', 'footer'); ?>