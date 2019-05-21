<?php

namespace App\Admin\Controllers;

use App\Model\FirmModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
class FirmController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new FirmModel);

        $grid->f_id('F id');
        $grid->firm_name('Firm name');
        $grid->firm_username('Firm username');
        $grid->firm_tax('Firm tax');
        $grid->firm_account('Firm account');
        $grid->firm_business('Firm business');
        $grid->app_id('App id');
        $grid->key('Key');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(FirmModel::findOrFail($id));

        $show->f_id('F id');
        $show->firm_name('Firm name');
        $show->firm_username('Firm username');
        $show->firm_tax('Firm tax');
        $show->firm_account('Firm account');
        $show->firm_business('Firm business');
        $show->app_id('App id');
        $show->key('Key');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new FirmModel);

        $form->text('firm_name', 'Firm name');
        $form->text('firm_username', 'Firm username');
        $form->text('firm_tax', 'Firm tax');
        $form->text('firm_account', 'Firm account');
        $form->text('firm_business', 'Firm business');
        $form->text('app_id', 'App id');
        $form->text('key', 'Key');

        return $form;
    }
    //注册展示
    public function reglist(){
        $info=FirmModel::all();
       // dd($info);
        return view('admin.admin.reg',['info'=>$info]);
    }
    //审核执行
    public function audit(){
        $id=$_POST['id'];
         //dd($id);
         $data=FirmModel::where(['f_id'=>$id])->first();
            if($data->app_id==''&&$data->key==''){
                $info=[
                    'app_id'=>$this->appid(),
                    'key'=>$this->key(),
                    'status'=>2
                ];
                $res=FirmModel::where(['f_id'=>$id])->update($info);
                if($res){
                    $arr=[
                        'error'=>1,
                        'msg'=>'审核成功'
                    ];
                    return $arr;
                }else{
                    $arr=[
                        'error'=>2,
                        'msg'=>'审核失败'
                    ];
                    return $arr;
                }
            }else{
                $arr=[
                    'error'=>2,
                    'msg'=>'准备进行审核'
                ];
                return $arr;
            }
    }
       //生成appid
       function appid(){
        $str=Str::random(10);
        return $str;
    }
    //生成key
    function key(){
        $str=Str::random(10);
        $key=substr(time().$str,5,10);
        return $key;
    }
}
