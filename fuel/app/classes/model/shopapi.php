<?php

class Model_Shopapi extends \Model
{
  // マイページの処理
  public static function post_shops($shop_id){
    $json = json_decode(file_get_contents(
              "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&id={$shop_id}&format=json"));
// var_dump($json);exit;

    return $json;
  }

  // プルダウンメニューの町の一覧表示用
  public static function get_town_name()
  {
    // 現在ログインしているユーザーのuser_idを取得
    $user = Arr::get(Auth::get_user_id(),1);

    $query = DB::select('user_id','town_name')->from('shops')->where('user_id','=',$user)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();
    $query = array_column($query, 'town_name');

    return $query;
  }
  // プルダウンメニューのジャンルの一覧表示用
  public static function get_genre_name()
  {
    // 現在ログインしているユーザーのuser_idを取得
    $user = Arr::get(Auth::get_user_id(),1);

    $query = DB::select('user_id','genre')->from('shops')->where('user_id','=',$user)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();
    $query = array_column($query, 'genre');

    return $query;
  }

  public static function post_search($search){
    $search = htmlspecialchars($search, ENT_QUOTES,'UTF-8');;
    $search = mb_convert_kana($search, 's', 'UTF-8');
    $search_word = urlencode($search);

// var_dump($search_word);exit;
    $json = json_decode(file_get_contents(
              "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&keyword={$search_word}&format=json"));

    return $json;
  }

  public static function post_shop($shop_id){
    $shop_id = htmlspecialchars($shop_id, ENT_QUOTES,'UTF-8');;
    $shop_id = urlencode($shop_id);

    $json = json_decode(file_get_contents(
              "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&id={$shop_id}&format=json"));

    $shop_info = $json->results->shop[0];
    return $shop_info;
  }


  public static function post_mypage()
  {
    $user = Arr::get(Auth::get_user_id(),1);

    $query = DB::select('user_id','shop_id')->from('shops')->where('user_id','=',$user)->where('is_deleted', '=', false)
                  ->distinct()->execute()->as_array();
    $query = array_column($query, 'shop_id');

    return $query;
  }

  public static function get_shopDataApi($value)
  {
    $shop_id = urlencode($value);
    $json = json_decode(file_get_contents(
              "https://webservice.recruit.co.jp/hotpepper/gourmet/v1/?key=2138be60c330315f&id={$shop_id}&format=json"));
    $shop_info[] = $json->results->shop[0];

    return $shop_info;
  }

}
