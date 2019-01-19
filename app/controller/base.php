<?php

namespace app\controller;

class base
{
    protected $app;

    protected $sys;

    protected $filter;

    protected $utils;

    protected $secret;

    protected $page;

    protected $loginInfo;

    protected $per = 30;

    public function __construct($app, $db_config)
	{
        $this->app = $app;

        # Отладка включена
        $this->app->set('handle_errors', false);

        # Инициализация библиотеки фильтрации безопасности
        $this->filter = new \system\util\Filter();

        # Инициализация библиотеки шифрования
        $this->secret = new \system\util\Secret();

        # Инициализация библиотеки инструментов
        $this->utils = new \system\util\Utils();

        # Инициализация конфигурации базы данных
        $app->db()->set_connection($db_config);

        # Автонастройка системы генерации кэша
        if (!file_exists('app/cache/sys_config_cache.php'))
        {
            $allSysData = $this->app->db()->select('roc_system', '*');

            $fileContent = '<?php'."\n".'$sys_config = array('."\n";

            foreach ($allSysData as $key => $value)
            {
                $fileContent .= "'".$value['name']."' => '".$value['value']."', \n";

                $this->sys[$value['name']] = $value['value'];
            }

            $fileContent .= ');'."\n ?>";

            file_put_contents('app/cache/sys_config_cache.php', $fileContent);
        }
        else
        {
            require 'app/cache/sys_config_cache.php';

            $this->sys = $sys_config;
        }

        # Инициализация шаблона
        $this->app->view()->tpl_dir = 'app/template/'.$this->sys['theme'].'/';

        # Суффикс файлов шаблона
        $this->app->view()->tpl_ext = '.tpl.php';

        # Каталог кэша шаблона
        $this->app->view()->cache_dir = 'app/cache/template/'.$this->sys['theme'].'/';

        # Время жизни кэша
        $this->app->view()->cache_time = 30;

        # Присвоение tpl переменной
        $this->app->set('tpl', ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/') .$this->app->view()->tpl_dir);

        # Назначение корневого каталога app
        $this->app->view()->assign('root', ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/'));

        # Назначение шаблона в каталог app
        $this->app->view()->assign('tpl', $this->app->get('tpl'));

        # Назначение css шаблону
        $this->app->view()->assign('css', $this->app->get('tpl').'assets/css/');

        # Назначение img шаблону
        $this->app->view()->assign('img', $this->app->get('tpl').'assets/img/');

        # Назначение js шаблону
        $this->app->view()->assign('js', $this->app->get('tpl').'assets/js/');

        # Получение информации о входе в систему
        $this->loginInfo = $this->isLogin($this->sys['rockey'], $_COOKIE);

        if ($this->loginInfo['uid'] > 0)
        {
            if (!isset($_COOKIE['today_sign']))
            {
                setcookie('today_sign', '1', strtotime(date('Y-m-d',time())) + 86400, '/');

                $this->updateLasttime($this->loginInfo['uid']);
            }

            $this->app->view()->assign('signStatus', $this->getSignStatus());

            $this->app->view()->assign('mine', $this->getMineInfo());
        }

        $this->app->view()->assign('sitename', $this->sys['sitename']);

        $this->app->view()->assign('keywords', $this->sys['keywords']);

        $this->app->view()->assign('description', $this->sys['description']);

        $this->app->view()->assign('ad', $this->filter->out($this->sys['ad']));

        $this->app->view()->assign('loginInfo', $this->loginInfo);
	}

    # Получить групп пользователей
    protected function getGroupName($groupid)
    {
        switch ($groupid)
        {
            case '0':
                return 'Забанен';

            case '1':
                return 'Пользователь';

            case '2':
                return 'Старожил';

            case '3':
                return 'VIP';

            case '9':
                return 'Администратор';

            default:
                return 'Забанен';
        }
    }

    # Получение баллов пользователями
    public function getScoreAction($type)
    {
        switch ($type)
        {
            case 1:
                return 'Создание топика';

            case 2:
                return 'Комментарий в топике';

            case 3:
                return 'Стимулирование посещений';

            case 4:
                return 'Отправка сообщения';

            case 5:
                return 'Нравится топик';

            case 6:
                return 'Удаление топика';

            case 7:
                return 'Удаление комментария';

            case 8:
                return 'Отмена';

            default:
                return 'Неизвестная операция';
        }
    }

    # Получение аватара
    protected function getUserAvatar($uid, $size = 100)
    {
        return ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/').'app/uploads/avatars/'.intval($uid/1000).'/'.$uid.'/'.$size.'.png?'.time();
    }

    # Теги топика
    protected function getTopicTag($tid)
    {
        return $this->app->db()->select('roc_topic_tag_connection', array(
            '[>]roc_tag' => 'tagid'
        ), 'roc_tag.tagname', array(
            'roc_topic_tag_connection.tid' => $tid
        ));
    }

    # Получение доступа к информации о пользователе
    protected function isLogin($sKey, $cookie)
    {
        $userInfo = array(
            'uid' => 0,

            'username' => '',

            'signature' => '',

            'groupid' => 0,

            'groupname' => '',

            'logintime' => 0,

            'avatar' => ''
        );

        if (isset($cookie['roc_login'], $cookie['roc_secure']))
        {
            $userArr = json_decode($this->secret->decrypt($cookie['roc_secure'], $sKey), true);

            if (count($userArr) == 4)
            {
                if ($cookie['roc_login'] == $userArr[1])
                {
                    $userInfo['uid'] = $userArr[0];

                    $userInfo['username'] = $userArr[1];

                    $userInfo['groupid'] = $userArr[2];

                    $userInfo['logintime'] = $userArr[3];

                    $userInfo['avatar'] = $this->getUserAvatar($userArr[0]);

                    $userInfo['groupname'] = $this->getGroupName($userArr[2]);
                }
            }
        }
        return $userInfo;
    }

    # Регистрация информации о пользователе
    protected function loginCookie($sKey, $uid, $username, $groupid)
    {
        $loginTime = time();

        setcookie('roc_login', $username, $loginTime + 604800, '/');

        $loginEncode = $this->secret->encrypt(json_encode(array(
            $uid,

            $username,

            $groupid,

            $loginTime
        )), $sKey);

        setcookie('roc_secure', $loginEncode, $loginTime + 604800, '/');
    }

    # Фильт ввода топика
    protected function topicIn($content)
    {
        return $this->filter->topicIn($content);
    }

    # Фильтр вывода топика
    protected function topicOut($content)
    {
        return $this->filter->topicOut($content);
    }

    # Извлечение фотографий
    protected function getPictures($str, $uid)
    {
        preg_match_all('/\[:([0-9]+)\]/i', $str, $attachment);

        foreach ($attachment[1] as $key => $value)
        {
            $res = $this->app->db()->get('roc_attachment', array(
                'uid',

                'path'
            ), array(
                'id' => $value
            ));

            if (!empty($res['path']) && $uid == $res['uid'])
            {
                $str = preg_replace('/\[:' . $value . '\]/i', '<a href="' . ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/') . $res['path'] . '" class="picPre"><img src="' . ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/') . $res['path'] . '.thumb.png" alt=""/></a>', $str);
            }
            else
            {
                $str = preg_replace('/\[:' . $value . '\]/i', '[ссылка не здесь битая или картина больше не существует]', $str);
            }
        }

        return $str;
    }

    # Получение уведомлений пользователем, сообщения, интеграция
    protected function getMineInfo()
    {
        return array(
            'notification' => $this->app->db()->count('roc_notification', array(
                'AND' => array(
                    'atuid' => $this->loginInfo['uid'],
                    'isread' => 0
                )
            )),
            'whisper' => $this->app->db()->count('roc_whisper', array(
                'AND' => array(
                    'atuid' => $this->loginInfo['uid'],
                    'isread' => 0
                )
            ))
        );
    }

    # Статус подписи
    protected function getSignStatus()
    {
        if ($this->app->db()->has('roc_score', array(
            'AND' => array(
                'uid' => $this->loginInfo['uid'],
                'type' => 3,
                'time[>]' => strtotime(date('d.m.Y', time()))
            )
        )))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    # Обновление последнего посещения
    protected function updateLasttime($uid, $time = 0)
    {
        $this->app->db()->update('roc_user', array(
            'lasttime' => $time > 0 ? $time : time()
        ), array(
            'uid' => $uid
        ));
    }

    # Обновление пользователей
    protected function updateUserScore($uid, $changed, $type)
    {
        $ori = $this->app->db()->get('roc_user', 'scores', array(
            'uid' => $uid
        ));

        $this->app->db()->beginTransaction();

        if ($changed > 0)
        {
            $this->app->db()->update('roc_user', array(
                'scores[+]' => $changed
            ), array(
                'uid' => $uid
            ));
        }
        else
        {
            $this->app->db()->update('roc_user', array(
                'scores[-]' => abs($changed)
            ), array(
                'uid' => $uid
            ));
        }

        $scoreArray = array(
            'uid' => $uid,

            'changed' => $changed,

            'remain' => ($changed > 0) ? ($changed + $ori) : $ori - abs($changed),

            'type' => $type,

            'time' => time()
        );

        $insertID = $this->app->db()->insert('roc_score', $scoreArray);

        $this->app->db()->checkResult($insertID);
    }

    # Сообщение о лайках
    protected function getTopicPraise($tid, $flag = true)
    {
        if($flag)
        {
            $praiseArray = $this->app->db()->select('roc_praise', array(
                '[>]roc_user' => 'uid'
            ), array(
                'roc_user.username(praiseUsername)',

                'roc_user.uid(praiseUid)'
            ), array(
                'roc_praise.tid' => $tid
            ));

            foreach ($praiseArray as $key => $value)
            {
                $praiseArray[$key]['praiseAvatar'] = $this->getUserAvatar($value['praiseUid'], 50);
            }

            return $praiseArray;
        }
        else
        {
            $praiseArray['count'] = $this->app->db()->count('roc_praise', 'id', array('roc_praise.tid' => $tid));

            $praiseArray['myPraise'] = $this->app->db()->has('roc_praise', array('AND'=>array('roc_praise.tid' => $tid, 'roc_praise.uid'=>$this->loginInfo['uid'])));

            return $praiseArray;
        }
    }

    # возврат json данных
    protected function showMsg($message, $type = 'success', $position = 0)
    {
        header("Content-type:text/html;charset=utf-8");

        die(json_encode(array(
            "result" => $type,
            "message" => $message,
            "position" => $position
        )));
    }

    # Набор информации страницы, параметры: int $current текущая страница, int $total общие, string $url URL страницы
    protected function setPage($current, $total, $url)
    {
        $params = array(
            'total_rows' => $total,

            'method' => 'html',

            'parameter' => ($this->app->get('root') == '/' ? $this->app->get('root') : $this->app->get('root').'/') . $url,

            'now_page' => $current,

            'list_rows' => $this->per,
        );

        $this->page = new \system\util\Page($params);

        $this->app->view()->assign('page', $this->page->show(2));
    }

    # Заголовок файла шаблона
	protected function setViewBase($title, $tpl)
	{
        $this->app->view()->assign('title', $title);

        $this->app->view()->assign('tpl_status', $tpl);

        $this->app->view()->display($tpl);
	}
}

?>
