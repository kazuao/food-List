<?php
class Controller_Admin extends Controller_Template{
 /*初期Adiminユーザーを登録後、3～4行目と
 *18行目は削除して下さい。
 //アクセス制限
 public function before(){
 parent::before();
 //ログインしていなければ
 if(!Auth::check()){
 //ログインページへ移動
 Response::redirect('user/login');
 //ログインしていてもAdminでなければ
 }elseif(!Auth::member(100)){
 //user/indexページへ移動
 Response::redirect('user/index');
 }
 }
 初期ユーザー登録後、この行は削除します*/
 //トップページの表示
 public function action_index()
 {
 //テーマのインスタンス化
 $this->theme=\Theme::forge();
 //テーマにテンプレートのセット
 $this->theme->set_template('template');
 //テーマのテンプレートにタイトルをセット
 $this->theme->get_template()->set('title','Winroad徒然草');
 //テーマのテンプレートにビューとページデータをセット
 $this->theme->get_template()->set('content',$this->theme->view('admin/index',Model_Admin::pagedata()));
 return $this->theme;
 }
 //新規ユーザー登録
 public function action_create()
 {
 //POST送信なら
 if(Input::method() == 'POST')
 {
 //バリデーションの初期化
 $val=Model_Admin::validate('create');
 $val->add_field('password', 'パスワード', 'required|max_length[100]');
 //バリデーションOKなら
 if($val->run())
 {
 //POSTデータを受け取る
 $username=Input::post('username');
 $email=Input::post('email');
 $password=Input::post('password');
 $group=Input::post('group');
 //重複確認
 $username_count=Model_Admin::find()->where('username',$username)->count();
 $email_count=Model_Admin::find()->where('email',$email)->count();
 //ユーザー名が重複していたら
 if($username_count>0){
 Session::set_flash('error', 'ユーザー名が重複しています');
 Response::redirect('admin/create');
 }else{
 //Eメールアドレスが重複していたら
 if($email_count>0){
 Session::set_flash('error', 'Eメールアドレスが重複しています');
 Response::redirect('admin/create');
 }
 //Authのインスタンス化
 $auth=Auth::instance();
 //もしユーザー登録されたら
 if($auth->create_user($username,$password,$email,$group))
 {
 //登録成功のメッセージ
 Session::set_flash('success', '<span class="btn btn-primary span8">新規ユーザーの『'.$username.'』を追加しました</span><br>');
 //indexページへ移動
 Response::redirect('admin/index');
 }else{
 //データが保存されなかったら
 Session::set_flash('error', '登録されませんでした');
 }
 }
 }
 //バリデーションNGなら
 Session::set_flash('error', $val->show_errors());
 }
 //POST送信でなければ
 //テーマのインスタンス化
 $this->theme=\Theme::forge();
 //テーマにテンプレートのセット
 $this->theme->set_template('template');
 //テーマのテンプレートにタイトルをセット
 $this->theme->get_template()->set('title','Winroad徒然草');
 //テーマのテンプレートにビューとページデータをセット
 $this->theme->get_template()->set('content',$this->theme->view('admin/create'));
 return $this->theme;
 }
}
