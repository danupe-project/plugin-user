<?php danupe()->view()->get('plugin-user', '/frontend/header'); ?>
<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <form action="/<?php echo danupe()->env()->get("DANUPE_ADMIN_PREFIX");?>/login_post" method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo danupe()->session()->get('csrf_token'); ?>">
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">E-Mail</label>
                <input type="email" id="email" name="email" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Passwort</label>
                <input type="password" id="password" name="password" class="w-full border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <input type="submit" value="Login" class="w-full bg-blue-500 text-white font-bold py-2 rounded-lg hover:bg-blue-600 transition">
            </div>
        </form>
    </div>
<?php danupe()->view()->get('plugin-user', '/frontend/footer'); ?>