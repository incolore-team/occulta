<?php

namespace App\Service;

use League\Plates\Engine;
use League\Plates\Extension;
/**
 * 模板扩展方法，可以在模板中直接调用 $v->方法名(参数值)
 */
class TemplateExtension implements Extension
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('import', [$this, 'import']);
        $engine->registerFunction('url', [$this, 'url']);
        $engine->registerFunction('pageNav', [$this, 'pageNav']);
        $engine->registerFunction('pageNavSimple', [$this, 'pageNavSimple']);
    }
    /**
     * 引入素材，返回的是链接
     *
     * @param string $path 相对与当前模板的路径。不要以 `/` 开头
     * @return string 绝对链接
     */
    public function import($path)
    {
        return Site::url('assets/' . $path);
    }
    public function url($path = '')
    {
        return Site::url($path);
    }
    public function pageNavSimple($page, $perpage, $total, $prevText = '上一页', $nextText = '下一页', $urlTemplate = "page/{page}")
    {
        $urlTemplate = Site::url($urlTemplate);
        $totalPage = ceil($total / $perpage);
?>
        <div class="nav-links">
            <?php if ($page > 1) { ?>
                <div class="nav-previous"><a href="<?= str_replace('{page}', $page - 1, $urlTemplate) ?>"><?= $prevText; ?></a></div>

            <?php } ?>
            <?php if ($page < $totalPage) { ?>
                <div class="nav-next"><a href="<?= str_replace('{page}', $page + 1, $urlTemplate) ?>"><?= $nextText; ?></a></div>

            <?php } ?>
        </div>
    <?php
    }
    public function pageNav($page, $perpage, $total, $prevText, $nextText, $splitPage = 1,  $urlTemplate = "page/{page}", $splitWord = '...')
    {
        $urlTemplate = Site::url($urlTemplate);
        $totalPage = ceil($total / $perpage);
        $from = max(1, $page - $splitPage);
        $to = min($totalPage, $page + $splitPage);
    ?>
        <nav>
            <ul class="pagination-list page-navigator">
                <?php if ($page > 1) { ?>
                    <li><a class="pagination-previous previous" href="<?= str_replace('{page}', $page - 1, $urlTemplate) ?>"><?= $prevText; ?></a></li>
                <?php } ?>
                <?php if ($from > 1) :
                ?>
                    <li><a href="<?= str_replace('{page}', 1, $urlTemplate) ?>">1</a></li>
                <?php endif;
                if ($from > 2) : ?>
                    <li><span>&hellip;</span></li>
                <?php endif; ?>
                <?php
                for ($i = $from; $i <= $to; $i++) :
                    $current = ($i == $page);
                    if ($current) : ?>
                        <li class="current"><a href="<?= str_replace('{page}', $i, $urlTemplate) ?>" class="pagination-link " $perpage><?= $i ?></a>
                        </li>
                    <?php continue;
                    endif;
                    ?>
                    <li><a href="<?= str_replace('{page}', $i, $urlTemplate) ?>" class="pagination-link" $perpage><?= $i ?></a></li>
                <?php
                endfor;
                //输出最后页
                if ($to < $totalPage) : ?>
                    <li><span>&hellip;</span></li>
                    <li><a href="<?= str_replace('{page}', $totalPage, $urlTemplate) ?>" class="pagination-link" $perpage><?= $totalPage ?></a></li>
                <?php
                endif;
                ?>
                <?php if ($page < $totalPage) { ?>
                    <li><a class="pagination-next next" href="<?= str_replace('{page}', $page + 1, $urlTemplate) ?>"><?= $nextText; ?></a></li>
                <?php } ?>
            </ul>
        </nav>
<?php
    }
}
