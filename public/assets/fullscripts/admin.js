$(document).ready(function(){
    $("#searchTags").bind("click", function(){ ajaxSearchTags(); })

    $('#tagName').keypress(function(event) {
        if (event.keyCode == 13) {
            addTagtoPost('tag', '', '');
            return false;
        }
    });

    $("#checkAll").bind("click", function() {
        $('#postList input[type="checkbox"]').each(function(){
            // toggle checkbox
            $(this).prop('checked',!$(this).prop('checked'));
            // toggle class
            $(this).parents('label').toggleClass('active');
        });
        $(this).prop('checked',!$(this).prop('checked'));
    });
    
      $('.media-modal').click(function(event) {
          event.preventDefault()
          var url = $(this).data('url');
          if(url.length > 0) {
              $("#mediaContent").html('<iframe frameborder="0" hspace="0" src="'+url+'" id="TB_iframeContent" name="TB_iframeContent131" style="height: 440px; width: 100%">This feature requires inline frames. You have iframes disabled or your browser does not support them.</iframe>');
              $("#modal_updateMedia").modal("show"); 
          } else {
            alert('Không thể thực hiện thao tác này!');
          }
      });

    $('.btooltip').tooltip();
    reBindModal();
});

function removeVideoId() {
  $('#video-preview').html('');
  $('#video_id').val('');
}

function extractVideoId() {
  var video_url = $('#video_url').val();
  if(video_url.length > 0) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = video_url.match(regExp);
    if (match&&match[7].length==11){
        var video_id = match[7];
        $('#video-preview').html('<p>Video hiện tại:</p><iframe width="182" height="130" src="http://www.youtube.com/embed/'+video_id+'?showinfo=0&amp;ps=docs&amp;autoplay=1&amp;iv_load_policy=3&amp;vq=large&amp;modestbranding=1&amp;nologo=1" frameborder="0" allowfullscreen="1"></iframe>');
        $('#video_id').val(video_id);
    }else{
        alert("Url incorrecta");
    }
  }
}

function reBindModal() {
    $(".show-modal").click(function(ev) {
        ev.preventDefault();
        var target = $(this).attr("href");
        var targetId = $(this).data("target");
        // load the url and show modal on success
        $(targetId).empty();
        $(targetId).load(target, function() { 
             $(targetId).modal("show"); 
        });
    });
}

function updateLinksPosition() {
    var dataSort = '';
    $("ol.itemsort").children("li").each(function(){
        dataSort = dataSort + $(this).data('lid') + ':' + $(this).data('showon') + ',';
    });
    if(dataSort.length > 0) {
        $.ajax({
            type: 'POST',
            url: "/admin/menus/updateLinksPosition",
            data: {datasort: dataSort},
            dataType: 'json',
            ifModify: false,
            success: function(data){
                console.log(data);
            }
        });
    }
}
function image_send_to_editor(photo_url, e) {
    var htmlContent = '<p align="center"><img src="/'+ photo_url +'" style="padding: 10px 0; width: 500px; text-align: center" /></p>';
    CKEDITOR.instances.textareabox.insertHtml(htmlContent);
    // $('#modal_updateMedia').modal('hide');
    $(e).addClass('disabled');
}
function updatePost(status)
{
    $('#status').val(status);
    $('#updatePost').submit();
}

function setCover(mpath, mname, featuredSize, mid) {
    $("#media-cover-id", window.parent.document).val(mid);
    $("#cover-image", window.parent.document).html('<img src="/' + mpath + '/' + featuredSize + '/' + mname + '" width="100%" /><a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ ảnh</a>');
    $('#modal_updateMedia').modal('hide');
}

function setNewsCover(pid, mid) {
  	$.ajax({
        type: 'POST',
        url: "/admin/news/setcover",
        data: {post_id: pid, media_id: mid},
        dataType: 'json',
        ifModify: false,
        success: function(data){
			$("#media-cover-id", window.parent.document).val(data.id);
			$("#cover-image", window.parent.document).html('<img src="/' + data.mpath + '/200x130_crop/' + data.mname + '" width="175" /><a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ ảnh</a>');
        }
    });
}

