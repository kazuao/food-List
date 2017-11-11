<?php

ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
ini_set('xdebug.var_display_max_depth', -1);

class Model_Shops extends \Model
{
  // 店を登録するAPI & DB 操作
  public static function post_shop($shop_data)
  {
    // API validation
    $shop_id = originfunction::h($shop_data['shop_id']);
    $shop_id = urlencode($shop_id);
    $json = json_decode(file_get_contents(
              "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&id={$shop_id}&format=json"));
    $shop_info = $json->results->shop[0];

    // visit_date
    $shop_visit_date = $shop_data['visit_date'];
    // star
    $star = $shop_data['star'];
    // total-price validation
    // 全て数字のみの英語のvalidationを追加する
    $shop_total_price = originfunction::h($shop_data['total_price']);
    // num-people validation
    // 数字のみ
    $shop_num_guests = originfunction::h($shop_data['num_guests']);
    // comment
    $comment = originfunction::h($shop_data['comment']);
    $shop_comment = nl2br($comment);

    // 現在のユーザーのuseridを取得する
    $get_user_id = Arr::get(Auth::get_user_id(),1);

    // DB登録部分
    $query = DB::insert('shops');
    $query->set([
      'user_id'    => $get_user_id,
      'shop_id'    => $shop_info->id,
      'shop_name'  => $shop_info->name,
      'town_name'  => $shop_info->small_area->name,
      'genre'      => $shop_info->genre->name,
      'visit_date' => $shop_visit_date,
      'star'       => $star,
      'payment'    => $shop_total_price,
      'num_guests' => $shop_num_guests,
      'comment'    => $shop_comment
    ]);
    $query->execute();

    // $shop_savedata = $query;
    $shop_savedata = [
      'user_id'      => $get_user_id,
      'shop_id'      => $shop_info->id,
      'shop_name'    => $shop_info->name,
      'town_name'    => $shop_info->small_area->name,
      'genre'        => $shop_info->genre->name,
      'visit_date'   => $shop_visit_date,
      'star'         => $star,
      'payment'      => $shop_total_price,
      'num_guests'   => $shop_num_guests,
      'comment'      => $shop_comment,
      'shop_pic'     => $shop_info->photo->pc->l,
      'shop_url'     => $shop_info->urls->pc,
      'shop_address' => $shop_info->address,
      'shop_open'    => $shop_info->open,
      'shop_access'  => $shop_info->access
    ];
    return $shop_savedata;
  }

  // 登録済み店舗(町)の情報を引き出す
  public static function post_town_search($value)
  {
    $user = Arr::get(Auth::get_user_id(),1);

    $town_name = DB::select('user_id', 'town_name')->from('shops')
                  ->where('user_id', '=', $user)->where('town_name', '=', $value)
                  ->distinct()->execute()->as_array();
    $town_name = array_column($town_name, 'town_name');
// var_dump($town_name);exit;
    $query = DB::select('user_id', 'shop_id', 'town_name')->from('shops')
                  ->where('user_id','=', $user)->where('town_name', '=', $town_name)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();
    $query = array_column($query, 'shop_id');

    return $query;
  }
  public static function post_genre_search($value)
  {
    $user = Arr::get(Auth::get_user_id(),1);

    $genre = DB::select('user_id', 'genre')->from('shops')
                  ->where('user_id', '=', $user)->where('genre', '=', $value)
                  ->distinct()->execute()->as_array();
    $genre = array_column($genre, 'genre');

    $query = DB::select('user_id','shop_id', 'genre')->from('shops')
                  ->where('user_id','=', $user)->where('genre', '=', $genre)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();

    $query = array_column($query, 'shop_id');

    return $query;
  }

  // 登録済みショップの全データ取得
  public static function get_shopdata($value)
  {
    $user = Arr::get(Auth::get_user_id(),1);

    $shop_info = DB::select('*')->from('shops')
                  ->where('user_id', '=', $user)->where('shop_id', '=', $value)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();
// var_dump($shop_info);exit;
    return $shop_info;
  }
  public static function get_shopdelete($value)
  {
    $user = Arr::get(Auth::get_user_id(),1);

    $query = DB::update('shops')->value('is_deleted', true)
                  ->where('user_id', '=', $user)->where('shop_id', '=', $value)->where('is_deleted', '=', false)
                  ->execute();
    return $query;
  }

  // 設定のusername取得
  public static function get_username()
  {
    $user = Arr::get(Auth::get_user_id(), 1);

    $query = DB::select('username')->from('users')
                  ->where('id', '=', $user)->execute()->as_array();
    $query = $query[0];

    return $query;
  }

  // usernameの変更
  public static function change_username($new_username)
  {
    $user = Arr::get(Auth::get_user_id(), 1);
    $new_username = originfunction::h($new_username);

    $query = DB::update('users')->value('username', $new_username)
              ->where('id', '=', $user)->execute();
    return $query;
  }

  // passwordの変更
  public static function change_pass($change_pass, $new_pass)
  {
    $changed_pass = \Auth::change_password($change_pass, $new_pass);
    if ($changed_pass > 0){
      $message = "パスワードを変更しました。";
    }else{
      $message = "パスワードは変更できませでした。";
    }
    return $message;
  }

  // 退会処理
  public static function unsub_member($unsub_member)
  {
    $query = \Auth::delete_user($unsub_member);

    return $query;
  }

}
