<?php

namespace app\douban\controller;

use app\common\model\Comment;
use think\Controller;
use think\Request;

class Movie extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $data = \app\common\model\Movie::select();
        if ($data){
            return  json(['code'=>200,'msg'=>'success','data'=>$data]);
        }else{
            return json(['code'=>500,'msg'=>'error','data'=>[]]);
        }


    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
//        接收数据
        $param['mid'] = input('mid');
        $param['uid'] = 1;
        $param['content'] = input('content');
//        验证评论长度是否少于5个文字
        if (strlen($param['content'])<15){
            return json(['code'=>500,'msg'=>'评论至少5个字','data'=>[]]);
        }
//        入库
        $res = Comment::create($param);
//        查询出要返回的数据
        $data = model('Movie')->join('comment',"movie.id=comment.mid","left")
            ->field('movie.*,count(comment.mid) as num')
            ->where('comment.mid',$param['mid'])
            ->find();
        $content = model('Comment')->field('content')->where('mid',$param['mid'])
            ->select();
        if ($res){
            return json(['code'=>200,'msg'=>'success','data'=>['data'=>$data,'content'=>$content]]);
        }else{
            return json(['code'=>500,'msg'=>'error','data'=>[]]);
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
//        查询电影详情，和评论数
        $data = model('Movie')->join('comment',"movie.id=comment.mid","left")
            ->field('movie.*,count(comment.mid) as num')
            ->where('comment.mid',$id)
            ->find();
//        查询电影评论的数据
        $content = model('Comment')->field('content')->where('mid',$id)
            ->select();
        if ($data){
            if ($content){
                return json(['code'=>200,'msg'=>'success','data'=>['data'=>$data,'content'=>$content]]);
            }
            return json(['code'=>200,'msg'=>'success','data'=>['data'=>$data]]);
        }else {
            return json(['code'=>500,'msg'=>'error','data'=>[]]);
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
