<?php

// ini_set('xdebug.var_display_max_children', -1);
// ini_set('xdebug.var_display_max_data', -1);
// ini_set('xdebug.var_display_max_depth', -1);

class Controller_User extends Controller_Public
{
  public function before()
  {
    parent::before();
    $this->response = Response::forge();
    $this->response->set_header('X-FRAME-OPTIONS', 'SAMEORIGIN');

    //認証していなかったら
    if(!Auth::check()){
    //ログインページへ移動
    Response::redirect('top/login');
    }
  }

  public function action_logout()
  {
  //ログアウト
  Auth::logout();
  //ログアウト画面の表示
  $this->template->title = "food-List.";
  $this->template->content = View::forge('top/index');
  }

  // トップページの処理
  public function action_index()
  {
    $data_list[] = Model_Shopapi::post_mypage();

    foreach ($data_list as $value) {
      foreach ($value as $val) {
        $json[] = Model_Shopapi::post_shops($val);
      }
    }
    //ビュークラスのforgeメソッドの呼び出し
    if (isset($json)){
      $view = View::forge('user/index', $json);
      $view->json = $json;
    }else{
      $view = View::forge('user/index');

    }
    //ビューファイルのネスト
    $this->template->title = "food-List.";
    $this->template->content = $view;

    return $view;
  }

  // 登録している店舗の検索トップ画面
  public function action_search()
  {
    $town_data  = Model_Shopapi::get_town_name();
    $genre_data = Model_Shopapi::get_genre_name();

    $view = View::forge('user/search');
    $view->town_data  = $town_data;
    $view->genre_data = $genre_data;

    $this->template->title = "登録店舗検索";
    $this->template->content = $view;

    return $view;
  }

  // プルダウンから検索ページ
  public function action_pulltown()
  {
    $value = Input::get('town_name');

    $town_data  = Model_Shopapi::get_town_name();
    $genre_data = Model_Shopapi::get_genre_name();

    $town = Model_shops::post_town_search($value);

    foreach ($town as $value) {
      if(is_array($value)){
        foreach ($value as $val) {
        $json[] = Model_Shopapi::post_shops($val);
        }
      } else {
        $json[] = Model_Shopapi::post_shops($value);
      }
      if( ! isset($json) or empty($json)){
        $json = "";
        Session::set_flash('error', '店舗が存在しません。');
      }
    }
    $view = View::forge('user/search');
    $view->town_data  = $town_data;
    $view->genre_data = $genre_data;
    $view->json = $json;

    $this->template->title = "登録タウン一覧表示";
    $this->template->content = $view;

    return $view;
  }
  public function action_pullgenre()
  {
    $value = Input::get('genre');

    $town_data  = Model_Shopapi::get_town_name();
    $genre_data = Model_Shopapi::get_genre_name();

    $genre = Model_shops::post_genre_search($value);

    foreach ($genre as $value) {
      if(is_array($value)){
        foreach ($value as $val) {
        $json[] = Model_Shopapi::post_shops($val);
        }
      } else {
        $json[] = Model_Shopapi::post_shops($value);
      }
      if( ! isset($json) or empty($json)){
        $json = "";
        Session::set_flash('error', '店舗が存在しません。');
      }
    }
    $view = View::forge('user/search');
    $view->town_data  = $town_data;
    $view->genre_data = $genre_data;
    $view->json = $json;

    $this->template->title = "登録ジャンル一覧表示";
    $this->template->content = $view;

    return $view;
  }

  // 登録したい店舗を検索するページ
  public function action_register()
  {
    $view = View::forge('user/register');

    $this->template->title = '店舗登録';
    $this->template->content = $view;

    return $view;
  }
  // 検索したページ
  public function action_shopsearch()
  {
    $search = Input::post('name-search');
    $json['json'] = Model_Shopapi::post_search($search);

    if(empty($json['json']->results->shop)){
      Session::set_flash('error', 'お店がありませんでした。');
    }
    $view = View::forge('user/register', $json);

    $this->template->title = "登録店舗検索";
    $this->template->content = $view;

    return $view;
  }

