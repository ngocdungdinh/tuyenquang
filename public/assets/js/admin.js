$(document).ready(function(){
    window.setInterval(function() {
      $(".alert-message").removeClass('show');
    }, 4000);
    
    //Activate tooltips
    $("[data-toggle='tooltip']").tooltip();
    
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

    $('.widget .iCheck-helper').click(function(){
        var wid = $(this).prev().data("id");
        // console.log(wid);
        $.ajax({
            type: 'POST',
            url: "/admin/widgets/updatestatus/" + wid,
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if($(e).is(":checked"))            
                    $(e).prop('checked', false); 
                else
                    $(e).prop('checked', true);
            }
        });
    });

    $('.comment-status .iCheck-helper').click(function(e){
        var cmtId = $(this).prev().data("commentid");
        $.ajax({
            type: 'POST',
            url: "/admin/comments/"+cmtId+"/approve",
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if($(this).is(":checked"))            
                    $(this).prop('checked', false); 
                else
                    $(this).prop('checked', true);
                if(data.status == 0) {
                    alert(data.msg);
                }
            }
        });
    });

    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    } 

    // Change hash for page-reload
    $('.nav-tabs a').on('shown', function (e) {
        window.location.hash = e.target.hash;
    })

    $('.btooltip').tooltip();
    reBindModal();
});

function removeVideoId() {
  $('#video-preview').html('');
  $('#video_id').val('');
}

function updateCache(zone) {
    $('#cacheBtn').addClass('disabled');
    $('#cacheBtn').children('i').addClass('fa-spin');
    $.ajax({
        type: 'GET',
        url: "/admin/deletecaches?zone="+zone,
        dataType: 'json',
        ifModify: false,
        success: function(data){
            if(data.status == 1) {
                $('#cacheBtn').removeClass('disabled');
                $('#cacheBtn').children('i').removeClass('fa-spin');
            }
        }
    });
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

function quickAddPost()
{
    var title = $('#post_title').val();
    if(title.length <= 0) {
        $('#post_title').parent().addClass('has-error');
    } else {
        $('#quick-add-post').submit();
    }
}

function updatePostPosition(dataType, dataSort) {
    // console.log(dataSort);
    if(dataSort.length > 0) {
        $.ajax({
            type: 'POST',
            url: "/admin/news/updatePostPosition",
            data: {datasort: dataSort, datatype: dataType},
            dataType: 'json',
            ifModify: false,
            success: function(data){
                // console.log(data);
            }
        });
    }
}

function postRemovePosition(postId, dataType, featured, popular, oncat) {
    if(postId) {
        $.ajax({
            type: 'POST',
            url: "/admin/news/removeposition",
            data: {postId: postId, datatype: dataType, featured: featured, popular: popular, oncat: oncat},
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if(data == 1) {
                    window.location.href = window.location.href;
                } else {
                    alert("Có lỗi xảy ra!");
                }
            }
        });
    }
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
                // console.log(data);
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
function embed_video(video_id, e) {
    var htmlContent = '<p align="center" class="flex-video"><iframe src="http://www.youtube.com/embed/'+video_id+'?rel=0&showinfo=0&ps=docs&autoplay=0&autohide=1&iv_load_policy=3&vq=large&modestbranding=1&nologo=1&enablejsapi=1" frameborder="0" allowfullscreen="1"></iframe></p>';
    CKEDITOR.instances.textareabox.insertHtml(htmlContent);
    // $('#modal_updateMedia').modal('hide');
    $(e).addClass('disabled');
    $('#modal_updateMedia').modal('hide');
}
function updatePost(status)
{
    $('#status').val(status);
    $('#updatePost').submit();
    return false;
}

function loadAnalyticsTopPage() {
    $.ajax({
        type: 'POST',
        url: "/admin/analytics",
        data: {startDate: 'today', endDate: 'today', metrics: 'ga:pageviews', dimensions: 'ga:pagePath,ga:pageTitle', sort: '-ga:pageviews', typeReport: 'toppage'},
        dataType: 'json',
        ifModify: false,
        success: function(data){
            $('.loading').hide();
            $('#top-page-today').append('<tr><td>#</td><td>Tiêu đề</td><td></td><td width="80">Lượt xem</td></tr>');
            for (var i = 0; i < data.rows.length; i++) {
                // data.rows[i]['1'].replace(":: Báo điện tử Pháp luật & Xã hội", " ");
                $('#top-page-today').append('<tr><td>'+(i+1)+'</td><td>'+data.rows[i]['1']+'</td><td><a href="'+data.rows[i]['0']+'" target="_blank"><span class="glyphicon glyphicon-link"></span></a></td><td>'+data.rows[i]['2']+'</td></tr>');
            };
        }
    });
}

function loadAnalytics() {
    $.ajax({
        type: 'POST',
        url: "/admin/analytics",
        dataType: 'json',
        ifModify: false,
        success: function(data){
            /*
             * LINE CHART
             * ----------
             */
            //LINE randomly generated data

            var visitor = [], pageview = [];
            for (var i = data['rows'].length - 1; i >= 0; i--) {
                data['rows'][i]

                visitor.push([data['rows'][i][0], data['rows'][i][1]]);
                pageview.push([data['rows'][i][0], data['rows'][i][2]]);
            };
            // @foreach($stats->rows as $key => $rep) 
            // @endforeach

            var line_data1 = {
                label: 'Visitors',
                data: visitor.reverse(),
                color: "#ea4d00"
            };
            var line_data2 = {
                label: 'Pageviews',
                data: pageview.reverse(),
                color: "#00c0ef"
            };
            $.plot("#line-chart", [line_data1, line_data2], {
                grid: {
                    hoverable: true,
                    borderColor: "#f3f3f3",
                    borderWidth: 1,
                    tickColor: "#f3f3f3"
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false,
                    color: ["#3c8dbc", "#f56954"]
                },
                yaxis: {
                    show: true,
                },
                xaxis: {
                    mode: "categories",
                    tickLength: 0,
                    show: true
                }
            });
            //Initialize tooltip on hover
            $("<div class='tooltip-inner' id='line-chart-tooltip'></div>").css({
                position: "absolute",
                display: "none",
                opacity: 0.8
            }).appendTo("body");
            $("#line-chart").bind("plothover", function(event, pos, item) {

                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                            y = item.datapoint[1].toFixed(2);

                    $("#line-chart-tooltip").html(item.series.label + " of " + x + " = " + y)
                            .css({top: item.pageY + 5, left: item.pageX + 5})
                            .fadeIn(200);
                } else {
                    $("#line-chart-tooltip").hide();
                }

            });
            /* END LINE CHART */
        }
    });
}

