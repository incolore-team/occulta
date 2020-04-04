<?php $v->layout('layout/default', ['title' => '首页']) ?>
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({
      extensions: ["tex2jax.js"],
      jax: ["input/TeX", "output/HTML-CSS"],
      tex2jax: {
        inlineMath: [ ['$','$'], ["\\(","\\)"] ],
        displayMath: [ ['$$','$$'], ["\\[","\\]"] ],
        processEscapes: true
      },
      "HTML-CSS": { availableFonts: ["TeX"] }
      });
</script>
<script type="text/javascript" src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>

<article class="post" itemscope itemtype="http://schema.org/BlogPosting">
    <div class="post-title" itemprop="name headline">
        <h1><a itemtype="url" href="<?= $article->url ?>"> <?= $article->title ?></a></h1>
    </div>
    <div class="post-content" itemprop="articleBody">
        <?= $article->html; ?>
    </div>
    <p itemprop="keywords" class="tags">
        <?php if (isset($article->fields->tags)) foreach ($article->fields->tags as $tag) : ?>
            <?= $tag['name']; ?>
        <?php endforeach; ?>
    </p>
</article>

<?php /*$article->need('comments.php'); */ ?>

<?php
$prev = $article->prev();
$next = $article->next();
?>
<ul class="post-near">
    <li>上一篇: <?php if ($prev) : ?><a href="<?= $prev->url; ?>"><?= $prev->title; ?></a><? else : ?>没有了<?php endif; ?></li>
    <li>下一篇: <?php if ($next) : ?><a href="<?= $next->url; ?>"><?= $next->title; ?></a><? else : ?>没有了<?php endif; ?></li>
</ul>