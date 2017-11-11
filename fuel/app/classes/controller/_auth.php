<?php
class Controller_Auth extends Controller_Public
{
  public function action_oauth($provider = null){
    // 呼び出すための OAuth プロバイダを持っていない場合は出て行く
    if ($provider === null)
    {
      \Messages::error(__('login-no-provider-specified'));
      \Response::redirect_back();
    }
    // Opauth の読み込み、プロバイダのストラテジーを読み込みプロバイダにリダイレクトするでしょう
    \Auth_Opauth::forge();
  }

  public function action_callback()
  {
    try
    {
      // Opauth オブジェクトを取得
      $opauth = \Auth_Opauth::forge(false);
      // コールバックを処理
      $status = $opauth->login_or_register();
      // メッセージを表示できるように opauth 応答からプロバイダ名を取得
      $provider = $opauth->get('auth.provider', '?');

      // コールバック処理の結果を扱う
      switch ($status)
      {
        // ローカルのユーザがログインしていて、プロバイダはこのユーザーと関連付けられている
        case 'linked':
            // 関連付けが正常に行われたことをユーザに通知
            \Messages::success(sprintf(__('login.provider-linked'), ucfirst($provider)));
            // そして、この状態のためのリダイレクト URL を設定
            $url = 'dashboard';
        break;

        // 既知のプロバイダへ関連付けられ、そのアカウントでログイン
        case 'logged_in':
            // プロバイダを使用してログインが成功したことをユーザーに通知
            \Messages::success(sprintf(__('login.logged_in_using_provider'), ucfirst($provider)));
            // そして、この状態のためのリダイレクト URL を設定
            $url = 'dashboard';
        break;

        // このプロバイダでのログインは知らないので、最初にユーザーにローカルアカウントを作成するように依頼
        case 'register':
            // プロバイダを使用してログインが成功したことをユーザーに通知、しかし、続けるにはローカルアカウントが必要です
            \Messages::info(sprintf(__('login.register-first'), ucfirst($provider)));
            // そして、この状態のためのリダイレクト URL を設定
            $url = 'users/register';
        break;

        // このプロバイダでのログインは知らなかったが、十分な情報が返されたのでユーザーを自動的に登録した
        case 'registered':
            // プロバイダを使用してログインが成功したことをユーザーに通知、そして、ローカルアカウントが作成された
            \Messages::success(__('login.auto-registered'));
            // そして、この状態のためのリダイレクト URL を設定
            $url = 'dashboard';
        break;

        default:
          throw new \FuelException('Auth_Opauth::login_or_register() has come up with a result that we dont know how to handle.');
      }
      // リダイレクト先の URL をセット
      \Response::redirect($url);
    }
    // Opauth の例外を処理
    catch (\OpauthException $e)
    {
        \Messages::error($e->getMessage());
        \Response::redirect_back();
    }
    // 認証の試みをユーザーが取り消しをしたことを捕捉 (一部のプロバイダはこれを許可)
    catch (\OpauthCancelException $e)
    {
        // おそらく、ここでもう少しきれいな何かをする必要があります...
        exit('It looks like you canceled your authorisation.'.\Html::anchor('users/oath/'.$provider, 'Click here').' to try again.');
    }
  }

