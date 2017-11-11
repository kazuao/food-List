<?php

class customException extends Exception{
  function __toString() {
    throw new Exception;
  }
}

try {
  $hoge = new customException;
  echo $hoge;
} catch (Exception $e) {
}
