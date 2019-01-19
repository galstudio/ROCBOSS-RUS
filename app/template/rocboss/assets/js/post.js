var ii;
var rand;
var newDiv;
var newDiv2;
$.ajaxSetup({
    cache: false
});
$(function() {
    $('#tagInput').live('click', function() {
        $('.form-tag-input').focus();
    })
    $('#tags span').live("click", function() {
        $(this).remove();
        $('#final').val(getNowTagStr());
    });
    $('.form-tag-input').live('keyup', function(event) {
        if (event.keyCode == 13) {
            var txt = $.trim($(this).val());
            if (txt != '') {
                txts = new Array();
                $('#tags .tag').each(function() {
                    txts += $.trim($(this).attr('name')) + ','
                });
                if (txts == '') {
                    txts = new Array();
                } else {
                    txts = txts.split(",");
                }
                if (txts.length > 5) {
                    layer.msg('максимальное количество тегов 5');
                    return false;
                };
                var exist = $.inArray(txt, txts);
                if (exist < 0) {
                    $('#tags').append('<span name=' + txt + ' class="tag">' + txt + '</span>');
                    $('#final').val(getNowTagStr());
                    $(this).val('');
                } else {
                    $(this).val('');
                }
            }
        }
    });
});

$('#post-pictures-file').live('click',function(){
    $(this).ImageUpload({
        url: root + 'do/uploadPicture',
        setWidth: 1400, //ширина
        before: function (){
            rand = ('' + Math.random()).replace('0.', '-');
            newDiv = '<div id=\"uploadFile' + rand + '\" class=\"uploadResult\"><div class=\"info\">0%</div><img class=\"previewImage\"></div>';
            $('.showLine').before(newDiv);
        },
        after: function(src) {
            //:src возвращает текущую фотографию
            $('#uploadFile' + rand + ' img').attr('src', src);
        },
        progress: function(percent) {
            //:percent возврат к процессу загрузки
            $("#uploadFile"+rand+" .info").html(percent + "%");
        },
        error: function(e) {
            layer.msg('Ошибка при загрузке, пожалуйста, попробуйте еще раз');
        },
        success: function(data) {
            //:json данные по умолчанию возвращаемого json
            if (data.result == 'success') {
                newDiv2 = $('<div class=\"delPic\" onclick=\"javascript:delUploadImage(\'uploadFile' + rand + '\', ' + data.position + ');\" title=\"Удалить\" style=\"display: block;\"><i class=\"icon icon-roundclose x2\"></i></div>');
                $('#uploadFile' + rand + ' img').after(newDiv2);
                $('#uploadFile' + rand + ' .info').html('<i class="icon icon-roundcheck x4"></i>');
                insertResId(data.position);
                newDiv2 = '';
            } else {
                layer.msg(data.message);
                $('#uploadFile' + rand).hide();
            }
        }
    });
});

$('#post-avatar').live('click',function(){
    $(this).ImageUpload({
        url: root + 'do/uploadAvatar',
        setWidth: 250, //ширина
        before: function (){
            ii = layer.load();
        },
        after: function(src) {
            //:src возвращает текущую фотографию
        },
        progress: function(percent) {
            //:percent возврат к процессу загрузки
        },
        error: function(e) {
            layer.close(ii);
            // layer.msg('e');
        },
        success: function(data) {
            //:json данные по умолчанию возвращаемого json
            layer.close(ii);
            if (data.result == 'success') {
                $('#myAvatar').attr('src', $('#myAvatar').attr('src')+'?'+Math.random());
                $('.avatar-now').attr('src', $('.avatar-now').attr('src')+'?'+Math.random());
            } else {
                layer.msg(data.message);
            }
        }
    });
});

function getNowTagStr() {
    nowStr = new Array();
    $('#tags .tag').each(function() {
        nowStr += $(this).attr('name') + ' ';
    });
    return nowStr;
}

function delUploadImage(obj, id) {
    $.post(root + 'do/delPic/', {
        'id': id,
    }, function(data) {
        data = eval('(' + data + ')');
        if (data.result == 'success') {
            $('.simditor-body').html($.trim($('.simditor-body').html()).replace('[:' + id + ']', ''));
            $('.simditor-body').focus();
            $('#' + obj).hide();
        } else {
            layer.msg(data.message);
        }
    })
}

function insertResId(id) {
    $('.simditor-body').html($.trim($('.simditor-body').html()) + '<br />[:' + id + ']');
    $('.simditor-body').focus();
}

function checkHtml5Support() {
    if (window.applicationCache) {
        return true;
    } else {
        return false;
    }
}