function removeNewsCover() {
	$("#media-cover-id").val("");
	$("#cover-image").html("Chọn ảnh đại diện trong thư viện.");
}

function removeMedia(media_id) {
    if(confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        $.ajax({
            type: 'POST',
            url: "/medias/"+media_id+"/delete",
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if(data.status == 1)
                    $("#media_" + media_id).fadeOut();
                else
                    alert('Có lỗi xảy ra!');
            }
        });
    }
}
function setPrimaryCat(pid, cid) {
    $.ajax({
        type: 'POST',
        url: "/admin/news/setcategory",
        data: {post_id: pid, category_id: cid},
        dataType: 'json',
        ifModify: false,
        success: function(data){
            $(".scat").removeClass("active");
            $("#category-id-" + cid).addClass("active");
            $("#category-id-" + cid + " input").prop('checked', true);
        }
    });
}

function setHbPrimaryCat(pid, cid) {
    $.ajax({
        type: 'POST',
        url: "/admin/handbooks/setcategory",
        data: {post_id: pid, category_id: cid},
        dataType: 'json',
        ifModify: false,
        success: function(data){
            $(".scat").removeClass("active");
            $("#category-id-" + cid).addClass("active");
            console.log(cid);
            $("#category-id-" + cid + " input").prop('checked', true);
        }
    });
}

function confirmDelete(e) {
    if(confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        window.location.href = $(e).attr("href");
    }
}

function ajaxSearchNewsPage(page) {
    $("#pageNum").val(page);
    ajaxSearchNews();
}

function ajaxSearchNews() {
    var catId = $("#categoryId").val();
    var keyword = $("#keyword").val();
    var tagId = $("#tagId").val();
    var pageNum = $("#pageNum").val();
    $.ajax({
        type: 'GET',
        url: "/admin/news/postlist",
        data: {keyword: keyword, category_id: catId, tag_id: tagId, page: pageNum},
        ifModify: false,
        success: function(data){
            $("#modal_addposts").html(data);
        }
    });
}

function ajaxSearchTags() {
    var order = $("#orderByDate").val();
    var keyword = $("#keyword").val();
    $.ajax({
        type: 'GET',
        url: "/admin/tags/listpopup",
        data: {keyword: keyword, order: order},
        ifModify: false,
        success: function(data){
            $("#modal_taglist").html(data);
        }
    });
}

function addTagtoPost(type, tid, name) {
    if(type=="tag") {
        var tagName = $("#tagName").val();
        if(tagName!="" && tagName.length >2) {
            // console.log(tagName);
            $.ajax({
                type: 'POST',
                url: "/admin/tags/ajaxcreate",
                data: {name: tagName},
                dataType: 'json',
                ifModify: false,
                success: function(data){
                    tagAppend(type, data.id, data.name);
                    $('#tagName').val('').focus();
                }
            });
        }
    } else {
        tagAppend(type, tid, name);
    }    
}

function tagAppend(type, tid, name) {
    var ids = $("#"+ type +"Ids").val();
    var idArr = ids!="" ? ids.split(',') : [];
    // push id to array
    idArr.push(tid);
    $("#"+ type +"Ids").val(idArr.join(','));
    $("#"+ type +"List").append('<p><a href="javascript:void(0)" onclick="removeTaginPost(\'topic\', '+ tid +', this)" class="btn btn-default btn-xs">X</a> '+ name +'</p>');
}

function removeTaginPost(type, tid, e) {
    var ids = $("#"+ type +"Ids").val();
    var idArr = ids.split(',');
    idArr.splice( $.inArray(tid, idArr), 1 );
    $("#"+ type +"Ids").val(idArr.join(','));
    $(e).parent().remove();
}

