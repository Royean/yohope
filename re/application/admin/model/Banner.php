<?php

namespace app\admin\model;

use think\Model;


class Banner extends Model
{
    // 表名
    protected $name = 'banner';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'genre_text'
    ];

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    public function getGenreList()
    {
        return ['0' => __('Genre 0'), '1' => __('Genre 1')];
    }

    public function getGenreTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['genre']) ? $data['genre'] : '');
        $list = $this->getGenreList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function news()
    {
        return $this->hasOne('News', 'news_id', 'news_id');
    }
}
