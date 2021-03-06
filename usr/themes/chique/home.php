<?php $v->layout('layout/default', ['title' => '首页']) ?>
<div class="section-heading-wrapper">
    <div class="section-title-wrapper">
        <h2 class="section-title"></h2>
    </div>

</div><!-- .section-heading-wrap -->


<div class="section-content-wrapper layout-one">

    <?php foreach ($articles as $article) : ?>
        <article id="post-19" class="post-19 post type-post status-publish format-standard hentry category-uncategorized tag-boat tag-lake">
            <div class="hentry-inner">

                <div class="entry-container">

                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?= $article->url ?>" rel="bookmark"><?= $article->title ?></a></h2>
                        <div class="entry-meta">
                            <span class="byline">
                                <span class="author-label screen-reader-text">By </span>
                                <span class="author vcard">
                                    <a class="url fn n" href="#">Theme Admin</a>
                                </span>
                            </span>
                            <span class="posted-on">
                                <span class="date-label"> </span>
                                <a href="<?=$article->url; ?>" rel="bookmark">
                                    <time class="entry-date published" datetime="<?= $article->datePublished('c'); ?>"><?= $article->datePublished('m, j') ?></time>
                                    <time class="updated" datetime="<?= $article->dateUpdated('c'); ?>"><?= $article->dateUpdated('m, j'); ?></time>
                                </a>
                            </span>
                        </div><!-- .entry-meta -->
                    </header><!-- .entry-header -->


                    <div class="entry-summary">
                        <p><?= $article->summary; ?></p>
                    </div><!-- .entry-summary -->
                </div> <!-- .entry-container -->
            </div> <!-- .hentry-inner -->
        </article><!-- #post-19 -->
    <?php endforeach; ?>
</div> <!-- .section-content-wrapper -->

<nav class="navigation posts-navigation" role="navigation" aria-label="文章">
    <h2 class="screen-reader-text">文章导航</h2>
    <div class="nav-links">
        <?=$v->pageNavSimple($page, $perpage, $total); ?>
    </div>
</nav>

