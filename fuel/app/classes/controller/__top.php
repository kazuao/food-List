<?php

class Controller_Top extends Controller_Public
{
  public function action_index()
  {
    $this->template->title = "food-List.";
    $this->template->content = View::forge('top/index');
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

    $form->add('submit', '', ['type' => 'submit', 'value' => '確認']);
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
    //既にログイン済みであれば会員トップページにリダイレクト
    Auth::check() && Response::redirect('member');

    $data = array();

    if (!empty($_POST))
      {
      // Authのインスタンス化
       $auth = Auth::instance();
      // 資格情報の確認
      if ($username !== null && $password !== null)
        {
          $username = Input::post('username');
          $password = Input::post('password');
          $auth = Auth::instance();
          if ($auth->login($username, $password)){
            // 認証OKならトップページへ
            Response::redirect('user');
          }
           $data['error'] = 'ログイン失敗に失敗しました';
        }else{
          //認証が失敗したときの処理
          $data['username'] = $_POST['username'];
          $data['login_error'] = 'ユーザー名かパスワードが違います。再入力して下さい。';
        }
      }

    $this->template->title = "Login";
    $this->template->content = View::forge('top/login', $data);
  }

  public function action_signup()
  {
    if(Input::method() == 'POST'){
      //POSTデータを受け取る
      $username=Input::post('username');
      $email=Input::post('email');
      $password=Input::post('password');
      //重複確認
      $username_count=Model_Users::find()->where('username',$username)->count();
      $email_count=Model_Users::find()->where('email',$email)->count();
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
          if($auth->create_user($username,$password,$email,$group)){
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
