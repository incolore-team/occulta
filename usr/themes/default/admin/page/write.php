<?php $v->layout('admin/layout/admin.layout.php', ['title' => '写新页面']) ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <?= isset($page) ? '编辑页面' : '新页面'; ?>
        </h1>
        <div class="input-group-append ml-auto">
            <button type="button" id="saveDraft" class="btn btn-secondary mr-2">保存草稿</button><button id="submit" type="button" class="btn btn-primary">发布</button>
        </div>

    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label">标题</label>
            <input value="<?= isset($page) ? htmlspecialchars($page->title) : ''; ?>" type="text" class="form-control" name="title" id="title" placeholder="Text..">
            <div class="flex mt-4">
                <b>Slug</b>
                <input id="slug" value="<?= isset($page) ? $page->slug : ''; ?>" style="height: 24px; background:none; margin-left: 1em;" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
            </div>
        </div>

    </div>
</div>
<div class="container">
    <div class="col-12 ">
        <div class="form-group">
            <label class="form-label">正文</label>
            <textarea style="width:0; height:0;" id="md-editor"><?= (isset($page)) ? htmlspecialchars($page->text) : '' ?></textarea>
        </div>
    </div>
</div>

<div class="container">
    <a href="#editMore" aria-expanded="false" aria-controls="editMore" class="btn btn-link mb-6" data-toggle="collapse" role="button">更多选项...</a>

    <div class="row collapse" style="margin:0;" id="editMore">
        <div class="col-md-6 ">
            <div class="form-group">
                <label class="form-label">附图</label>
                <input id="cover" class="form-control">
                </input>
            </div>
            <div class="form-group">
                <div class="form-label">其他</div>
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="visible" value="1" <?= isset($page) && !$page->visible ? '' : "checked" ?>>
                    <span class="custom-control-label">可见</span>
                </label>
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="allowComment" value="1" <?= isset($page) && !$page->allowComment ? '' : "checked" ?>>
                    <span class="custom-control-label">可评论</span>
                </label>
            </div>

        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                <label class="form-label">页面简介</label>
                <textarea class="form-control" id="summary" rows="6" placeholder="Content.."><?= isset($page) && $page->summaryRaw ? $page->summaryRaw : ''; ?></textarea>
            </div>
        </div>
    </div>
</div>

<script src="<?= $v->import('admin/js/vendors/simplemde.min.js') ?>"></script>
<link href="<?= $v->import('admin/css/vendors/simplemde.min.css') ?>" rel="stylesheet" />


<script type="text/javascript" src="https://cdn.bootcss.com/mathjax/2.7.7/MathJax.js?config=TeX-MML-AM_CHTML"></script>
<script>
    var simplemde;
    $(function() {
        MathJax.Hub.Config({
            tex2jax: {
                inlineMath: [
                    ["$", "$"],
                    ["\\(", "\\)"]
                ]
            }
        });

        var QUEUE = MathJax.Hub.queue;
        simplemde = new SimpleMDE({
            element: document.getElementById("md-editor"),
            spellChecker: false,
            previewRender: function(plainText) {
                var preview = document.getElementsByClassName("editor-preview-side")[0];
                preview.innerHTML = this.parent.markdown(plainText);
                preview.setAttribute('id', 'editor-preview')
                MathJax.Hub.Queue(["Typeset", MathJax.Hub, "editor-preview"]);
                return preview.innerHTML;
            },
        });

    })

    function publish(status) {
        var slug = $("#slug")[0].value
        if (!slug) {
            new Toast({
                message: '请填写 slug',
                type: 'danger'
            });
            return;
        }

        var page_form = {
            "title": $("#title")[0].value,
            "text": simplemde.value(),
            "slug": slug,
            "status": status,
            "summary": $("#summary")[0].value,
            "cover": $("#cover")[0].value,
            "category": 0,
            "tags": [],
            "visible": $("input[name='visible']:checked").length ? true : false,
            "allowComment": $("input[name='allowComment']:checked").length ? true : false
        }
        $.ajax({
            contentType: "application/json; charset=utf-8",
            type: "<?= isset($page) ? "PUT" : 'POST' ?>",
            url: "<?= $v->url("api/admin/page/"); ?><?= isset($page) ? $page->id : '' ?>",
            data: JSON.stringify(page_form),
            success: (data) => {
                console.log(data);
                new Toast({
                    message: '<?= isset($page) ? '编辑'  : '发布'; ?>成功！',
                    type: 'success'
                });
                <?php if (!$page) : ?>
                    setTimeout(() => {
                        window.location.href = "<?= $v->url("admin/page/write/"); ?>" + data.id
                    }, 2000);
                <?php endif; ?>

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
    $("#saveDraft").click(($evt) => {
        $("#submit").click($evt);
        publish(2)
    });
    $("#submit").click(($evt) => {
        $("#submit").disabled = true;
        publish(0)
    });
</script>


<style>
    /* .page {
        background-color: white;
    }

    .editor-toolbar {
        border-bottom: 1px solid #bbb;
        border-top: none;
        border-left: none;
        border-right: none;
    }

    .CodeMirror {
        border: none;
    } */
</style>