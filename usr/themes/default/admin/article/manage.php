<?php $v->layout('admin/layout/admin.layout.php', ['title' => '管理文章']) ?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            管理文章
        </h1>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">文章列表</h3>
            </div>
            <div class="table-responsive">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer">
                    <div class="dataTables_length" id="DataTables_Table_0_length">
                        <a class="btn btn-primary ml-auto" href="<?= $v->url("admin/article/write"); ?>">
                            写文章
                        </a>
                    </div>
                    <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>搜索:<input type="search" class="" placeholder=""></label></div>
                    <table class="table card-table table-vcenter text-nowrap datatable dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                        <thead>
                            <tr role="row">
                                <th class="w-1" tabindex="0" rowspan="1" colspan="1" style="width: 45px;">No.</th>
                                <th aria-sort="descending" style="width: 131px;">标题</th>
                                <th style="width: 38px;">作者</th>
                                <th style="width: 99px;">分类</th>
                                <th style="width: 60px;">发布时间</th>
                                <th style="width: 77px;">更新时间</th>
                                <th style="width: 111px;">状态</th>
                                <th style="width: 15px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <? $odd = false; ?>
                            <?php foreach ($articles as $article) : ?>

                                <tr data-content-id="<?= $article->id; ?>" role="row" class="<?= $odd = !$odd ? 'odd' : 'even'; ?>">
                                    <td><span class="text-muted"><?= $article->id; ?></span></td>
                                    <td>
                                        <a target="_blank" href="<?= $article->url; ?>" class="text-inherit"><?= $article->title; ?></a>
                                        <a href="<?= $v->url('admin/article/write/' . $article->id); ?>"><i class="fe fe-edit"></i></a>


                                    </td>
                                    <td><?= $article->author['screenName']; ?></td>
                                    <td><?= get_category($article) ?></td>
                                    <td><?= $article->date() ?></td>
                                    <td><?= $article->dateUpdated() ?></td>
                                    <td><?= get_status_html($article->status); ?></td>
                                    <td class="text-right">
                                        <div class="item-action dropdown">
                                            <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0)" class="dropdown-item menuitem-edit">
                                                    <i class="dropdown-icon fe fe-tag"></i> 编辑
                                                </a>
                                                <a href="javascript:void(0)" class="dropdown-item menuitem-setstatus-2">
                                                    <i class="dropdown-icon fe fe-edit-2"></i> 标记为未发布
                                                </a>
                                                <a href="javascript:void(0)" class="dropdown-item menuitem-setstatus-1">
                                                    <i class="dropdown-icon fe fe-message-square"></i> 标记为待审核
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:void(0)" class="dropdown-item menuitem-delete">
                                                    <i class="dropdown-icon fe fe-link"></i>删除
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">共 <?= $total; ?> 篇，每页 <?= $perpage; ?> 篇 </div>
                    <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                        <?php $pageNav = get_page_nav($page, $perpage, $total) ?>
                        <?php $prev = $pageNav['prev']; ?>
                        <?php $next = $pageNav['next']; ?>
                        <a class="paginate_button previous <?= $prev["enabled"] ? '' : 'disabled'; ?>" <?php if ($prev["enabled"]) : ?> href="<?= $v->url('admin/article/manage/' . $prev['url']); ?>" <?php endif; ?> data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">
                            上一页
                        </a>
                        <span>
                            <?php foreach ($pageNav['inter'] as $page) : ?>
                                <?php if ($page['type'] == 'page') : ?>
                                    <a class="paginate_button <?= $page["isCurrent"] ? 'current' : ''; ?>" href="<?= $v->url('admin/article/manage/' . $page['url']); ?>" data-dt-idx="1" tabindex="0"><?= $page['page']; ?></a>
                                <?php elseif ($page['type'] == 'hellip') : ?>
                                    <span>...</span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </span>
                        <a class="paginate_button next  <?= $next["enabled"] ? '' : 'disabled'; ?>" <?php if ($next["enabled"]) : ?> href="<?= $v->url('admin/article/manage/' . $next['url']); ?>" <?php endif; ?> data-dt-idx="3" tabindex="0" id="DataTables_Table_0_next">
                            下一页
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function setStatus(id, status) {
        $.ajax({
            contentType: "application/json; charset=utf-8",
            type: "PUT",
            url: "<?= $v->url("api/admin/article/"); ?>" + id + "/status",
            data: JSON.stringify({
                status: status
            }),
            success: (data) => {
                console.log(data);
                new Toast({
                    message: '操作成功',
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
                    message: '发布失败！' + reason,
                    type: 'danger'
                });
                $("#submit").disabled = false;
            },
        });
    }

    function deleteArticle(id) {
        $.ajax({
            type: "DELETE",
            url: "<?= $v->url("api/admin/article"); ?>/" + id,
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

    function getContentId($evt) {
        return $evt.currentTarget.
        parentElement.parentElement.
        parentElement.parentElement.getAttribute("data-content-id");
    }
    $(document).ready(function() {
        $(".menuitem-delete").click(($evt) => {
            var id = getContentId($evt);
            new Toast({
                message: '真的要删除吗？',
                type: 'danger',
                customButtons: [{
                    text: '确认删除',
                    onClick: function() {
                        deleteArticle(id);
                    }
                }],
            });
        });
        $(".menuitem-edit").click(($evt) => {
            var id = getContentId($evt);
            window.location.href = "<?= $v->url("admin/article/write"); ?>/" + id;
        });

    });
</script>