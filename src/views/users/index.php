<?php
danupe()->view()->get('plugin-user', 'header');
?>
<!--Container-->
<div class="container w-full mx-auto pt-20">

    <div class="w-full px-4 md:px-0 md:mt-8 mb-16 text-gray-800 leading-normal">

        <div x-data="littleBIGtable({url: '/admin/users/table'})" x-init="init()">
            <table>
            <thead>
                <tr>
                <th>id</th>
                <th>email</th>
                </tr>
            </thead>
            <tbody>
                <template x-for="row in rows">
                <tr>
                    <td x-text="row.id"></td>
                    <td x-text="row.email"></td>
                </tr>
                </template>
            </tbody>
            </table>
        </div>

    </div>

</div>
<!--/container-->

<?php danupe()->view()->get('plugin-user', 'footer'); ?>