$(function () {
    'use strict'

    var OBJ_INPUT_NAME = ".ajaxSearchQueryInput";
    var OBJ_RESULT_NAME = ".ajaxSearchQueryResult";
    var OBJ_FORM_NAME = null;
    var OBJ_RESULT = null;

    $("input", OBJ_INPUT_NAME).on('input', function(){
        var url = $(this).parent().data("url");
        OBJ_FORM_NAME = $(this).parent().data("form");
        var val = $(this).val();
        OBJ_RESULT = $(this).parent().next(OBJ_RESULT_NAME);


        if(val.length >= 3){ val = val }else{ val=null; }
        if(val == null){
            OBJ_RESULT.html("").slideUp(250);
        }else{
            getItems(url, val);
            OBJ_RESULT.slideDown(250);
        }

    });


    function getItems(url, val){
        $.ajax({
            url: url,
            type: "POST",
            data: {value:val},
            success: function(response){
                OBJ_RESULT.html(response);
            }
        });
    }



    $(OBJ_RESULT_NAME, OBJ_FORM_NAME).on('click', 'li:not(.title)', function(){
        var name = $(this).text();
        var url = $(this).data('url');
        console.log(OBJ_FORM_NAME);
        $(OBJ_FORM_NAME).find("input[name=name]").val(name);
        $(OBJ_FORM_NAME).find("input.slugify_name").val( slugify(name) );
        $(OBJ_FORM_NAME).find("input[name=url]").val(url);
        OBJ_RESULT.html("").fadeOut(250);
    });


    // UPDATE VE DELETE
    $('.ajaxNavItemForm').on('submit', function(){
        var itemID = $(this).data('id');
        var url = $(this).attr('action');
        var datas = $(this).serialize();
        var actionButton =  $('.actionButton:focus');
        var action =  actionButton.val();
        datas += "&action=" + action;

        if(action=="delete"){
            if(confirm("Bu menü öğesi silinecek? Silme işlemi geri alınamaz.")){
                postNavItem(url, datas, action, itemID, actionButton);
            }
        }else{
            postNavItem(url, datas, action, itemID, actionButton);
        }

        return false;
    });

    function postNavItem(url, datas, action, itemID, actionButton){
        actionButton.find("span").addClass('fa-spinner fa-pulse');
        $.ajax({
            url: url,
            type: 'POST',
            data: datas
        })
        .done(function(response){
            if(response == false){
                actionButton.addClass('btn-danger').find("span").removeClass('fa-spinner fa-pulse').addClass('fa-exclamation');
            }else{
                if(action=="delete"){
                    $('tr#item'+itemID).remove();
                }else{

                }
                actionButton.find("span").removeClass('fa-spinner fa-pulse');
            }
        })
        .fail(function(){ actionButton.addClass('btn-danger').find("span").removeClass('fa-spinner fa-pulse').addClass('fa-exclamation'); });
    }

    $('#allItemsUpdate').on('click', function(){
        $('.ajaxNavItemForm').each(function(){
            var itemID = $(this).data('id');
            var url = $(this).attr('action');
            var datas = $(this).serialize();
            var actionButton =  $("tr#item"+itemID).find('.saveItem');
            console.log(actionButton);
            var action =  actionButton.val();
            datas += "&action=" + action;
            postNavItem(url, datas, action, itemID, actionButton);
        });
    });


});
