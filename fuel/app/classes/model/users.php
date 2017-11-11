<?php

class Model_Users extends \Model
{
  public static function get_find_username($username)
  {
    $username = originfunction::h($username);

    $query = DB::select('username')->from('users')
                  ->where('username', '=', $username)->execute()->as_array();
    $count = count($query);

    return $count;
  }

  public static function get_find_email($email)
  {
    $email = originfunction::h($email);

    $query = DB::select('email')->from('users')
                  ->where('email', '=', $email)->execute()->as_array();
    $count = count($query);

    return $count;
  }
}