function DeleteRoyalties(royalId) {
    if(!confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        return false;
    }

    $.ajax({
        type: 'GET',
        url: "/admin/royalties/delete",
        data: {royal_id: royalId},
        ifModify: false,
        success: function(data){
            $("#royaltiesResult").html(data);
            reBindModal();
        }
    });
}
function UpdateRoyalties() {
    var options = {
        //target:        '#output1',   // target element(s) to be updated with server response
        beforeSubmit:  function(arr, $form, options) 
        {
            $("#royaltiesForm").html('<div align="center"><img src="/assets/img/loader.gif" /></div>');
        },  // pre-submit callback
        success: function(data){
          $("#modal_royaltyform").modal("hide");
          $("#royaltiesResult").html(data);
          reBindModal();
        },  // post-submit callback

        // other available options:
        // url:       '/article/post',         // override for form's 'action' attribute
        type:      'post',        // 'get' or 'post', override for form's 'method' attribute
        // dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type)
        clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $('#royaltiesForm').ajaxForm(options);
}


function printWebPart(tagid){
    if (tagid && document.getElementById(tagid)) {
        //build html for print page
        if($("#"+tagid).attr('type')=='land')
        {
            var content = '<div style="page:land;">';
            content += $("#"+tagid).html();
            content += '</div>';
        }else
        {
            var content = '';
            content += $("#"+tagid).html();
        }
        var html = "<HTML>\n<HEAD>\n"+
            $("head").html()+
            "\n</HEAD>\n<BODY>\n"+
            content+
            "\n</BODY>\n</HTML>";
        //open new window
        html = html.replace(/<TITLE>((.|[\r\n])*?)<\\?\/TITLE>/ig, "");
        html = html.replace(/<script[^>]*>((.|[\r\n])*?)<\\?\/script>/ig, "");
        var printWP = window.open("","printWebPart");
        printWP.document.open();
        //insert content
        printWP.document.write(html);        
        
        //open print dialog
        printWP.print();
        printWP.close();
    }
}

// moment.js language configuration
// language : vietnamese (vn)
// author : Bang Nguyen : https://github.com/bangnk

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['moment'], factory); // AMD
    } else if (typeof exports === 'object') {
        module.exports = factory(require('../moment')); // Node
    } else {
        factory(window.moment); // Browser global
    }
}(function (moment) {
    return moment.lang('vn', {
        months : "tháng 1_tháng 2_tháng 3_tháng 4_tháng 5_tháng 6_tháng 7_tháng 8_tháng 9_tháng 10_tháng 11_tháng 12".split("_"),
        monthsShort : "Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12".split("_"),
        weekdays : "chủ nhật_thứ hai_thứ ba_thứ tư_thứ năm_thứ sáu_thứ bảy".split("_"),
        weekdaysShort : "CN_T2_T3_T4_T5_T6_T7".split("_"),
        weekdaysMin : "CN_T2_T3_T4_T5_T6_T7".split("_"),
        longDateFormat : {
            LT : "HH:mm",
            L : "DD/MM/YYYY",
            LL : "D MMMM [năm] YYYY",
            LLL : "D MMMM [năm] YYYY LT",
            LLLL : "dddd, D MMMM [năm] YYYY LT",
            l : "DD/M/YYYY",
            ll : "D MMM YYYY",
            lll : "D MMM YYYY LT",
            llll : "ddd, D MMM YYYY LT"
        },
        calendar : {
            sameDay: "[Hôm nay lúc] LT",
            nextDay: '[Ngày mai lúc] LT',
            nextWeek: 'dddd [tuần tới lúc] LT',
            lastDay: '[Hôm qua lúc] LT',
            lastWeek: 'dddd [tuần rồi lúc] LT',
            sameElse: 'L'
        },
        relativeTime : {
            future : "%s tới",
            past : "%s trước",
            s : "vài giây",
            m : "một phút",
            mm : "%d phút",
            h : "một giờ",
            hh : "%d giờ",
            d : "một ngày",
            dd : "%d ngày",
            M : "một tháng",
            MM : "%d tháng",
            y : "một năm",
            yy : "%d năm"
        },
        ordinal : function (number) {
            return number;
        },
        week : {
            dow : 1, // Monday is the first day of the week.
            doy : 4  // The week that contains Jan 4th is the first week of the year.
        }
    });
}));