  // 実際に登録する画面
  public function action_shopregi()
  {
    $shop_id = Input::get('id');
    $data['shop_info'] = Model_Shopapi::post_shop($shop_id);
    $apiKey = \Def_Secret::GOOGLE_API_KEY;

    $view = View::forge('user/shopRegi', $data);
    $view->apiKey = $apiKey;

    $this->template->title = '店舗登録ページ';
    $this->template->content = $view;


    return $view;
  }

  // 登録後画面
  public function action_saveshop()
  {
    $shop_data = Input::post();
    $data['shop_info'] = Model_shops::post_shop($shop_data);
    $apiKey = \Def_Secret::GOOGLE_API_KEY;

    $view = View::forge('user/saveshop', $data);

    $view->apiKey = $apiKey;

    $this->template->title = 'お店を登録しました。';
    $this->template->content = $view;

    Session::set_flash('success', 'お店を登録しました！');

    return $view;
  }

  // 登録してある店舗の確認、編集画面
  public function action_shop()
  {
    $shop_id = Input::get('id');
    $shop_data = Model_Shops::get_shopdata($shop_id);
    $shop_info = Model_shopapi::get_shopdataapi($shop_id);
    $apiKey = \Def_Secret::GOOGLE_API_KEY;

    $view = View::forge('user/shop');
    $view->shop_data = $shop_data[0];
    $view->shop_info = $shop_info[0];
    $view->apiKey = $apiKey;

    $this->template->title = "food-List.";
    $this->template->content = $view;

    return $view;
  }

  // 登録してある店舗の論理削除
  public function action_shopdelete()
  {
    $shop_id = Input::get('id');
    $shop_delete = Model_Shops::get_shopdelete($shop_id);

    $view = View::forge('user/shopdelete');

    if($shop_delete > 0){
      $this->template->title = '削除しました。';
      $view->message = '削除しました。';
    }else{
      $this->template->title = '削除できませんでした。';
      $view->message = '削除できませんでした。';
    }

    $this->template->content = $view;

    return $view;
  }

  //　設定画面
  public function action_config()
  {
    $username = Model_Shops::get_username();

    $view = View::forge('user/config');
    $view->username = $username;

    $this->template->title = '設定';
    $this->template->content = $view;

    return $view;
  }
  // ユーザネーム変更
  public function action_changeUsername()
  {
    $new_username = Input::post('change_username');
    $changed_username = Model_Shops::change_username($new_username);

    $view = View::forge('user/config');

    if($changed_username > 0){
      $view->id_message = "ユーザネームは変更されました。";
    }else{
      $view->id_message = "ユーザネームは変更できませんでした。";
    }
    $username = Model_Shops::get_username();
    $view->username = $username;

    $this->template->title = '設定';
    $this->template->content = $view;

    return $view;
  }

  // パスワード変更
  public function action_changePass()
  {
    $username = Model_Shops::get_username();
    $change_pass1 = Input::post('change_pass1');
    $change_pass2 = Input::post('change_pass2');
    $change_pass3 = Input::post('change_pass3');

    if($change_pass2 == $change_pass3){
      $new_pass = $change_pass2;
      $message = Model_Shops::change_pass($change_pass1, $new_pass);
    }else{
      $message = "新しいパスワードは同じものを入力してください。";
    }
    $view = View::forge('user/config');
    $view->username = $username;
    $view->pass_message = $message;

    $this->template->title = '設定';
    $this->template->content = $view;

    return $view;
  }

  // 退会処理
  public function action_deleteUser()
  {
    $unsub_member = Input::post('unsub_username');
    $unsub = Model_Shops::unsub_member($unsub_member);

    if($unsub> 0){
      $view = View::forge('index');
      $this->template->title = '退会しました。';
    }else{
      $view = View::forge('user/config');
      $view->unsub_message = "退会できませんでした。";

      $this->template->title ='退会できませんでした。';
    }
    $this->template->content = $view;

    return $view;
  }

  public function after($response)
  {
    $response = parent::after($response);
    // $response = $this->response;
    $response->body = $this->template;
    return parent::after($response);
  }

  public function __toString()
    {
      Session::set_flash('error', '');
      return;
    }
}
