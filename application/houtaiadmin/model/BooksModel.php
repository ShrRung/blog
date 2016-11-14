<?php
namespace app\houtaiadmin\model;

use think\Model;

class BooksModel extends Model{
    protected $table = false;

    public function getBooksByWhere($where, $offset, $limit){
        return Db('books')->where($where)->limit($offset, $limit)->order('sort desc,create_time desc')->select();
    }

    public function getBooksCount($where){
        return Db('books')->where($where)->count();
    }

    /*
     * 添加书籍
     */
    public function insertBooks($param){
        try{
            $result =  Db('books')->insert(['author'=>$param['author'],'name'=>$param['name'],'bt_id'=>$param['bt_id'],'url'=>$param['url'],'picture'=>$param['picture'],
                'view'=>1,'intro'=>$param['intro'],'sort'=>$param['sort'],'memo'=>$param['memo'],'create_time'=>date('Y-m-d h:i:s',time())]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '添加书籍成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    /*
     * 编辑友链
     */
    public function editBook($param){
        try{
            $result =  Db('books')->where('bk_id',$param['bk_id'])->update(['author'=>$param['author'],'name'=>$param['name'],'bt_id'=>$param['bt_id'],
                            'url'=>$param['url'],'picture'=>$param['picture'],
                            'intro'=>$param['intro'],'sort'=>$param['sort'],'memo'=>$param['memo']]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改书籍信息成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    //删除书籍
    public function delBooks($bk_id){
        try{
            $result = Db('books')->where('bk_id', $bk_id)->delete();
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '删除成功'];
            }
        }catch(PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    //获取单个书籍
    public function getOneBook($bk_id){
        return Db('books')->field('bk_id,name,bt_id,author,url,picture,intro,sort,memo')->where('bk_id',$bk_id)->find();
    }

/*
 * 修改书籍显示状态
 */
    public function changeBkView($bk_id,$view){
        try{
            $result = Db('books')->where('bk_id', $bk_id)->update(['view'  => $view]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改成功'];
            }
        }catch(PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

/*
 * 书籍分类
 */
    public function getBooksTagByWhere($where, $offset, $limit){
        return Db('books_tag')->where($where)->limit($offset, $limit)->order('sort desc,create_time desc')->select();
    }

    public function getBooksTagCount($where){
        return Db('books_tag')->where($where)->count();
    }
    //添加分类
    public function insertBooksTag($param){
        try{
            $result =  Db('books_tag')->insert(['name'=>$param['name'],'sort'=>$param['sort']]);
            return ['code' => 1, 'data' => '', 'msg' => '添加角色成功'];

        }catch( PDOException $e){

            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    //删除分类
    public function delBooksTag($id){
        try{
            $is_hasBooks = Db('books')->where('bt_id', $id)->find();
            if($is_hasBooks){
                return ['code' => -1, 'data' => '', 'msg' => '此分类下还有书籍，请先删除'];
            }else{
                Db('books_tag')->where('bt_id', $id)->delete();
                return ['code' => 1, 'data' => '', 'msg' => '删除分类成功'];
            }



        }catch( PDOException $e){
            return ['code' => 0, 'data' => '', 'msg' => $e->getMessage()];
        }
    }
    //编辑分类
    public function editBooksTag($param){
        try{
            $result =  Db('books_tag')->where('bt_id',$param['bt_id'])->update(['name'=>$param['name'],'sort'=>$param['sort']]);
            if(false === $result){
                // 验证失败 输出错误信息
                return ['code' => -1, 'data' => '', 'msg' => $this->getError()];
            }else{
                return ['code' => 1, 'data' => '', 'msg' => '修改书籍分类信息成功'];
            }
        }catch( PDOException $e){
            return ['code' => -2, 'data' => '', 'msg' => $e->getMessage()];
        }
    }

    //获取单个分类
    public function getOneBooksTag($id){
        return Db('books_tag')->where('bt_id',$id)->find();
    }
    //获取所有分类
    public function getAllBooksTag(){
        return Db('books_tag')->field('bt_id,name')->select();
    }
}