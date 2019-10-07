<div class="col-xl-12">
    <div class="kt-portlet kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">變更密碼<small>變更或重設帳戶密碼</small></h3>
            </div>
        </div>
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('users.change-password', $data->id)}}">
            @csrf
            <input type="hidden" name="_method" value="PUT"/>
            <input type="hidden" name="tab" value="change-password"/>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        <div
                            class="alert alert-solid-danger alert-bold fade show kt-margin-t-20 kt-margin-b-40"
                            role="alert">
                            <div class="alert-icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <div class="alert-text">若你忘記您的密碼，管理員還是有辦法幫你重設密碼，不過這些辦法相當繁瑣，所以請盡量記住管理好您的密碼！
                            </div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">變更或重設帳戶密碼:</h3>
                            </div>
                        </div>
                        {{--                        <div class="form-group row">--}}
                        {{--                            <label class="col-xl-3 col-lg-3 col-form-label">目前的密碼</label>--}}
                        {{--                            <div class="col-lg-9 col-xl-6">--}}
                        {{--                                <input type="password" class="form-control" name="current_password" value=""--}}
                        {{--                                       placeholder="Current password" aria-label="password">--}}
                        {{--                                <a href="#" class="kt-link kt-font-sm kt-font-bold kt-margin-t-5">忘記密碼?</a>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">新的密碼</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control" name="password" value=""
                                       placeholder="New password" aria-label="password">
                            </div>
                        </div>
                        <div class="form-group form-group-last row">
                            <label class="col-xl-3 col-lg-3 col-form-label">確認密碼</label>
                            <div class="col-lg-9 col-xl-6">
                                <input type="password" class="form-control" name="password_confirmation" value=""
                                       placeholder="Verify password" aria-label="password">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3">
                        </div>
                        <div class="col-lg-9 col-xl-9">
                            <button class="btn btn-brand btn-bold">變更密碼
                            </button>&nbsp;
                            <button type="reset" class="btn btn-secondary">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
