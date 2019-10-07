<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">{{$data->id ? '編輯職務' : '新增職務'}}</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">用戶與權限</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{route('roles.index')}}" class="kt-subheader__breadcrumbs-link">職務</a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">{{$data->id ? '編輯職務' : '新增職務'}}</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('roles.index')}}" class="btn btn-default btn-bold">Back</a>
            <div class="btn-group">
                <button class="btn btn-brand btn-bold" onclick='submit("#topic_form", 0, "continue")'>儲存</button>
                <button class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(113px, 35.25px, 0px);">
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
            <form action="{{ $data->id ? route('roles.update', $data->id) : route('roles.store') }}" method="POST"
                  id="topic_form"
                  class="lar-form kt-margin-l-40-desktop kt-margin-r-40-desktop"
                  accept-charset="UTF-8" enctype="multipart/form-data">
                @if($data->id) <input type="hidden" name="_method" value="PUT"> @endif
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label class="">職務:</label>
                        <input type="text" class="form-control" name="name"
                               value="{{ old('name', $data->name ?? '' ) }}"
                               placeholder="請填寫職務名稱" aria-label="職務" required>
                    </div>
                </div>
                <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit"></div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">用戶與權限</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="kt-checkbox-list">
                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                <input name="permissions[]" type="checkbox"
                                       value="manage_users" {{active_class($data->hasPermissionTo('manage_users'), 'checked')}}>
                                用戶
                                <span></span>
                            </label>
                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                <input name="permissions[]" type="checkbox"
                                       value="manage_roles" {{active_class($data->hasPermissionTo('manage_roles'), 'checked')}}>
                                職務
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">内容管理</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="kt-checkbox-list">
                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                <input name="permissions[]" type="checkbox"
                                       value="manage_contents_topic_categories" {{active_class($data->hasPermissionTo('manage_contents_topic_categories'), 'checked')}}>
                                分類
                                <span></span>
                            </label>
                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                <input name="permissions[]" type="checkbox"
                                       value="manage_contents_topics" {{active_class($data->hasPermissionTo('manage_contents_topics'), 'checked')}}>
                                話題
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-xl-3 col-lg-3 col-form-label">站點管理</label>
                    <div class="col-lg-9 col-xl-6">
                        <div class="kt-checkbox-list">
                            <label class="kt-checkbox kt-checkbox--tick kt-checkbox--brand">
                                <input name="permissions[]" type="checkbox"
                                       value="manage_site_settings" {{active_class($data->hasPermissionTo('manage_site_settings'), 'checked')}}>
                                站點設定
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Portlet-->
</div>
<!-- end:: Subheader -->
