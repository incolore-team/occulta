<!DOCTYPE html>
<html lang="en">

<head>
    <?= $v->insert('admin/parts/head.php') ?>
</head>

<body>
    <div class="page">
        <main role="main" class="flex justify-center h-full items-center">
            <?= $v->section('content'); ?>
        </main>
    </div>
</body>

</html>