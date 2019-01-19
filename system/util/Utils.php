<?php
# Утилиты

namespace system\util;

class Utils
{
    /**
     * Время выполнения
     * @return string
     */
    public function runtime()
    {
        global $sys_starttime;

        $mtime       = explode(' ', microtime());

        $sys_runtime = number_format(($mtime[1] + $mtime[0] - $sys_starttime), 4);

        unset($sys_starttime);

        return $sys_runtime . 's';
    }

    /**
     * Односторонний криптографическая функция (тройное заначение)
     * @param $str
     * @param string $salt
     * @return string
     */
    public function encrypt($str, $salt = 'rocboss')
    {
        return md5(md5(md5($str . $salt) . $salt) . $salt);
    }

    /**
     * Генерация случайного кода заданной длины
     * @param int $n
     * @return string
     */
    public function getRandomCode($n = 32)
    {
        return substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $n);
    }

    /**
     * Проверка email
     * @param string $email
     * @return boolean
     */
    public function checkEmailValidity($email)
    {
        $pattern = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";

        return preg_match($pattern, $email);
    }

    /**
     * Проверка логина
     * @param string $nickname
     * @return boolean
     */
    public function checkNickname($nickname)
    {
        if (strlen($nickname) < 3 || $this->getStrlen($nickname) < 2)
        {
            return 'Логин слишком короткий';
        }
        if ($this->getStrlen($nickname) > 10)
        {
            return 'Логин слишком длинный';
        }
        if (preg_match('/\s/', $nickname) || strpos($nickname,' '))
        {
            return 'В логине не допускаются пробелы';
        }
        if (is_numeric(substr($nickname, 0, 1)) || substr($nickname, 0, 1) == "_")
        {
            return 'Логин не может начинаться с цифры и подчеркивания';
        }
        if (substr($nickname, -1, 1) == "_")
        {
            return 'Логин не может заканчиваться символом подчеркивания';
        }
        if (!preg_match('/^[\x{4e00}-\x{9fa5}_a-zA-Z0-9]+$/u', $nickname))
        {
            return 'В логине можно использовать только китайские иероглифы, алатиницу, цифры и символы подчеркивания';
        }
        for ($i = 0, $l = $this->getStrlen($nickname); $i < $l; $i++)
        {
            if ($this->textCount($nickname, $this->getSubstr($nickname, $i, 1)) > 4)
            {
                return 'В логине слишком много повторяющихся символов';
            }
        }
        return '';
    }

    /**
     * Текущая вкладка
     * @return int
     */
    public function getCurrentPage()
    {
        return isset($GLOBALS['Router']['params']['page']) && intval($GLOBALS['Router']['params']['page']) > 0 ? intval($GLOBALS['Router']['params']['page']) : 1;
    }

    /**
     * Разбиение строк
     * @param string $str
     * @param int $start
     * @param int $len
     * @return string
     */
    public function getSubstr($str, $start, $len)
    {
        return mb_substr($str, $start, $len, 'utf-8');
    }

    /**
     * Формат времени
     * @param string $unixTime
     * @return string
     */
    public function formatTime($unixTime)
    {
        $showTime = date('j', $unixTime) . "." . date('m', $unixTime) . ".". date('Y', $unixTime) . " в " . date('H:i', $unixTime);

        if (date('Y', $unixTime) == date('Y'))
        {
            $showTime = date('j', $unixTime) . "." . date('m', $unixTime) . ".". date('Y', $unixTime) . " в " . date('H:i', $unixTime);

            if (date('n.j', $unixTime) == date('n.j'))
            {
                $timeDifference = time() - $unixTime + 1;

                if ($timeDifference < 60)
                {
                    return $timeDifference . " сек.назад";
                }
                if ($timeDifference >= 60 && $timeDifference < 3600)
                {
                    return floor($timeDifference / 60) . " мин.назад";
                }
                return date('H:i', $unixTime);
            }
            if (date('n.j', ($unixTime + 86400)) == date('n.j'))
            {
                return "вчера " . date('H:i', $unixTime);
            }
        }
        return $showTime;
    }

    /**
     * Автосигмент
     * @param string $str_cut
     * @param int $length
     * @return string
     */
    public function cutSubstr($str_cut, $length = 64)
    {
        $str_cut = preg_replace('/(\[\:[0-9]+\])/i', 'изображение', $str_cut);

        $str_cut = preg_replace('/\[p\]/i', ' ', $str_cut);

        if (mb_strlen(trim($str_cut), 'utf8') > $length)
        {
            return trim(mb_substr($str_cut, 0, $length, 'utf-8')) . '...';
        }
        else
        {
            return trim($str_cut);
        }
    }

    /**
     * Длина строки
     * @param string $str
     * @return int
     */
    public function getStrlen($str)
    {
        return mb_strlen($str, "utf-8");
    }

    /**
     * Вхождение подстроки
     * @param string $str
     * @param string $needle
     * @return int
     */
    public function textCount($str, $needle)
    {
        return mb_substr_count($str, $needle, 'utf-8');
    }

    /**
     * Анализ URL
     * @param string $str
     * @return string
     */
    public function parseUrl($str)
    {
        $auto_arr = array(
            "/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",
            "/(?<=[^\]a-z0-9\/\-_.~?=:.])([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
        );
        $auto_url = array(
            '<a href="\\1\\3" target="_blank" class="url">\\1\\3</a>',
            '<a href="mailto:\\0" class="url">\\0</a>'
        );
        return preg_replace($auto_arr, $auto_url, ' ' . $str);
    }

    /**
     * @пользователь
     * @param string $str
     * @return string
     */
    public function parseUser($str)
    {
        return preg_replace_callback('/\@([^[:punct:]\s]{3,39})([\s]+)/', array($this, 'atName'), $str . ' ');
    }

    /**
     * @метод обратного вызова callback пользователя
     * @param string $str
     * @return string
     */
    public function atName($str)
    {
        if (in_array($str[1], array(
            "。",
            "？",
            "，",
            "！"
        ))) {
            return $str[0];
        }
        return '<span class=atname><a href="/@' . urlencode($str[1]) . '">@' . $str[1] . '</a></span>' . $str[2];
    }
}
?>
