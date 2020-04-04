<?php $v->layout('admin/layout/admin.layout.php', ['title' => '管理主题']) ?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            管理主题
        </h1>
    </div>
    <div class="col-12 row row-cards row-deck">

        <?php foreach ($themes as $theme) :
            if (isset($theme["@cover"])) {
                if (starts_with($theme["@cover"], "http")) {
                    $cover =  $theme["@cover"];
                }else{
                    $cover = $v->import($theme["@cover"]);
                }

            } else {
                $cover = $v->url('public/assets/no_image.png');
            }
        ?>

            <div class="col-lg-6">
                <div class="card card-aside">
                    <a href="#" class="card-aside-column" style="background-image: url(<?=$cover ?>)"></a>
                    <div class="card-body d-flex flex-column">
                        <h4><a href="#"><?= $theme['@package']; ?></a></h4>
                        <div class="text-muted"><?= isset($theme['@description']) ? $theme['@description'] : '该主题没有描述信息。'; ?></div>
                        <div class="d-flex align-items-center pt-5 mt-auto">
                            <div class="avatar avatar-md mr-3" style="background-image: url(<?= isset($theme['avatar']) ? $theme['avatar'] : '' ?>)"></div>
                            <div>
                                <a href="./profile.html" class="text-default"><?= isset($theme['@author']) ? $theme['@author'] : '' ?></a>
                                <small class="d-block text-muted"><?= isset($theme['@version']) ? $theme['@version'] : '' ?></small>
                            </div>
                            <div class="ml-auto text-muted">
                                <a href="javascript:void(0)" class="icon d-none d-md-inline-block ml-3"><i class="fe fe-heart mr-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>