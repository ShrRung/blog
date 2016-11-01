<?php
// +----------------------------------------------------------------------
// | snake
// +----------------------------------------------------------------------
// | Copyright (c) 2016~2022 http://baiyf.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: NickBai <1902822973@qq.com>
// +----------------------------------------------------------------------
namespace app\houtaiadmin\model;

use think\Model;

use app\houtaiadmin\model\TagModel;

class ArticleModel extends Model
{
    protected $table = 'cat_article';

    public function getAllCategory(){

    }

    /*
     * 添加文章
     */
    public function insertArticle($param){
        try{
            $result =  $this->save(['cate_id'=>$param['cate_id'],'title'=>$param['title'],'content'=>htmlspecialchars($param['content']),'abstract'=>$param['abstract'],
                                'sort'=>$param['sort'],'create_time'=>date('Y-m-d h:i:s',time())
                                ]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{

                return ['code' => 1, 'data' => '', 'msg' => '添加文章成功'];
            }
        }catch( PDOException $e){

            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

}