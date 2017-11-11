<?php

class Controller_Top extends Controller_Public
{
  public function action_index()
  {
    $this->template->title = "food-List.";
    $this->template->content = View::forge('top/index');
  }
  public function action_updateSite()
  {
    $this->template->title = "更新履歴";
    $this->template->content = View::forge('top/updateSite');
  }

  public function action_inquiry()
  {
    $form = $this->forge_form();

		if (Input::method() === 'POST')
		{
			$form->repopulate();
		}
    $this->template->title = "お問い合わせ";
    $this->template->content = View::forge('top/inquiry');
    $this->template->content->set_safe('html_form', $form->build('top/confirm'));
    $this->template->header->topReverse = '../';
  }

  // フォームの定義
  public function forge_form()
  {
    $form = Fieldset::forge();

    $form->add('name', "名前")
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('no_tab_and_newline')
            ->add_rule('max_length', 50);

    $form->add('email', "メールアドレス")
            ->add_rule('trim')
            ->add_rule('required')
            ->add_rule('no_tab_and_newline')
            ->add_rule('max_length', 100)
            ->add_rule('valid_email');

    $form->add('comment', "コメント", ['type' => 'textarea', 'cols' => 70, 'rows' => 6])
            ->add_rule('required')
            ->add_rule('max_length', 400);

    $form->add('submit', '', ['type' => 'submit', 'value' => '確認', 'class' => 'btn btn-primary']);
    return $form;
  }

  public function action_confirm()
  {
    $form = $this->forge_form();
    $val = $form->validation()->add_callable('MyValidationRules');

    if($val->run())
    {
      $data['input'] = $val->validated();
      $this->template->title = "お問い合わせ: 確認";
      $this->template->content = View::forge('top/confirm', $data);
    }
    else
    {
      $form->repopulate();
      $this->template->title = "お問い合わせ: エラー";
      $this->template->content = View::forge('top/inquiry');
      $this->template->content->set_safe('html_error', $val->show_errors());
      $this->template->content->set_safe('html_form', $form->build('top/confirm'));
    }
  }

  public function action_send()
  {
    // CSRF対策
    if( ! Security::check_token())
    {
      throw new HttpInvalidInputException('ページ遷移が正しくありません');
    }
    $form = $this->forge_form();
    $val = $form->validation()->add_callable('MyValidationRules');
    if( ! $val->run())
    {
      $form->repopulate();
      $this->template->title = "お問い合わせ: エラー";
      $this->template->content = View::forge('top/inquiry');
      $this->template->content->set_safe('html_error', $val->show_errors());
      $this->template->content->set_safe('html_form', $form->build('top/confirm'));
      return;
    }

    $post = $val->validated();

    // メールの送信
    try
    {
      $mail = new Model_Mail();
      $mail->send($post);
      $this->template->title = "お問い合わせ: 送信完了";
      $this->template->content = View::forge('top/send');

      return;
    }
    catch(EmailValidationFailedException $e)
    {
      Log::error("メール検証エラー: {$e->getMessage()}", __METHOD__);
      $html_error = '<p>メールアドレスに誤りがあります。</p>';
    }
    catch(EmailSendingFailedException $e)
    {
      Log::error("メール送信エラー: {$e->getMessage()}", __METHOD__);
      $html_error = '<p>メールを送信できませんでした。</p>';
    }
    $form->repopulate();
    $this->template->title = "お問い合わせ: 送信エラー";
    $this->template->content = View::forge('top/inquiry');
    $this->template->content->set_safe('html_error', $html_error);
    $this->template->content->set_safe('html_form', $form->build('top/confirm'));
  }

  // ログインシステム
  public function action_login()
  {
    if(Auth::check()){
    //ログインページへ移動
    Response::redirect('user/');
    }

    $data = array();
    if ($_POST){
      // Authのインスタンス化
       $auth = Auth::instance();
      // 資格情報の確認
      if ($auth->login($_POST['username'],$_POST['password'])){
        if(isset($_POST['remember'])){
          // ユーザーを覚えてほしい？
          if (\Input::param('remember', false)){
            // remember-me クッキーを作成
            \Auth::remember_me();
          }else{
            // 存在する場合、 remember-me クッキーを削除
            \Auth::dont_remember_me();
          }
        }
        // 認証OKならトップページへ
        Response::redirect('user');
        }else{
        //認証が失敗したときの処理
        Session::set_flash('error', 'ユーザー名かパスワードが違います。再入力して下さい。');
        }
      }
    $this->template->title = "Login";
    $this->template->content = View::forge('top/login');
  }

  public function action_signup()
  {
    $message = [];

    if ($_POST){
      $username = Input::post('username');
      $password = Input::post('password');
      $email    = Input::post('email');

      $checked_un = Model_Users::get_find_username($username);
      $checked_em = Model_Users::get_find_email($email);

      //ユーザー名が重複していたら
      if($checked_un > 0){
        Session::set_flash('error', 'ユーザー名が重複しています');
        Response::redirect(Uri::base().'top/signup');
      }else{
        //Eメールアドレスが重複していたら
        if($checked_em > 0){
          Session::set_flash('error', 'Eメールアドレスが重複しています');
          Response::redirect(Uri::base().'top/signup');
        }
      // Authのインスタンス化
      $auth = Auth::instance();
      //ユーザー登録
      if($auth->create_user($username, $password, $email))
      {
        //登録成功のメッセージ
        Session::set_flash('success', '<span class="btn btn-primary span8">新規ユーザーの『'.$username.'』を追加しました</span><br>');
        //indexページへ移動
        Response::redirect(Uri::base().'top/login');
        }else{
          //データが保存されなかったら
          Session::set_flash('error', '登録されませんでした');
        }
      }
    }

    $this->template->title = "SignUp";
    $this->template->content = View::forge('top/signup');
  }

  public function action_fogetPassword()
  {


    $this->template->title = "Foget Password";
    $this->template->content = View::forge('top/fogetPassword');
  }
  public function action_googlelogin()
  {
  }

}
