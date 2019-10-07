<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">{{$data->id ? '編輯話題' : '發表新話題'}}</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">內容管理</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{route('topics.index')}}" class="kt-subheader__breadcrumbs-link">話題</a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">{{$data->id ? '編輯話題' : '發表新話題'}}</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('topics.index')}}" class="btn btn-default btn-bold">Back</a>
            @if($data->draft ?? 1)
                <div class="btn-group">
                    <button class="btn btn-success btn-bold" onclick='submit("#topic_form", 1, "continue")'>草稿
                    </button>
                    <button class="btn btn-success btn-bold dropdown-toggle dropdown-toggle-split"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                         style="position: absolute; will-change: transform; top: 0; left: 0; transform: translate3d(113px, 35px, 0px);">
                        <ul class="kt-nav">
                            <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#topic_form", 1, "create")'>
                                <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                <span class="kt-nav__link-text">草稿並繼續新增</span>
                            </span>
                            </li>
                            <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#topic_form", 1, "exit")'>
                                <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                <span class="kt-nav__link-text">草稿並離開</span>
                            </span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif
            <div class="btn-group">
                <button class="btn btn-brand btn-bold" onclick='submit("#topic_form", 0, "continue")'>儲存</button>
                <button class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                     style="position: absolute; will-change: transform; top: 0; left: 0; transform: translate3d(113px, 35px, 0px);">
                    <ul class="kt-nav">
                        <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#topic_form", 0, "create")'>
                                <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                <span class="kt-nav__link-text">儲存並繼續新增</span>
                            </span>
                        </li>
                        <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#topic_form", 0, "exit")'>
                                <i class="kt-nav__link-icon flaticon2-writing"></i>
                                <span class="kt-nav__link-text">儲存並離開</span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
@include('partials._flash_message')
<!--begin::Portlet-->
    <div class="kt-portlet kt-portlet--mobile">
        <div class="kt-portlet__body">
            <form action="{{ $data->id ? route('topics.update', $data->id) : route('topics.store') }}" method="POST"
                  id="topic_form"
                  class="lar-form kt-margin-l-40-desktop kt-margin-r-40-desktop"
                  accept-charset="UTF-8" enctype="multipart/form-data">
                @if($data->id) <input type="hidden" name="_method" value="PUT"> @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>分類:</label>
                        <select class="form-control lar-select2-select" name="topic_category_id" aria-label="分類"
                                data-value="{{old('topic_category_id', $data->topic_category_id ?? '' )}}">
                            <option value="" hidden disabled selected>請選擇話題分類</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-4">
                        <label class="">作者:</label>
                        <select class="form-control lar-select2-select" name="user_id" aria-label="作者"
                                data-value="{{old('user_id', $data->user_id ?? '' )}}">
                            <option value="" hidden disabled selected>請選擇作者</option>
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="">顯示:</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="display"
                                       value="1" {{old('display', $data->display) ? 'checked' : ''}}> 是
                                <span></span>
                            </label>
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="display"
                                       value="0" {{old('display', $data->display) ? '' : 'checked'}}> 否
                                <span></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <label class="">置頂:</label>
                        <div class="kt-radio-inline">
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="top" value="1" {{old('top', $data->top) ? 'checked' : ''}}> 是
                                <span></span>
                            </label>
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="top" value="0" {{old('top', $data->top) ? '' : 'checked'}}> 否
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label>日期:</label>
                        <div class="lar-daterange input-group">
                            <input type="text"
                                   class="form-control lar-datetimepicker-input lar-datetimepicker-start filter-input"
                                   name="start_date" value="{{old('start_date', $data->start_date ?? '')}}"
                                   placeholder="發布時間" aria-label="From">
                            <div class="input-group-append">
                                <span class="input-group-text">~</span>
                            </div>
                            <input type="text"
                                   class="form-control lar-datetimepicker-input lar-datetimepicker-end filter-input"
                                   name="end_date" value="{{old('end_date', $data->end_date ?? '')}}"
                                   placeholder="下架時間(非必填)" aria-label="To">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label class="">討論數:</label>
                        <input type="number" class="form-control" name="reply_count"
                               value="{{old('reply_count', $data->reply_count ?? 0)}}" placeholder="請填寫數字"
                               aria-label="討論數" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="">點閱數:</label>
                        <input type="number" class="form-control" name="view_count"
                               value="{{old('view_count', $data->view_count ?? 0)}}" placeholder="請填寫數字"
                               aria-label="點閱數" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="">標題:</label>
                        <input type="text" class="form-control" name="title"
                               value="{{ old('title', $data->title ?? '' ) }}"
                               placeholder="請填寫標題" aria-label="標題" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <label class="">封面圖:</label>
                        <div class="lar-crop_image lar-crop_image--outline" data-width="450" data-height="200">
                            <input type="hidden" class="lar-crop_image-input" name="banner"
                                   value="{{old('banner', media_format($data->banner ?? null) )}}">
                            <div class="lar-crop_image__holder"></div>
                            <label class="lar-crop_image__upload" title="Upload">
                                <i class="fa fa-pen"></i>
                            </label>
                            <span class="lar-crop_image__cancel" title="Cancel"><i class="fa fa-times"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="">內容:</label>
                        <textarea name="body" class="form-control lar-editor-textarea" placeholder="請至少填寫三個字的内容"
                                  aria-label="內容" required>{{ old('body', $data->body ?? '' ) }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label class="">附件:</label>
                        <div id="appendixes" class="lar-multiple-files">
                            <div class="lar-multiple-files__wrapper"></div>
                            <div class="lar-multiple-files__list">
                                @foreach(old('appendixes', media_format($data->appendixes ?? []) ) as $json)
                                    <div class="lar-multiple-files__list-item">
                                        <input type="hidden" name="appendixes[]" value="{{$json}}">
                                        <div
                                            class="lar-multiple-files__list-label">{{json_decode($json)->file_name}}</div>
                                        <span class="lar-multiple-files__list-remove">
                                            <i class="flaticon2-cancel-music"></i>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="lar-multiple-files__status"></div>
                            <div class="lar-multiple-files__informer lar-multiple-files__informer--min"></div>
                        </div>
                        <span class="form-text text-muted">Max file size is 1MB and max number of files is 5.</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Portlet-->
</div>
<!-- end:: Subheader -->
