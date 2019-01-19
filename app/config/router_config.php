<?php

# Маршрутизация
$router_config = array(
    # Главная страница
    '/(@page:[0-9])' => array('home', 'index'),

    # Главная страница (подробнее)
    '/read/@tid:[0-9]+' => array('home', 'read'),

    # Главная страница (теги)
    '/tag/@name(/@page:[0-9]+)' => array('home', 'tag'),

    # Главная страница (поиск)
    '/search/@s(/@page:[0-9]+)' => array('home', 'search'),

    # Настройки пользователя
    '/setting(/@type)' => array('setting', 'index'),

    # Сортировка (недавно опубликовано)
    '/do/posttime' => array('doController', 'posttime'),

    # Сортировка (последнее сообщение)
    '/do/lasttime' => array('doController', 'lasttime'),

    # Авторизация
    '/login' => array('user', 'login'),

    # Выход
    '/logout' => array('user', 'logout'),

    # Регистрация
    '/register' => array('user', 'register'),

    # Авторизация через QQ
    '/qqlogin' => array('user', 'qqlogin'),

    # Уведомления пользователя
    '/notification(/@status:0|1(/@page:[0-9]+))' => array('user', 'notification'),

    # Личное сообщение
    '/whisper(/@status:0|1|2(/@page:[0-9]+))' => array('user', 'whisper'),

    # Страница пользователя
    '/@@username' => array('user', 'transUser'),

    # Страница пользователя
    '/user(/@uid:[0-9]+)' => array('user', 'index'),

    # Отметить напоминание как прочитанное
    '/do/readNotification/@nid:[0-9]+' => array('doController', 'readNotification'),

    # Топики пользователя
    '/user(-@uid:[0-9]+)-topic(-@page:[0-9]+)' => array('user', 'topic'),

    # Комментарии пользователя
    '/user(-@uid:[0-9]+)-reply(-@page:[0-9]+)' => array('user', 'reply'),

    # Подписки пользователя
    '/user(-@uid:[0-9]+)-follow(-@page:[0-9]+)' => array('user', 'follow'),

    # Читатели пользователя
    '/user(-@uid:[0-9]+)-fans(-@page:[0-9]+)' => array('user', 'fans'),

    # Избранное пользователя
    '/my/favorite(/@page:[0-9]+)' => array('user', 'favorite'),

    # Баллы пользователя
    '/my/score(/@page:[0-9]+)' => array('user', 'score'),

    # QQ возврат и вход
    '/user/QQCallback/*' => array('user', 'QQCallback'),

    # Сброс пароля шаг 1
    '/resetPassword' => array('user', 'resetPassword'),

    # Сброс пароля шаг 2
    '/doReset' => array('user', 'doReset'),

    # Получить код подтверждения
    '/identifyImage(/*)' => array('user', 'identifyImage'),

    # Админпанель
    '/admin(/@type:system|common|topic|reply|tag|user|link(/@page:[0-9]+))' => array('admin', 'index'),

    # Админпанель (очистка кэша)
    '/admin/ClearCache/@type:template|attachment|score' => array('manage', 'ClearCache'),

    # Админпанель (удаление тега)
    '/manage/del_tag/@tagid:[0-9]+' => array('manage', 'del_tag'),

    # Админпанель (удаление ссылки)
    '/manage/del_link/@position:[0-9]+' => array('manage', 'del_link'),

    # AJAX публикация топика
    'POST /do/postTopic' => array('doController', 'postTopic'),

    # AJAX удаление топика
    'POST /do/deleteTopic' => array('doController', 'deleteTopic'),

    # AJAX публикация комментария
    'POST /do/postReply' => array('doController', 'postReply'),

    # AJAX удаление комментария
    'POST /do/deleteReply' => array('doController', 'deleteReply'),

    # AJAX ответ на комментарий
    'POST /do/postFloor' => array('doController', 'postFloor'),

    # AJAX удаление ответа
    'POST /do/deleteFloor' => array('doController', 'deleteFloor'),

    # AJAX удаление оповещения
    'POST /do/deleteNotification' => array('doController', 'deleteNotification'),

    # AJAX удаление сообщения
    'POST /do/deleteWhisper' => array('doController', 'deleteWhisper'),

    # AJAX загрузка изображения
    'POST /do/uploadPicture' => array('doController', 'uploadPicture'),

    # AJAX загрузка аватара
    'POST /do/uploadAvatar' => array('doController', 'uploadAvatar'),

    # AJAX удаление изображения
    'POST /do/delPic' => array('doController', 'delPic'),

    # AJAX чтение сообщения
    'POST /do/readWhisper' => array('doController', 'readWhisper'),

    # AJAX отправка сообщения
    'POST /do/deliverWhisper' => array('doController', 'deliverWhisper'),

    # AJAX добавление топика в избранное
    'POST /do/favorTopic' => array('doController', 'favorTopic'),

    # AJAX лайк топика
    'POST /do/praiseTopic' => array('doController', 'praiseTopic'),

    # AJAX подписка
    'POST /do/follow' => array('doController', 'follow'),

    # AJAX информация о топике
    'POST /manage/getTopicInfo' => array('manage', 'getTopicInfo'),

    # AJAX правка топика
    'POST /manage/editTopic' => array('manage', 'editTopic'),

    # AJAX информация о комментарии
    'POST /manage/getReplyInfo' => array('manage', 'getReplyInfo'),

    # AJAX правка комментария
    'POST /manage/editReply' => array('manage', 'editReply'),

    # AJAX отключение комментариев
    'POST /manage/lockTopic' => array('manage', 'lockTopic'),

    # AJAX прикрепить топик
    'POST /manage/topTopic' => array('manage', 'topTopic'),

    # AJAX забанить
    'POST /manage/ban' => array('manage', 'ban'),

    # Правка ссылки
    'POST /manage/edit_link' => array('manage', 'edit_link'),

    # AJAX число комментариев (главная страница)
    'POST /getReplyFloorList' => array('home', 'getReplyFloorList'),

    # AJAX список публикаций (главная страница)
    'POST /getReplyList' => array('home', 'getReplyList'),

    # AJAX авторизация через QQ
    'POST /qqjoin' => array('user', 'qqjoin'),

    # AJAX отметить прочитанным
    'POST /do/doSign' => array('doController', 'doSign'),

    # AJAX подпись
    'POST /do/setSignature' => array('doController', 'setSignature'),

    # AJAX email
    'POST /do/setEmail' => array('doController', 'setEmail'),

    # AJAX пароль
    'POST /do/setPassword' => array('doController', 'setPassword'),

    # ошибка 404, правило по умолчанию не может быть удалено, и должно быть расположено в конце
    '*' => 'notFound'
);

?>
