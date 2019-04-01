<?php
namespace app\admin\model;
use think\Model;
class Article extends Model
{
    /*进行表的关联查询*/
    public function category(){
        return $this->belongsTo('category','cateid');;
    }
}
