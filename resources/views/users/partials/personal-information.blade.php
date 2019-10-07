<div class="col-xl-12">
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">個人資訊 <small>更新你的訊息</small></h3>
            </div>
        </div>
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('users.update', $data->id)}}">
            @csrf
            <input type="hidden" name="_method" value="PUT"/>
            <input type="hidden" name="tab" value="personal-information"/>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">個人資訊:</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">照片</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="lar-crop_image lar-crop_image--outline" data-width="200" data-height="200">
                                    <input type="hidden" class="lar-crop_image-input" name="avatar"
                                           value="{{old('avatar', media_format($data->avatar ?? null) )}}">
                                    <div class="lar-crop_image__holder"></div>
                                    <label class="lar-crop_image__upload" title="Upload">
                                        <i class="fa fa-pen"></i>
                                    </label>
                                    <span class="lar-crop_image__cancel" title="Cancel"><i
                                            class="fa fa-times"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">名稱</label>
                            <div class="col-lg-9 col-xl-6">
                                <input class="form-control" type="text" name="name" value="{{$data->name}}"
                                       placeholder="Name" aria-label="Name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">簡介</label>
                            <div class="col-lg-9 col-xl-6">
                                <input class="form-control" type="text" name="introduction"
                                       value="{{$data->introduction}}"
                                       placeholder="Introduction" aria-label="Introduction">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">聯絡資訊:</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">聯絡電話</label>
                            <div class="col-lg-9 col-xl-6">
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="la la-phone"></i></span></div>
                                    <input type="text" class="form-control" name="contact_phone"
                                           value="{{$data->contact_phone}}"
                                           placeholder="Phone" aria-label="Contact Phone">
                                </div>
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
                            <button class="btn btn-brand">儲存</button>&nbsp;
                            <button type="reset" class="btn btn-secondary">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
