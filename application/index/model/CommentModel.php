<?php
namespace app\index\model;

use think\Model;

class CommentModel extends Model{
    protected $table = 'cat_comment';
    public function addComment($param,$ip){
        $comment = $this->where('ip', $ip)->order('create_time desc')->limit(1)->find();
        try{

            if((intval(time())-intval($comment['create_time'])) <= 90 ){
                return ['code' => -1, 'data' => '', 'msg' => '您提交过快，请稍后再试'];
            }else{
                $comment = htmlspecialchars($param['comment']);
                $result =  db('cat_comment')->insert(['author'=>$param['author'],'title'=>$param['title'],'email'=>$param['email'],'comment'=>$comment,
                    'ip'=>$ip,'create_time'=>time()
                ]);
                return ['code' => 1, 'data' => '', 'msg' => '提交成功，谢谢你的支持'];
            }


        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
}