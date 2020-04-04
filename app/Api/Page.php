<?php

namespace App\Api;

use App\Model\Factory;
use Core;
use App\Service\Content as Service;
use App\Service\Content;
use App\Service\Field;
use Core\Middleware\PermissionFilter;
use Core\Type\Exception\BadRequestException;

class Page
{
    public const type = "Page";
    /**
     * @api {post} /api/admin/page 欢迎界面
     * @apiPermission api.admin.page.write
     * @apiParam {string} title
     * @apiParam {string{1..}} text
     * @apiParam {string} [slug]
     * @apiParam {string} [summary]
     * @apiParam {boolean} [visible]
     * @apiParam {integer} [status]
     * @apiParam {boolean} [allowComment]
     * @apiParam {array} [tags]
     * @apiParam {integer} [category]
     */
    public function write($id = null)
    {

        $req = Core::$api->request()->data;

        /**
         * 发布、更新文章
         */
        $title = $req->title;
        $text = $req->text;
        $slug = isset($req->slug) ? slug_name($req->slug) : slug_name($title);        
        $summary = isset($req->summary) ? $req->summary : null;
        $cover = isset($req->cover) ? $req->cover : null;
        $visible = isset($req->visible) ? boolval($req->visible) : true;
        $status = isset($req->status) ? intval($req->status) : 0;
        $allowComment = isset($req->allowComment) ? boolval($req->allowComment) : true;

        if ($id) {
            $ret = Service::update($id, self::type, $title, $slug, $text, $status, PermissionFilter::$currentUser['id'], $allowComment, $visible, $summary, $cover);
            if (!$ret) {
                throw new BadRequestException("编辑失败. ");
            }
        } else {
            $id = Service::create(self::type, $title, $slug, $text, $status, PermissionFilter::$currentUser['id'], $allowComment, $visible, $summary, $cover);
        }
        if (!$id) {
            throw new BadRequestException("发布失败！");
        }
        /**
         * 更新文章扩展属性
         */
        $category = isset($req->category) ? intval($req->category) : null;
        $tags = isset($req->tags) ? $req->tags : [];
        $properties = [];
        $properties[] = [
            'metaFieldId' => $category
        ];
        foreach ($tags  as $tag) {
            $properties[] = [
                'metaFieldId' => intval($tag)
            ];
        }
        Field::setProperties($id, $properties);

        \Flight::json(["id" => $id]);
        return;
    }
    /**
     * @api {put} /api/admin/page/@id 欢迎界面
     * @apiPermission api.admin.page.update
     * @apiParam {string} title;
     * @apiParam {string} text;
     * @apiParam {string} [slug];
     */
    public function update($id)
    {
        $this->write($id);
    }
    /**
     * @api {delete} /api/admin/page/@id 欢迎界面
     * @apiPermission api.admin.page.delete
     */
    public function remove($id)
    {
        if (!Core::$db->has(Service::table, ["id" => $id])) {
            throw new BadRequestException("引用了不存在的 id");
        }

        Core::$api->json(["success" => Service::delete($id, self::type)]);
    }
    /**
     * @api {get} /api/admin/page/list 获取文章列表
     * @apiPermission api.admin.page.list
     * @apiParam {Number{1-}} [page=1] 页码
     * @apiParam {Number{1-2000}} [perpage=20] 每页数量
     * @apiParam {Boolean} [countTotal=true] 是否返回总数
     * @apiParam {array} [columns] 过滤条件
     * @apiParam {array} [where] 过滤条件
     */
    public function list()
    {
        $req = Core::$api->request()->query;
        $page = $req->page;
        $perpage = $req->perpage;
        Core::$api->json(
            Content::list(self::type, $page, $perpage, [
                "id", "uuid",
                "title", "slug", "visible",
                "createdAt", "updatedAt"
            ])
        );
    }

    /**
     * @api {get} /api/admin/page/@id 获取文章列表
     * @apiPermission admin.page.get
     */
    public function get($id)
    {
        $content = Content::get($id);
        Core::$api->json(
            Factory::CreateContent($content, false, true)
        );
    }
}
