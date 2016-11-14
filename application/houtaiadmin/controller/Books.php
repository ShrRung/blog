<?php
namespace app\houtaiadmin\controller;

use app\houtaiadmin\model\BooksModel;

class Books extends Base{
    //书籍列表
    public function index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $model_link = new BooksModel();
            $selectResult = $model_link->getBooksByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){

                $operate = [
                    '编辑' => url('books/edit', ['bk_id' => $vo['bk_id']]),
                    '删除' => "javascript:booksDel('".$vo['bk_id']."')"
                ];
                $selectResult[$key]['operate'] = showOperate($operate);

            }

            foreach($selectResult as $key=>$vo){
                //view
                if($vo['view'] ==1){
                    $selectResult[$key]['view'] = '<a class="btn btn-primary btn-sm" id="bk_view'.$vo['bk_id'].'" href="javascript:change_bk_view(1,'.$vo['bk_id'].')">是</a>';
                }else{
                    $selectResult[$key]['view'] = '<a class="btn btn-primary btn-danger" id="bk_view'.$vo['bk_id'].'" href="javascript:change_bk_view(0,'.$vo['bk_id'].')">否</a>';
                }
            }

            $return['total'] = $model_link->getBooksCount($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //添加书籍
    public function add()
    {
        $books = new BooksModel();
        if(request()->isPost()){

            $param = input('param.');
            $param = parseParams($param['data']);

            $flag = $books->insertBooks($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $this->assign('books_tags',$books->getAllBooksTag());
        return $this->fetch();
    }

    //编辑友链
    public function edit()
    {
        $books = new BooksModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $books->editBook($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.bk_id');
        $this->assign([
            'books'=>$books->getOneBook($id),
            'books_tags'=>$books->getAllBooksTag()
        ]);
        return $this->fetch();
    }

    //删除友链
    public function del()
    {
        if(request()->isPost()){
            $id = input('param.bk_id');
            $books = new BooksModel();
            $flag = $books->delBooks($id);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

    }

    //修改书籍状态
    public function changeBkView(){
        if(request()->isAjax()){
            $model_art = new BooksModel();
            $param = input('param.');
            $flag = $model_art->changeBkView($param['bk_id'],$param['view']);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }


    //书籍列表
    public function bk_tag_index()
    {
        if(request()->isAjax()){

            $param = input('param.');

            $limit = $param['pageSize'];
            $offset = ($param['pageNumber'] - 1) * $limit;

            $where = [];
            if (isset($param['searchText']) && !empty($param['searchText'])) {
                $where['name'] = ['like', '%' . $param['searchText'] . '%'];
            }
            $model_link = new BooksModel();
            $selectResult = $model_link->getBooksTagByWhere($where, $offset, $limit);

            foreach($selectResult as $key=>$vo){

                $operate = [
                    '编辑' => url('books/bk_tag_edit', ['bt_id' => $vo['bt_id']]),
                    '删除' => "javascript:booksTagDel('".$vo['bt_id']."')"
                ];
                $selectResult[$key]['operate'] = showOperate($operate);

            }

            $return['total'] = $model_link->getBooksTagCount($where);  //总数据
            $return['rows'] = $selectResult;

            return json($return);
        }

        return $this->fetch();
    }

    //书籍分类添加
    public function bk_tag_add(){
        if(request()->isPost()){
            $param = input('param.');
            $param = parseParams($param['data']);

            $books = new BooksModel();
            $flag = $books->insertBooksTag($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
        return $this->fetch();
    }
    //编辑
    public function bk_tag_edit(){
        $link = new BooksModel();

        if(request()->isPost()){

            $param = input('post.');
            $param = parseParams($param['data']);

            $flag = $link->editBooksTag($param);

            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }

        $id = input('param.bt_id');
        $this->assign([
            'booksTag' => $link->getOneBooksTag($id)
        ]);
        return $this->fetch();
    }
    //删除
    public function bk_tag_del(){
        if(request()->isPost()){
            $id = input('param.bt_id');

            $BooksTag = new BooksModel();
            $flag = $BooksTag->delBooksTag($id);
            return json(['code' => $flag['code'], 'data' => $flag['data'], 'msg' => $flag['msg']]);
        }
    }

}