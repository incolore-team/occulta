<?php $v->layout('admin/layout/admin.layout.php', ['title' => '管理文章']) ?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            管理扩展属性
        </h1>
    </div>
    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">操作</h3>
            </div>
            <div class="card-body">
                <div>
                    <button type="submit" data-toggle="modal" data-target="#add-modal" class="btn btn-primary">添加</button>

                    <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-labelledby="add-modal" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">添加</h4>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">类型</label>
                                        <select id="metaName" class="form-control custom-select">
                                            <?php foreach ($metas as $key => $meta) : ?>
                                                <option value="<?= $key; ?>"><?= $meta['displayName']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">名称</label>
                                        <input type="text" class="form-control" id="metaOption" placeholder="Text..">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">缩略词</label>
                                        <input type="text" class="form-control" id="metaSlug" placeholder="Text..">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">参数</label>
                                        <input type="text" class="form-control" id="metaParam" placeholder="Text..">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                                    <button id="newMeta" type="button" class="btn btn-primary">提交</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal -->
                    </div>
                </div>

            </div>
        </div>
        <?php foreach ($metas as $meta) : ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><?= $meta["displayName"]; ?></h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col" width="20">#</th>
                                <th scope="col" width="100">名称</th>
                                <th scope="col" width="100">缩略词</th>
                                <th scope="col" width="300">参数</th>
                                <th scope="col" width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($meta["items"] as $item) : ?>
                                <tr data-meta-id="<?= $item['id']; ?>">
                                    <th scope="row"><?= $item['id']; ?></th>
                                    <td><?= $item['option']; ?></td>
                                    <td><?= $item['slug']; ?></td>
                                    <td><?= $item['param']; ?></td>
                                    <td>
                                        <a class="icon menuitem-edit" href="javascript:void(0)">
                                            <i class="fe fe-edit"></i>
                                        </a>
                                        <a class="icon menuitem-delete" href="javascript:void(0)">
                                            <i class="fe fe-delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<script>
    function getMetaId($evt) {
        return $evt.currentTarget.
        parentElement.parentElement.getAttribute("data-meta-id");
    }

    function deleteMeta(id) {
        $.ajax({
            type: "DELETE",
            url: "<?= $v->url("api/admin/field/meta"); ?>/" + id,
            success: (data) => {
                console.log(data);
                new Toast({
                    message: '删除成功！',
                    type: 'success'
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            },
            error: (data, status) => {
                var reason = "";
                if (data.responseJSON) {
                    reason = data.responseJSON.message;
                }
                new Toast({
                    message: '删除失败！' + reason,
                    type: 'danger'
                });
            },
        });
    }
    $("#newMeta").click(($evt) => {
        $("#newMeta").disabled = true;
        var form = {
            "option": $("#metaOption")[0].value,
            "slug": $("#metaSlug")[0].value,
            "param": $("#metaParam")[0].value,
            "name": $('#metaName').find(":selected").val(),
        }
        $.ajax({
            contentType: "application/json; charset=utf-8",
            type: "POST",
            url: "<?= $v->url("api/admin/field/meta"); ?>",
            data: JSON.stringify(form),
            success: (data) => {
                console.log(data);
                new Toast({
                    message: '添加成功！',
                    type: 'success'
                });
                setTimeout(() => {
                    window.location.reload();
                }, 1000);

            },
            error: (data, status) => {
                var reason = "";
                if (data.responseJSON) {
                    reason = data.responseJSON.message;
                }
                new Toast({
                    message: '失败！' + reason,
                    type: 'danger'
                });
                $("#newMeta").disabled = false;
            },
        });
    });
    $(".menuitem-delete").click(($evt) => {
        var id = getMetaId($evt);
        new Toast({
            message: '真的要删除吗？',
            type: 'danger',
            customButtons: [{
                text: '确认删除',
                onClick: function() {
                    deleteMeta(id);
                }
            }],
        });
    });
    $(".menuitem-edit").click(($evt) => {
        var id = getMetaId($evt);
    });
</script>