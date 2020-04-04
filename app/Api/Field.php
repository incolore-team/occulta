<?php

namespace App\Api;

use App\Service\Content as ServiceContent;
use App\Service\Field as ServiceField;
use Core;
use Core\Type\Exception\BadRequestException;
use flight\util\Collection;

class Field
{


    /**
     * @api {post} /api/admin/field/meta 欢迎界面
     * @apiPermission api.admin.field.meta.add
     * @apiParam {string} name;
     * @apiParam {string} option;
     * @apiParam {string} slug;
     * @apiParam {string} [param];
     */
    public function addMeta()
    {
        $req = Core::$api->request()->data;
        $name = trim($req->name);
        $option = trim($req->option);
        $slug = trim($req->slug);
        $param = isset($req->param) ? $req->param : null;
        $id = ServiceField::addMeta($name, $option, $slug, $param);
        Core::$api->json(
            ['id' => $id,]
        );
    }
    /**
     * @api {get} /api/admin/field/meta/list/@name 欢迎界面
     * @apiPermission api.admin.field.meta.list
     */
    public function listMeta($name)
    {
        $data = ServiceField::listMeta($name);
        Core::$api->json($data);
    }
    /**
     * @api {put} /api/admin/field/meta/@id 欢迎界面
     * @apiPermission api.admin.field.meta.update
     * @apiParam {string} option;
     * @apiParam {string} slug;
     */
    public function updateMeta($id)
    {
        if (!Core::$db->has(ServiceField::tableMeta, ["id" => $id])) {
            throw new BadRequestException("引用了不存在的 id");
        }
        $req = Core::$api->request()->data;
        $option = trim($req->option);
        $slug = trim($req->slug);
        $param = isset($req->param) ? $req->param : null;

        ServiceField::updateMeta($id,  $option, $slug, $param);
        Core::$api->json(
            []
        );
    }
    /**
     * @api {delete} /api/admin/field/meta/@id 欢迎界面
     * @apiPermission api.admin.field.meta.remove
     */
    public function removeMeta($id)
    {
        if (!Core::$db->has(ServiceField::tableMeta, ["id" => $id])) {
            throw new BadRequestException("引用了不存在的 id");
        }
        ServiceField::removeMeta($id);
        ServiceField::removeByMetaId($id);
        Core::$api->json(
            []
        );
    }
    /**
     * @api {get} /api/admin/content/@id/field 欢迎界面
     * @apiPermission api.admin.content.field.get
     * @apiParam {bool} [full="false"]
     */
    public static function getProperties($contentId)
    {

        $req = Core::$api->request()->query;
        $full = boolval($req->full);
        $ret = ServiceField::getProperties($contentId, $full);
        Core::$api->json($ret);
    }
    /**
     * @api {post} /api/admin/content/@id/field 欢迎界面
     * @apiPermission api.admin.content.field.get
     * @apiParam {array} properties;
     */
    public static function setProperties($contentId)
    {
        if (!Core::$db->has(ServiceContent::table, ["id" => $contentId])) {
            throw new BadRequestException("引用了不存在的 id");
        }
        $req = Core::$api->request()->data;
        $properties = $req->properties;
        foreach ($properties as &$property) {
            if (!array_key_exists("id", $property)) {
                throw new BadRequestException("数据残缺");
            }
            if (!array_key_exists("value", $property)) {
                $property["value"] = null;
            }
            $property["metaFieldId"] = $property["id"];
            unset($property["id"]);
        }
        ServiceField::setProperties($contentId, $properties);
        Core::$api->json([]);
    }
}