// Публикация сообщений
function postNewTopic() {
    $("#create").attr("disabled", "disabled");
    $.post(root + "do/postTopic/", {
        "title": $("#talk-add #title").val(),
        "tag": $("#talk-add #final").val(),
        "msg": $.trim($("#talk-add textarea[name=subject]").val())
    }, function(data) {
        data = eval("(" + data + ")");
        if (data.result == "success") {
            layer.msg(data.message);
            window.setTimeout("window.location='" + root + "read/" + data.position + "'", 1000)
        } else {
            layer.msg(data.message);
            $("#create").removeAttr("disabled")
        }
    })
}

// Публикация ответов
function postNewReply() {
    $("#create").attr("disabled", "disabled");
    $.post(root + "do/postReply/", {
        "tid": $("#reply-add #tid").val(),
        "content": $.trim($("#reply-add textarea[name=subject]").val())
    }, function(data) {
        data = eval("(" + data + ")");
        if (data.result == "success") {
            layer.msg(data.message);
            setTimeout(function(){
                window.location.reload();
            }, 1000);
        } else {
            layer.msg(data.message);
        }
        $("#create").removeAttr("disabled");
    })
}

// Дерево коммеентариев
function postNewFloor(pid) {
    $('.reply-submit').attr("disabled", "disabled");
    $.post(root + "do/postFloor/", {
        "pid": parseInt(pid),
        "content": $("#do-floor-reply-" + pid + " .reply-text").val()
    }, function(data) {
        data = eval("(" + data + ")");
        if (data.result == "success") {
            layer.msg(data.message);
            rand = new Date().getTime();
            $('#floor-more-' + pid).prepend('<div id=\"floor-list-' + rand + '\" class=\"floor-list\"></div>');
            $('#floor-more-' + pid + ' #floor-list-' + rand).append('<span class=\"floor-avatar\"><img src=\"' + $('#myAvatar').attr('src') + '\"></span>');
            $('#floor-more-' + pid + ' #floor-list-' + rand).append('<span class=\"floor-username\">' + $('#myAvatar').attr('alt') + '</span>');
            $('#floor-more-' + pid + ' #floor-list-' + rand).append('<span class=\"floor-time right\">Комментарий</span><div class=\"clear\"></div>');
            $('#floor-more-' + pid + ' #floor-list-' + rand).append('<span class=\"floor-content\">' + $("#do-floor-reply-" + pid + " .reply-text").val() + '</span>');
            $('.floor-reply').remove();
        } else {
            layer.msg(data.message);
            $('.reply-text').focus();
            $('.reply-submit').removeAttr("disabled")
        }
    })
}

function deleteTopic(tid) {
    var o = $('.deleteTopic');

    var h = o.html();

    o.removeAttr("href").html('<i class=\"icon icon-roundcheckfill x2\"></i>').unbind();

    layer.tips('Действительно удалить?', o);

    o.click(function() {
        o.hide();

        $.post(root+'do/deleteTopic/', {
            'tid': tid
        }, function(data) {
            if (data.result == "success") {
                $('.topic-view').slideUp(300, function() {
                    $(this).remove();
                    layer.msg(data.message);
                    window.setTimeout("window.location='" + root + "'", 1000);
                });
            } else {
                layer.msg(data.message);
                o.show();
            }
        }, "json");
    });

    setTimeout(function() {
        o.html(h).attr('href', 'javascript:deleteTopic(' + tid + ')').unbind();
    }, 3000);
}

function deleteReply(pid) {
    var o = $('#d-reply-' + pid + ' .deleteReply');

    var h = o.html();

    o.removeAttr("href").html(h.replace("Удалить", "Вы уверены?")).unbind();

    o.click(function() {
        o.hide();

        $.post(root+'do/deleteReply/', {
            'pid': pid
        }, function(data) {
            if (data.result == "success") {
                $('#d-reply-' + pid).slideUp(300, function() {
                    $(this).remove();
                    layer.msg(data.message);
                });
            } else {
                layer.msg(data.message);
                o.show();
            }
        }, "json");
    });

    setTimeout(function() {
        o.html(h).attr('href', 'javascript:deleteReply(' + pid + ')').unbind();
    }, 3000);
}

function deleteNotification(nid)
{
    var o = $('.delNotification-btn-'+nid);

    var h = o.html();

    o.removeAttr("href").html("<i class=\"icon icon-roundcheckfill x2\"></i>");

    layer.tips('Действительно удалить?', o);

    o.click(function() {
        o.hide();
        $.post(root+'do/deleteNotification/', {
            'nid': nid
        }, function(data) {
            if (data.result == "success") {
                $('#notification-' + nid).slideUp(300, function() {
                    $(this).remove();
                    layer.msg(data.message);
                });
            } else {
                layer.msg(data.message);
                o.show();
            }
        }, "json");
    });

    setTimeout(function() {
        o.html(h).attr('href', 'javascript:deleteNotification(' + nid + ')').unbind();
    }, 3000);
}

