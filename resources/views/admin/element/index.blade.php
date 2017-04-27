@extends('admin.layout.html')

@section('content')
    <section class="vbox">
        <section class="scrollable  panel panel-default">
            <header class="panel-heading">
                视频列表
            </header>
            <div class="row wrapper">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control input-s-sm inline v-middle">
                        <option value="0">设为推荐</option>
                        <option value="1">全部删除</option>
                    </select>
                    <button class="btn btn-sm btn-default">批量操作</button>
                    <a href="{{ action('Admin\ElementController@getAddElement') }}"
                       class="btn btn-sm btn-default">新增视频</a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-default btn-batch-duration">视频时长</a>
                </div>
                <div class="col-sm-4 m-b-xs">
                    {{--<div class="btn-group" data-toggle="buttons">--}}
                    {{--<label class="btn btn-sm btn-default active">--}}
                    {{--<input type="radio" name="options"> Day--}}
                    {{--</label>--}}
                    {{--<label class="btn btn-sm btn-default">--}}
                    {{--<input type="radio" name="options"> Week--}}
                    {{--</label>--}}
                    {{--<label class="btn btn-sm btn-default">--}}
                    {{--<input type="radio" name="options"> Month--}}
                    {{--</label>--}}
                    {{--</div>--}}
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
                        <button class="btn btn-sm btn-default" type="button">查询</button>
                      </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;"><label class="checkbox m-n i-checks"><input
                                        type="checkbox"><i></i></label></th>
                        <th class="th-sortable" data-toggle="class">标题
                            <span class="th-sort">
                            <i class="fa fa-sort-down text"></i>
                            <i class="fa fa-sort-up text-active"></i>
                            <i class="fa fa-sort"></i>
                          </span>
                        </th>
                        <th>播放地址</th>
                        <th width="90">所属英雄</th>
                        <th width="90">播放次数</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody style="height:200px;overflow-y: auto;width:100%;">
                    @foreach($element as $item)
                        <tr>
                            <td><label class="checkbox m-n i-checks"><input type="checkbox"
                                                                            name="post[]"><i></i></label></td>
                            <td>{{ $item->title }}</td>
                            <td class="url-column" data-id="{{ $item->id }}">{{ $item->url }}</td>
                            <td>{{ $item->hero->name }}</td>
                            <td>{{ $item->play_num }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                <a href="{{ action('Admin\ElementController@getEditElement',[$item->id]) }}"
                                   class="active">
                                    <i class="fa fa-edit text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-4 hidden-xs">
                        <select class="input-sm form-control input-s-sm inline v-middle">
                            <option value="0">设为推荐</option>
                            <option value="1">全部删除</option>
                        </select>
                        <button class="btn btn-sm btn-default">批量操作</button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        {{ $element->appends($_GET)->links() }}
                    </div>
                </div>
            </footer>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
@stop


@section('foot_script')

    <link rel="stylesheet" href="/js/chosen/chosen.css" type="text/css"/>
    <script src="/js/parsley/parsley.min.js"></script>
    <script src="/js/parsley/parsley.extend.js"></script>
    <script src="/js/chosen/chosen.jquery.min.js"></script>
    <script src="/js/admin/jquery.ajaxfileupload.js"></script>
    <script src="/js/admin/add-element.js"></script>

    <script>
        $(function () {
            var setDurationUrl = "{{ action('Admin\ElementController@setElementDuration') }}";
            //图片上传
            $.uploadImg($('.upload-file-container'), {
                'uploadUrl': "{{ action("Admin\CommonController@postUploadImage") }}",
                'uploadParams': {
                    _token: $('meta[name=csrf-token]').attr('value')
                }
            });

            $('.btn-batch-duration').click(function () {
                $('.url-column').each(function () {
                    var _this = $(this);
                    var url = _this.html();
                    var id = _this.data('id')

                    var video = new Audio(url);
                    video.addEventListener('loadeddata', function () {
                        $.ajaxFun(setDurationUrl, 'POST', {
                            id: id,
                            duration: video.duration,
                        }, function () {

                        });
                    });
                })


            })
        });
    </script>
@stop