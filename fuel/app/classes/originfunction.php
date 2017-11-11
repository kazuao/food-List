<?php

class originfunction{
  public static function h($s)
    {
      return htmlspecialchars($s, ENT_QUOTES,'UTF-8');
    }

    public function __toString()
    {
      try {
          return (string) $this->name;
      } catch (Exception $exception) {
          return '';
      }
  }
}
