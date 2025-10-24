<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>CRM Scaffold</title>
  
  <?php echo (app()->bound('App\\Services\\AssetManager') ? app('App\\Services\\AssetManager')->renderStyles('customer') : ''); ?>
  <link rel="stylesheet" href="/build/css/app.css">
</head>
<body class="bg-gray-100 text-gray-900">
  <div id="app">
    <?php echo $__env->yieldContent('content'); ?>
  </div>
  <?php echo (app()->bound('App\\Services\\AssetManager') ? app('App\\Services\\AssetManager')->renderScripts('customer') : ''); ?>
  <script type="module" src="/build/js/app.js"></script>
</body>
</html>
<?php /**PATH E:\Project\Web\laragon\www\my-crm\backend\resources\views/layouts/app.blade.php ENDPATH**/ ?>