function getActivities(post_id) {
  setTimeout(function() {
    $.ajax({
        type: 'POST',
        url: "/admin/news/activities",
        data: {post_id: post_id},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $('.loading').hide();
            $('#activities-container'+post_id).html(data);
        }
    });
  }, 1000);
}

function updatePublishApi(newId){
    $.ajax({
        type: 'POST',
        url: "/admin/news/"+newId+"/syncapi",
        dataType: 'json',
        ifModify: false,
        success: function(data){
            // alert(data);
        }
    });
}

function updatePostsSort(type){
  setTimeout(function() {
    $.ajax({
        type: 'GET',
        url: "/admin/news/resorts?type="+type,
        dataType: 'json',
        ifModify: false,
        success: function(data){
            // alert(data);
        }
    });
  }, (type== 'home' ? 1000 : 2000));
}

function optionMenuType(type) {
    $('.menu_type').hide();
    $('#type_'+type).show();
    if(type == 'custom') {
        $('#menu_link_name').show();
    } else {
        $('#menu_link_name').hide();
    }
}

function addNote(postId)
{
    var content = $('#noteContent').val();
    if(postId && content.length > 5) {
        $.ajax({
            type: 'POST',
            url: "/admin/news/addnote",
            data: {postId: postId, content: content},
            dataType: 'json',
            ifModify: false,
            success: function(data){
                if(data) {
                    window.location.href = window.location.href;
                }
            }
        });
    } else {
        alert('Chưa nhập nội dung hoặc nội dung quá ngắn!');
    }
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
            if(data.mtype == 'video') {
                $("#cover-image", window.parent.document).html('<img class="video-img" src="http://i.ytimg.com/vi/'+ data.mname +'/0.jpg" width="100%" /><a class="label label-default" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ video</a>');
            } else {
                $("#cover-image", window.parent.document).html('<img src="/' + data.mpath + '/500x300_crop/' + data.mname + '" width="100%" /><span style="display: block; margin-top: 6px;"><a class="btn btn-primary btn-xs show-modal" data-toggle="modal" href="/medias/cropthumb/'+mid+'" data-target="#modal_cropmedia" ><i class="fa fa-scissors"></i> Sửa ảnh</a> <a class="btn btn-default btn-xs" href="javascript:void(0)" onclick="removeNewsCover()" >Bỏ ảnh</a></span>');
            }
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
    var postId = $("#postId").val();
    var pageNum = $("#pageNum").val();
    var typeSort = $("#typeSort").val();
    $.ajax({
        type: 'GET',
        url: "/admin/news/postlist",
        data: {keyword: keyword, category_id: catId, tag_id: tagId, post_id: postId, type_sort: typeSort, page: pageNum},
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

function addSortPost(postId, type) {    
    $.ajax({
        type: 'POST',
        url: "/admin/news/addposition",
        data: {postId: postId, type: type},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            if(data==1) {
                window.location.href = window.location.href;
            } else {
                alert('Bài viết đã tồn tại!');
            }
        }
    }); 
}

function addRelatePost(currPostId, postId, plus) {
    if (plus == 1) {
        $('#postadd-'+postId).remove();
    } else {
        $('#postrelate-'+postId).fadeOut();
    }
    $.ajax({
        type: 'POST',
        url: "/admin/news/addrelatepost",
        data: {currPostId: currPostId, postId: postId, plus: plus},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $("#relatePosts", window.parent.document).html(data);
        }
    }); 
}

function updateTopicInfo(ptid) {
    var pttype = $("#post_tag_type").val();
    $.ajax({
        type: 'POST',
        url: "/admin/tags/topicinfo/" + ptid,
        data: {pttype: pttype},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $("#ptitem-" + ptid).parent().remove();
            $("#topicList .row").append(data);
            $("#modal_topictype").modal("hide");
        }
    });
}
function removeTopicInfo(ptid) {
    if(!confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "/admin/tags/topicinfo/remove/" + ptid,
        data: {ptid: ptid},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $('#ptitem-' + ptid).parent().hide();
        }
    });
}
function addTopictoPost(tid) { 
    var postid = $("#postid", window.parent.document).val();    
    $.ajax({
        type: 'POST',
        url: "/admin/tags/topicinfo/add",
        data: {tid: tid, postid: postid},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            reBindModal();
            $("#topicList .row").append(data);
            $("#modal_taglist").modal("hide");
        }
    });
}
function addTagtoPost(type, tid, name) {
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
                tagAppend(data.id, data.name);
                $('#tagName').val('').focus();
            }
        });
    }
}

