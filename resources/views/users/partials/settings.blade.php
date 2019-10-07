<div class="col-xl-12">
    <div class="kt-portlet kt-portlet--height-fluid">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">帳戶設定 <small>控制帳戶的權限、通知與啟用狀態</small></h3>
            </div>
        </div>
        <form class="kt-form kt-form--label-right" method="POST" action="{{route('users.update', $data->id)}}">
            @csrf
            <input type="hidden" name="_method" value="PUT"/>
            <input type="hidden" name="tab" value="settings"/>
            <div class="kt-portlet__body">
                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">帳號設定:</h3>
                            </div>
                        </div>
                        <div class="form-group form-group-sm row">
                            <label class="col-xl-3 col-lg-3 col-form-label">帳號啟用</label>
                            <div class="col-lg-9 col-xl-6">
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <input type="hidden" name="enabled" value="0">
                                        <input type="checkbox" {{active_class($data->enabled, 'checked')}}
                                        name="enabled" value="1">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg">
                </div>

                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">通知設定:</h3>
                            </div>
                        </div>
                        <div class="form-group form-group-sm row">
                            <label class="col-xl-3 col-lg-3 col-form-label">Email通知</label>
                            <div class="col-lg-9 col-xl-6">
                                <span class="kt-switch kt-switch--outline kt-switch--icon kt-switch--success">
                                    <label>
                                        <input type="hidden" name="email_notification" value="0">
                                        <input type="checkbox" {{active_class($data->email_notification, 'checked')}}
                                        name="email_notification">
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg">
                </div>

                <div class="kt-section kt-section--first">
                    <div class="kt-section__body">
                        <div class="row">
                            <label class="col-xl-3"></label>
                            <div class="col-lg-9 col-xl-6">
                                <h3 class="kt-section__title kt-section__title-sm">權限設定:</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-xl-3 col-lg-3 col-form-label">職務</label>
                            <div class="col-lg-9 col-xl-6">
                                <select class="form-control lar-select2-select" name="roles[]" data-value="" multiple
                                        style="width:100%;">
                                    @foreach($roles as $role)
                                        <option
                                            value="{{$role->name}}" {{active_class($data->hasRole($role->name), 'selected')}}>
                                            {{$role->name}}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="form-text text-muted">如果你需要了解每個職務的相關權限，請至<a
                                        href="{{route('roles.index')}}">職務頁面</a>查詢</span>
                            </div>
                        </div>
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
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-lg-3 col-xl-3">
                        </div>
                        <div class="col-lg-9 col-xl-9">
                            <button class="btn btn-brand btn-bold">儲存
                            </button>&nbsp;
                            <button type="reset" class="btn btn-secondary">取消</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
