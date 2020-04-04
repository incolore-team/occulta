<?php $v->layout('admin/layout/admin.layout.php', ['title' => '写新文章']) ?>
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            <?= isset($article) ? '编辑文章' : '新文章'; ?>
        </h1>
        <div class="input-group-append ml-auto">
            <button type="button" class="btn btn-secondary mr-2">保存草稿</button><button id="submit" type="button" class="btn btn-primary">发布</button>
        </div>

    </div>
    <div class="col-12">
        <div class="form-group">
            <label class="form-label">标题</label>
            <input value="<?= isset($article) ? htmlspecialchars($article->title) : ''; ?>" type="text" class="form-control" name="title" id="title" placeholder="Text..">
            <div class="flex mt-4">
                <a href="#slugOption" aria-expanded="false" aria-controls="slugOption" class="" data-toggle="collapse" role="button">Slug</a>

                <div class="row collapse" style=" flex: 1; margin:0;" id="slugOption">
                    <input id="slug" value="<?= isset($article) ? $article->slug : ''; ?>" style="height: 24px; background:none; margin-left: 1em;" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
        </div>

    </div>
</div>
<div class="container">
    <div class="col-12 ">
        <div class="form-group">
            <label class="form-label">正文</label>
            <textarea style="width:0; height:0;" id="md-editor"><?= (isset($article)) ? htmlspecialchars($article->text) : '' ?></textarea>
        </div>
    </div>
</div>

<div class="container">
    <a href="#editMore" aria-expanded="false" aria-controls="editMore" class="btn btn-link mb-6" data-toggle="collapse" role="button">更多选项...</a>

    <div class="row collapse" style="margin:0;" id="editMore">
        <div class="col-md-6 ">
            <div class="form-group">
                <label class="form-label">分类</label>
                <select id="category" class="form-control custom-select">
                    <option value="0">不分类</option>
                    <?php foreach ($meta->categories as $category) : ?>
                        <option value="<?= $category->id; ?>" <?= get_category_id($article) == $category->id ? 'selected="selected"' : ''; ?>><?= $category->name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">附图</label>
                <input id="cover" class="form-control">
                </input>
            </div>
            <div class="form-group">
                <div class="form-label">其他</div>
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="visible" value="1" <?= isset($article) && !$article->visible ? '' : "checked" ?>>
                    <span class="custom-control-label">可见</span>
                </label>
                <label class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" name="allowComment" value="1" <?= isset($article) && !$article->allowComment ? '' : "checked" ?>>
                    <span class="custom-control-label">可评论</span>
                </label>
            </div>

        </div>
        <div class="col-md-6 ">
            <div class="form-group">
                <label class="form-label">标签</label>
                <div class="selectgroup selectgroup-pills">
                    <?php foreach ($meta->tags as $tag) : ?>
                        <label class="selectgroup-item">
                            <input type="checkbox" name="tag[]" value="<?= $tag->id; ?>" <?= in_array($tag->id, get_tag_ids($article)) ? 'checked="checked"' : ''; ?>class="selectgroup-input">
                            <span class="selectgroup-button"><?= $tag->name; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">文章简介</label>
                <textarea class="form-control" id="summary" rows="6" placeholder="Content.."><?= isset($article) && $article->summaryRaw ? $article->summaryRaw : ''; ?></textarea>
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
    $("#submit").click(($evt) => {
        $("#submit").disabled = true;

        var tags = [];
        $.each($("input[name='tag[]']:checked"), function() {
            tags.push(parseInt($(this).val()));
        });

        var article_form = {
            "title": $("#title")[0].value,
            "text": simplemde.value(),
            "slug": $("#slug")[0].value,
            "summary": $("#summary")[0].value,
            "cover": $("#cover")[0].value,
            "category": $('#category').find(":selected").val(),
            "tags": tags,
            "visible": $("input[name='visible']:checked").length ? true : false,
            "allowComment": $("input[name='allowComment']:checked").length ? true : false
        }
        $.ajax({
            contentType: "application/json; charset=utf-8",
            type: "<?= isset($article) ? "PUT" : 'POST' ?>",
            url: "<?= $v->url("api/admin/article/"); ?><?= isset($article) ? $article->id : '' ?>",
            data: JSON.stringify(article_form),
            success: (data) => {
                console.log(data);
                new Toast({
                    message: '<?= isset($article) ? '编辑'  : '发布'; ?>成功！',
                    type: 'success'
                });
                <?php if (!$article) : ?>
                    setTimeout(() => {
                        window.location.href = "<?= $v->url("admin/article/write/"); ?>" + data.id
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