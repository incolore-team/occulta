<?php

namespace App\Model;

use App\Service\Auth;
use App\Service\Comment;
use App\Service\Content as ServiceContent;
use App\Service\Field;
use App\Service\Site;
use App\Util\Date;
use flight\util\Collection;

/**
 * 本类负责创建复杂的数据对象，提供给前端使用。
 */
class Factory
{
    public static function createUser($raw)
    {
        $user = new User();
        $user->id = $raw['id'];
        $user->username = $raw['username'];
        $user->password = $raw['password'];
        $user->email = $raw['email'];
        $user->url = $raw['url'];
        $user->screenName = $raw['screenName'];
        $user->createdAt = $raw['createdAt'];
        $user->updatedAt = $raw['updatedAt'];
        return $user;
    }

    public static function CreateContent($raw, $simple = false, $nofunc = false)
    {
        if (!$raw) return false;

        $content = new Content();

        $content->id = intval($raw['id']);
        $content->uuid = $raw['uuid'];
        $content->title = $raw['title'];
        $content->slug = $raw['slug'];
        $content->status = intval($raw['slug']);
        $content->createdAt = $created = intval($raw['createdAt']);
        $content->updatedAt = $updated = intval($raw['updatedAt']);
        $content->text = $raw['text'];
        $content->authorId = $raw['authorId'];
        $content->visible = boolval($raw['visible']);
        $content->allowComment = boolval($raw['allowComment']);
        $content->type = $type = $raw['type'];
        $content->cover = $raw['cover'];
        $content->views = $raw['views'];
        if (!$simple) $content->cache = $raw['cache'];
        $content->cachedAt = intval($raw['cachedAt']);

        $content->author = Auth::getUser($raw['authorId']);
        $content->fields = new Collection(Field::getProperties($content->id));

        $content->comment = new Injectable();
        $content->comment->allow = boolval($raw['allowComment']);
        $content->comment->count = Comment::count(["contentId" => $content->id]);
        if (!$nofunc) $content->comment->data = function () {
            return [];
        };
        if (!$nofunc) $content->date = $content->datePublished = function ($format = null) use ($created) {
            if (null == $format) {
                return Date::dateWord(time(), $created);
            }
            return date($format, $created);
        };
        if (!$nofunc) $content->dateUpdated = function ($format = null) use ($created) {
            if (null == $format) {
                return Date::dateWord(time(), $created);
            }
            return date($format, $created);
        };
        if (!$nofunc) if (!$simple) $content->prev = function () use ($created, $type) {
            $ret = ServiceContent::prev($type, $created);
            return self::CreateContent($ret);
        };

        if (!$nofunc) if (!$simple) $content->next = function () use ($created, $type) {
            $ret = ServiceContent::next($type, $created);
            return self::CreateContent($ret);
        };
        if (!$nofunc) $content->getComments = function ($page, $perpage) {
        };

        $content->url = Site::url('archive/' . $raw['uuid']);
        if (!$simple) $content->html = ServiceContent::getParse()->parse($raw['text']);


        $content->summary = $raw['summary'] ?  $raw['summary'] : mb_substr(strip_tags($content->html), 0, 200);
        $content->summaryRaw = $raw['summary'];
        return $content;
    }
}
