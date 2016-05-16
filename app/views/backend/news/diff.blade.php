@extends('backend/layouts/widget')

@section('title')
So sánh phiên bản ::
@parent
@stop

@section('content')
<style type="text/css">
    ins {
        color: green;
        background: #dfd;
        text-decoration: none;
        display: inline-block;
        }
    del {
        color: red;
        background: #fdd;
        text-decoration: none;
        display: inline-block;
    }
    code {
        font-size: smaller;
        }
    #params {
        margin: 1em 0;
        font: 14px sans-serif;
        }
    .code {
        margin-left: 2em;
        font: 12px monospace;
        }
    .ins {
        background:#dfd;
        }
    .del {
        background:#fdd;
    }
    .rep {
        color: #008;
        background: #eef;
    }
</style>
<div class="">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">So sánh phiên bản</h4>
            </div>
            <div class="modal-body">
                <form method="get" action="{{URL::to('/admin/news/diff')}}" autocomplete="off" role="form" id="diffPostForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                    <input type="hidden" name="data[postid]" value="{{$PostVersion['postid']}}" />
                <div class="row">
                    <div class="col-sm-2">
                        <div class="box box-solid">
                            <div class="box-body">
                                <div class="form-group">
                                    <?= Form::select('data[prev]', $versions, isset($PostVersion['prev']->id) ? $PostVersion['prev']->id : '', array('class' => 'form-control')); ?>
                                </div>
                                <div class="form-group">
                                    <?= Form::select('data[next]', $versions, isset($PostVersion['next']->id) ? $PostVersion['next']->id : '', array('class' => 'form-control')); ?>
                                </div>
                                    <button type="submit" class="btn btn-success">So sánh</button>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                    <div class="col-sm-10">
                        @if(!empty($PostVersion['isPost']))
                            <div class="box box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">
                                        <label class="log"><?=$PostVersion['next']->username?>
                                        </label> lúc <label><?=date('d/m/Y h:i',strtotime($PostVersion['next']->created_at))?></label>
                                    </h3>
                                </div>
                                <div class="box-body">
                                    <h3><?=$PostVersion['next']->title?></h3>
                                    <p><strong><?=$PostVersion['next']->excerpt?></strong></p>
                                    <?=$PostVersion['next']->content?>
                                </div><!-- /.box-body -->
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        diffPost();
    });
</script>
@endsection