function deleteWhisper(id)
{
    var o = $('.delWhisper-btn-'+id);

    var h = o.html();

    o.removeAttr("href").html("<i class=\"icon icon-roundcheckfill x2\"></i>");

    layer.tips('Действительно удалить?', o);

    o.click(function() {
        o.hide();
        $.post(root+'do/deleteWhisper/', {
            'id': id
        }, function(data) {
            if (data.result == "success") {
                $('#whisper-' + id).slideUp(300, function() {
                    $(this).remove();
                    layer.msg(data.message);
                });
            } else {
                layer.msg(data.message);
                o.show();
            }
        }, "json");
    });

    setTimeout(function() {
        o.html(h).attr('href', 'javascript:deleteWhisper(' + id + ')').unbind();
    }, 3000);
}

function deleteFloor(id) {
    var o = $('#floor-list-' + id + ' .floor-admin .delete-btn');

    var h = o.html();

    o.removeAttr("href").html(h.replace("Удалить", "Вы уверены?")).unbind();

    o.click(function() {
        o.hide();

        $.post(root+'do/deleteFloor/', {
            'id': id
        }, function(data) {
            if (data.result == "success") {
                $('#floor-list-' + id).slideUp(300, function() {
                    $(this).remove();
                    layer.msg(data.message);
                });
            } else {
                layer.msg(data.message);
                o.show();
            }
        }, "json");
    });

    setTimeout(function() {
        o.html(h).attr('href', 'javascript:deleteFloor(' + id + ')').unbind();
    }, 3000);
}

function favorTopic(tid, status) {
    $.post(root + 'do/favorTopic/', {
        'tid': tid,
        'status': status
    }, function(data) {
        data = eval('(' + data + ')');
        if (data.result == 'success') {
            if (data.position == 1) {
                $('.favorTopic').html('<i class=\"icon icon-favorfill x2\"></i>');
                $('.favorTopic').attr('tip-title','Из избранного');
            } else {
                $('.favorTopic').html('<i class=\"icon icon-favor x2\"></i>');
                $('.favorTopic').attr('tip-title','В избранное');
            }
            $('.favorTopic').attr('href', 'javascript:favorTopic('+tid+', '+data.position+')');
        }
    })
}

function praiseTopic(tid, status) {
    $.post(root + 'do/praiseTopic/', {
        'tid': tid,
        'status': status
    }, function(data) {
        data = eval('(' + data + ')');
        if (data.result == 'success') {
            if (data.position == 1) {
                $('.praiseTopic').html('<i class=\"icon icon-appreciatefill x2\"></i>');
                $('.praiseTopic').attr('tip-title','Не нравится');
                $('.topic-praise').show();
                $('.topic-praise').append('<img src=\"'+$('#myAvatar').attr('src')+'\" title=\"Нравится '+$('#myAvatar').attr('alt')+'\" alt=\"Нравится '+$('#myAvatar').attr('alt')+'\" class="avatarC">');
            } else {
                $('.praiseTopic').html('<i class=\"icon icon-appreciate x2\"></i>');
                $('.praiseTopic').attr('tip-title','Нравится');
                $('.topic-praise img[title="Нравится ' + $('#myAvatar').attr('alt') + '"]').remove();
            }
            $('.praiseTopic').attr('href', 'javascript:praiseTopic('+tid+', '+data.position+')');
        }
    })
}

function doSign() {
    $.post(root + 'do/doSign/', {
        'do': 'doSign'
    }, function(data) {
        data = eval('(' + data + ')');
        layer.msg(data.message);
        if (data.position > 0) {
            $('#today-sign').html('<i class=\"icon icon-selectionfill x2\"></i> Подпись');
            $('#mine-score').html(parseInt($('#mine-score').html()) + data.position);
        }
    })
}
function setSignature() {
    $.post(root + 'do/setSignature/', {
        'signature': $("#signature").val()
    }, function(data) {
        data = eval('(' + data + ')');
        layer.msg(data.message);
    })
}

function setEmail() {
    $.post(root + 'do/setEmail/', {
        'email': $("#email").val(),
        'password': $("#password").val()
    }, function(data) {
        data = eval('(' + data + ')');
        layer.msg(data.message);
        $("#password").val('');
    })
}

function setPassword() {
    var password = $("#password").val();
    var newPassword = $("#newPassword").val();
    var reNewPassword = $("#reNewPassword").val();
    if (password == newPassword) {
        layer.msg('Новый пароль не может быть такой же, как и старый');
        return false;
    }
    if (reNewPassword != newPassword) {
        layer.msg('Введите новый пароль дважды');
        return false;
    }
    $.post(root + 'do/setPassword/', {
        'password': password,
        'newPassword': newPassword
    }, function(data) {
        data = eval('(' + data + ')');
        layer.msg(data.message);
        if (data.result == 'success') {
            $("#password").val('');
            $("#newPassword").val('');
            $("#reNewPassword").val('');
        };
    })
}
