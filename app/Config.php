<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/3 0003
 * Time: 21:11
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Config extends Model {
    public $table = 'config';
    public $timestamps = false;

    private $rules = [
        'varname' => 'required|max:20',
        'info' => 'required|max:100',
        'value' => 'required|max:100',
        'type' => 'required|in:string,int,img,boolean'
    ];

    private $messages = [
        'required' => ':attribute不能为空',
        'in' => '请选择合适的:attribute',
        'max' => ':attribute超过了最大范围',
    ];

    private $attribute = [
        'varname' => '配置项',
        'info' => '配置说明',
        'value' => '配置值',
        'type' => '配置类型',
    ];


    /**
     * 获取系统配置的个数
     * @param int $rid
     * @param null $pageInfo
     */
    public function getCount($pageInfo = null, $classify = 0) {
        $count = [];
        $count['total'] = $this->where('classify', $classify)->count();
        if ($pageInfo['search'] == '') {
            $count['search'] = $count['total'];
        } else {
            $count['search'] = $this->where('classify', $classify)->where('varname', 'like', "%{$pageInfo['search']}%")->count();
        }
        return $count;
    }

    /**
     * 获取所有配置
     * @param $pageInfo 分页数据
     * @classify 分类
     * @return array 配置数组
     */
    public function getConfig($pageInfo = null, $classify = 0) {
        if ($pageInfo == null) {//没有分页
            $configs = $this->where('classify', $classify)->get();
        } else {
            if ($pageInfo['search'] == '') {
                $configs = $this->where('classify', $classify)->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
            } else {
                $configs = $this->where('classify', $classify)->where('varname', 'like', "%{$pageInfo['search']}%")->offset($pageInfo['start'])->limit($pageInfo['length'])->get();
            }
        }
        return $configs;
    }

    /**
     * 修改指定系统配置
     * @param $id 配置id
     * @param $value 配置值
     */
    public function editSystemConfig($id, $value) {
        $config = $this->find($id);
        $config->value = $value;
        $config->save();
    }

    /**
     * 自动验证
     * @params 表单数据
     * @return object/bool 验证成功/失败
     */
    public
    function validate($data) {
        $validator = Validator::make($data, $this->rules, $this->messages, $this->attribute);
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        return true;
    }


}