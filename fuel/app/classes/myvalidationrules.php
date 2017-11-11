<?php

class MyValidationRules
{
	/**
	 * 改行コードやタブが含まれていないかの検証ルール
	 *
	 * @param string $value
	 * @return boolean
	 */
	public static function _validation_no_tab_and_newline($value)
	{
		// 改行コードやタブが含まれていないか
		if (preg_match('/\A[^\r\n\t]*\z/u', $value) === 1)
		{
// echo "1";
			// 含まれていない場合はtrueを返す
			return true;
		}
		else
		{
// echo "2";
			// 含まれている場合はfalseを返す
			return false;
		}
	}
}