  public function action_register()
  {
    // 登録が有効？
    if ( ! \Config::get('application.user.registration', false))
    {
      // ユーザ登録ができないことをお知らせ
      \Messages::error(__('login.registation-not-enabled'));
      // そして、前のページ (またはホームページ) に戻る
      \Response::redirect_back();
    }

    // 登録用フィールドセットを作成
    $form = \Fieldset::forge('registerform');
    // CSRF 攻撃を防ぐために CSRF トークンを追加
    $form->form()->add_csrf();
    // そしてモデルのプロパティを持つフォームを投入
    $form->add_model('Model\\Auth_User');
    // そして、フルネームフィールド、それは、ユーザーのプロパティではなくプロファイルのプロパティ
    $form->add_after('fullname', __('login.form.fullname'), array(), array(), 'username')->add_rule('required');
    // パスワードの確認フィールドを追加
    $form->add_after('confirm', __('login.form.confirm'), array('type' => 'password'), array(), 'password')->add_rule('required');
    // パスワードは必要なので確認
    $form->field('password')->add_rule('required');
    // そして、新規ユーザーは彼らが属しているグループを選択できません (当たり前じゃないか)
    $form->disable('group_id');
    // それはフォーム上にはないので、それの不足で検証が失敗しないように
    $form->field('group_id')->delete_rule('required')->delete_rule('is_numeric');
    // セッションからの OAuth プロバイダを取得 (存在する場合)
    $provider = \Session::get('auth-strategy.authentication.provider', false);
    // プロバイダ情報を保持している場合、加えてログインフィールドセットも作成
    if ($provider)
    {
        // OAuth ストラテジーからユーザー名を渡されたのでそれを無効にする
        $form->field('username')->set_attribute('readonly', true);
        // 追加のログインフォームを作成し、既存のアカウントとプロバイダを関連付け
        $login = \Fieldset::forge('loginform');
        $login->form()->add_csrf();
        $login->add_model('Model\\Auth_User');
        // ユーザー名とパスワードだけでいい
        $login->disable('group_id')->disable('email');
        // それらはフォーム上にはないので、それらの不足で検証が失敗しないように
        $login->field('group_id')->delete_rule('required')->delete_rule('is_numeric');
        $login->field('email')->delete_rule('required')->delete_rule('valid_email');
    }
    // 登録フォームが投稿された？
    if (\Input::method() == 'POST')
    {
        // ログインフォームが投稿された？
        if ($provider and \Input::post('login'))
        {
            // 資格情報のチェック
            if (\Auth::instance()->login(\Input::param('username'), \Input::param('password')))
            {
                // 現在ログインしているユーザーの ID を取得
                list(, $userid) = \Auth::instance()->get_user_id();
                // 手動でプロバイダと関連付け
                $this->link_provider($userid);
                // 関連付けたことをユーザーに通知
                \Messages::success(sprintf(__('login.provider-linked'), ucfirst($provider)));
                // ログインし、あなたたちがやってきたところか、
                // 分らない場合はユーザーのダッシュボードへ戻る
                \Response::redirect_back('dashboard');
            }
            else
            {
                // ログイン失敗、エラーメッセージを表示
                \Messages::error(__('login.failure'));
            }
        }
        // 登録フォームが投稿された？
        elseif (\Input::post('register'))
        {
            // 入力を検証
            $form->validation()->run();
            // 検証済みの場合、ユーザーを作成
            if ( ! $form->validation()->error())
            {
                try
                {
                    // ユーザーを作成するために Auth を呼び出す
                    $created = \Auth::create_user(
                        $form->validated('username'),
                        $form->validated('password'),
                        $form->validated('email'),
                        \Config::get('application.user.default_group', 1),
                        array(
                            'fullname' => $form->validated('fullname'),
                        )
                    );
                    // ユーザーが正常に作成された場合
                    if ($created)
                    {
                        // ユーザに通知
                        \Messages::success(__('login.new-account-created'));
                        // そして、前のページか、前のページがない場合は
                        // アプリケーションのダッシュボードを表示
                        \Response::redirect_back('dashboard');
                    }
                    else
                    {
                        // おっと、新しいユーザーの作成に失敗しましたか？
                        \Messages::error(__('login.account-creation-failed'));
                    }
                }
                // create_user() の呼び出し時の例外を捕捉
                catch (\SimpleUserUpdateException $e)
                {
                    // メールアドレスが重複
                    if ($e->getCode() == 2)
                    {
                        \Messages::error(__('login.email-already-exists'));
                    }
                    // ユーザー名が重複
                    elseif ($e->getCode() == 3)
                    {
                        \Messages::error(__('login.username-already-exists'));
                    }
                    // これは起こり得ないが、ずっとそうとは限らない...
                    else
                    {
                        \Messages::error($e->getMessage());
                    }
                }
            }
        }
        // 検証失敗、ポストされたデータをフォームへ再投入
        $form->repopulate();
    }
    else
    {
        // セッションから (コールバックにより作成された) auth-strategy データを取得
        $user_hash = \Session::get('auth-strategy.user', array());
        // プロバイダのコールバックからのデータを登録フォームへ投入
        $form->populate(array(
            'username' => \Arr::get($user_hash, 'nickname'),
            'fullname' => \Arr::get($user_hash, 'name'),
            'email' => \Arr::get($user_hash, 'email'),
        ));
    }
    // フォームにフィールドセットを渡し、新規ユーザの登録ビューを表示
    return \View::forge('login/registration')->set('form', $form, false)->set('login', isset($login) ? $login : null, false);
  }

  protected function link_provider($userid)
  {
    // 一致する認証ストラテジーを持っているか？
    if ($authentication = \Session::get('auth-strategy.authentication', array()))
    {
        // ストラテジーの呼び出しではなくオブジェクトのインスタンスが必要なので false を渡すことを忘れないでください
        $opauth = \Auth_Opauth::forge(false);
        // ローカルユーザーとプロバイダのログインを関連付けるため Opauth を呼び出す
        $insert_id = $opauth->link_provider(array(
            'parent_id' => $userid,
            'provider' => $authentication['provider'],
            'uid' => $authentication['uid'],
            'access_token' => $authentication['access_token'],
            'secret' => $authentication['secret'],
            'refresh_token' => $authentication['refresh_token'],
            'expires' => $authentication['expires'],
            'created_at' => time(),
        ));
    }
  }
}
