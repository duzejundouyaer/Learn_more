<?php

namespace frontend\controllers;
use Yii;
use frontend\models\Type;
class CateController extends \yii\web\Controller
{
	#404时调用
	public $enableCsrfValidation = false;
	#禁用Yii框架的样式
	public $layout = false;
    //分类列表
    public function actionCate()
    {
        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        //print_r($data);die;
        return $this->render('cate',['data'=>$data]);
    }
    //添加分类
    public function actionAddcate()
    {
        $request=Yii::$app->request;
        if($request->isPost) {
            $data = Yii::$app->request->post();
            $article = new Type();
            $article->type_name = $data['type_name'];
            $article->parent_id = $data['parent_id'];
            $article->type_is_show = $data['type_is_show'];
            $article->type_sort = $data['sort'];
            $res=$article->save();
            if($res){
                return $this->redirect("?r=cate/cate");
            }else{

            }
        }else{
            $type=new Type();
            $info=$type::find()->asArray()->all();
            $data=$this->recursion($info);
            return $this->render('addcate',['type'=>$data]);
        }

    }
    //删除分类
    public function actionDetele(){
        $id = Yii::$app->request->post('id');
        //删除一条
        $res = Type::findOne($id)->delete();
        if($res){
            $info=[
                'code'=>1000,
                'arr'=>"删除成功"
            ];
            return json_encode($info);
        }else{
            $info=[
                'code'=>1001,
                'arr'=>"删除失败！"
            ];
            return json_encode($info);
        }
    }
    //修改分类
    public function actionCateedit()
    {
    	return $this->render('cateedit');
    }


    public function recursion($data,$path=0,$flag=1){
        static $arr=array();
        foreach($data as $key=>$val){
            if($val['parent_id']==$path){
                $val['flag']=$flag;
                $arr[]=$val;
                $this->recursion($data,$val['type_id'],$flag+1);
            }
        }
        return $arr;
    }

}
