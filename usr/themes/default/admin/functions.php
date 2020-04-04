<?php

function get_category($article)
{
    if (!isset($article)) {
        return '未分类';
    }
    $article_properties = $article->fields;
    if (isset($article_properties->category) && count($article_properties->category)) {
        $category = $article_properties->category[0]['name'];
    } else {
        $category = '未分类';
    }
    return $category;
}
function get_category_id($article)
{
    if (!isset($article)) {
        return 0;
    }
    $article_properties = $article->fields;
    if (isset($article_properties->category) && count($article_properties->category)) {
        return $article_properties->category[0]['id'];
    } else {
        return 0;
    }
}
function get_tag_ids($article)
{
    
    if (!isset($article)) {
        return [];
    }
    $article_properties = $article->fields;
    

    if (isset($article_properties->tag) && count($article_properties->tag)) {
        $ret = [];
        foreach ($article_properties->tag as $tag) {            
            $ret[] =  $tag['id'];
        }
        return $ret;
    } else {
        return [];
    }
}
function get_status_html($status)
{
    if ($status == 0) {
        return '<span class="status-icon bg-success"></span> 已发布';
    } else if ($status == 1) {
        return '<span class="status-icon bg-secondary"></span> 未发布';
    } else if ($status == 2) {
        return '<span class="status-icon bg-warning"></span> 审核中';
    }
}
function get_page_nav($page, $perpage, $total, $splitPage = 1,  $urlTemplate = "page/{page}")
{
    $totalPage = ceil($total / $perpage);
    $from = max(1, $page - $splitPage);
    $to = min($totalPage, $page + $splitPage);

    $nav = [];
    $nav['prev'] = [
        'type' => 'prev',
        'page' => $page - 1,
        'url' => str_replace('{page}', $page - 1, $urlTemplate),
        'enabled' => $page > 1,
    ];
    $nav['inter'] = [];
    if ($from > 1) {
        $nav['inter'][] = [
            'type' => 'page',
            'page' => 1,
            'url' => str_replace('{page}', 1, $urlTemplate),
            'enabled' => true,
            'isCurrent' => false
        ];
    };
    if ($from > 2) {
        $nav['inter'][] = [
            'type' => 'hellip'
        ];
    }
    for ($i = $from; $i <= $to; $i++) {
        $isCurrent = ($i == $page);
        $nav['inter'][] = [
            'type' => 'page',
            'page' => $i,
            'url' => str_replace('{page}', $i, $urlTemplate),
            'enabled' => true,
            'isCurrent' => $isCurrent
        ];
    }
    if ($to < $totalPage) {
        $nav['inter'][] = [
            'type' => 'hellip'
        ];
        $nav['inter'][] = [
            'type' => 'page',
            'page' => $totalPage,
            'url' => str_replace('{page}', $totalPage, $urlTemplate),
            'enabled' => true,
            'isCurrent' => false
        ];
    }
    $nav['next'] = [
        'type' => 'next',
        'page' => $page + 1,
        'url' => str_replace('{page}', $page + 1, $urlTemplate),
        'enabled' => $page < $totalPage
    ];
    return $nav;
}