function tagAppend(tid, name) {
    $("#tagList").append('<p><a href="javascript:void(0)" onclick="removeTaginPost('+ tid +', this)" class="btn btn-default btn-xs"><i class="fa fa-times"></i></a> '+ name +'<input type="hidden" name="tagId[]" value="'+ tid +'" /></p>');
}

function removeTaginPost(tid, e) {
    $(e).parent().remove();
}

function addSidebarRef(sid, item_id, type)
{
    $.ajax({
        type: 'POST',
        url: "/admin/sidebars/addref",
        data: {sidebar_id: sid, item_id: item_id, type: type},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $("#sidebarList").append(data);
            $("#modal_display").modal('hide');
            reBindModal();
        }
    });
}

function removeSidebarRef(srid, e)
{
    if(!confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        return false;
    }
    $.ajax({
        type: 'GET',
        url: "/admin/sidebars/removeref/"+srid,
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $("#sidebarref-" + srid).fadeOut();
        }
    });
}

function addWidget(wid, itemid, type, e)
{
    $.ajax({
        type: 'POST',
        url: "/admin/widgets/addwidgetref",
        data: {widget_id: wid, item_id: itemid, type: type},
        dataType: 'html',
        ifModify: false,
        success: function(data){
            $("#widgetList"+itemid+" .itemsort").append(data);
            $("#modal_display").modal('hide');
            reBindModal();
        }
    });
}

function updateWidget()
{
    var options = {
        beforeSubmit:  function(arr, $form, options) 
        {

        },  // pre-submit callback
        success: function(data){
            $("#widgetSuccess").addClass('show');
            reBindModal();
        },  // post-submit callback

        type:      'post',        // 'get' or 'post', override for form's 'method' attribute
        dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type)
        clearForm: false        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $('#widgetForm').ajaxForm(options);
}

function removeWidget(wid, e) {
    if(!confirm("bạn có chắc muốn thực hiện thao tác này?")) {
        return false;
    }
    $.ajax({
        type: 'POST',
        url: "/admin/widgets/removewidgetref",
        data: {id: wid},
        dataType: 'json',
        ifModify: false,
        success: function(data){
            $(e).parent().parent().remove();
        }
    });
}


function updateWidgetsPosition() {
    var dataSort = '';
    $("ol.itemsort").children("li").each(function(){
        dataSort = dataSort + $(this).data('wrid') + ':' + $(this).data('position') + ',';
    });
    if(dataSort.length > 0) {
        $.ajax({
            type: 'POST',
            url: "/admin/widgets/updateposition",
            data: {datasort: dataSort},
            dataType: 'json',
            ifModify: false,
            success: function(data){
                // console.log(data);
            }
        });
    }
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

function diffPost() {
    var options = {
        //target:        '#output1',   // target element(s) to be updated with server response
        beforeSubmit:  function(arr, $form, options)
        {
            $("#diffPostForm").html('<div align="center"><img src="/assets/img/loader.gif" /></div>');
        },  // pre-submit callback
        success: function(data){
//            $("#modal_royaltyform").modal("hide");
            $("#modal_diff_post").html(data);
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
    $('#diffPostForm').ajaxForm(options);
}

function GetNotifications()
{
  if($('#notisAct').hasClass('open'))
    return false;
  
  $.ajax({
      type: 'GET',
      url: "/notifications/get",
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      ifModify: false,
      success: function(data){
        $("#notifications").html(data);
        $("#noti_total").hide();
        $("#noti_icon").css('color', '#dddddd');
      }
  });
}

function GetConversations(e)
{
  if($('#convsAct').hasClass('open'))
    return false;
  
  $.ajax({
      type: 'GET',
      url: "/profile/quickmessages",
      data: {
        _token: $('meta[name="csrf-token"]').attr('content')
      },
      ifModify: false,
      success: function(data){
        $("#conversations").html(data);
      }
  });
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
