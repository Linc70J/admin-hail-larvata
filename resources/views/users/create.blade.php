<!-- begin:: Subheader -->
<div class="kt-subheader  kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">

            <h3 class="kt-subheader__title">新增用戶</h3>

            <span class="kt-subheader__separator kt-subheader__separator--v"></span>

            <div class="kt-subheader__breadcrumbs">
                <a href="/" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <span class="kt-subheader__breadcrumbs-link">用戶與權限</span>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="{{route('users.index')}}" class="kt-subheader__breadcrumbs-link">用戶</a>
                <span class="kt-subheader__breadcrumbs-separator"></span>
                <a href="#" class="kt-subheader__breadcrumbs-link">新增用戶</a>
            </div>
        </div>

        <div class="kt-subheader__toolbar">
            <a href="{{route('users.index')}}" class="btn btn-default btn-bold">Back</a>
            <div class="btn-group">
                <button class="btn btn-brand btn-bold"
                        onclick='submit("#users_form", 0, "continue")'>@lang('crud.save')</button>
                <button class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end"
                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(113px, 35.25px, 0px);">
                    <ul class="kt-nav">
                        <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#users_form", 0, "create")'>
                                <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                <span class="kt-nav__link-text">儲存並繼續新增</span>
                            </span>
                        </li>
                        <li class="kt-nav__item">
                            <span class="kt-nav__link"
                                  onclick='submit("#users_form", 0, "exit")'>
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
            <form action="{{ route('users.store') }}" method="POST"
                  id="users_form"
                  class="lar-form kt-form kt-form--label-right kt-margin-l-40-desktop kt-margin-r-40-desktop"
                  accept-charset="UTF-8" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label">你的姓名</label>
                    <div class="col-lg-6">
                        <input type="text" name="name" class="form-control" value="{{ old('name', '' ) }}"
                               placeholder="請填寫姓名" aria-label="姓名">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label">E-Mail (帳號)</label>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i
                                        class="la la-at"></i></span></div>
                            <input type="text" name="email" class="form-control" value="{{ old('email', '' ) }}"
                                   placeholder="請填寫E-Mail" aria-label="帳號">
                        </div>
                        <span class="form-text text-muted">E-Mail不會被公開顯示</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-lg-4 col-form-label">啟用</label>
                    <div class="col-lg-6">
                        <div class="kt-radio-inline">
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="enabled"
                                       value="1" {{old('enabled', 1) ? 'checked' : ''}}> 是
                                <span></span>
                            </label>
                            <label class="kt-radio kt-radio--solid">
                                <input type="radio" name="enabled"
                                       value="0" {{old('enabled', 1) ? '' : 'checked'}}> 否
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
