<!doctype html>
<html lang="zh" dir="ltr">

<head>
<?= $v->insert('admin/parts/head.php') ?>
</head>

<body class="">
  <div class="page">
    <div class="flex-fill">
      <?= $v->insert('admin/parts/header.php') ?>      
      <div class="my-3 my-md-5">
        <?= $v->section('content') ?>
      </div>
    </div>
    <?= $v->insert('admin/parts/footer.php') ?>
    
  </div>
</body>

</html>
