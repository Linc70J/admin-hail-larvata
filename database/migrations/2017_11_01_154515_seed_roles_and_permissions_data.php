<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SeedRolesAndPermissionsData extends Migration
{
    public function up()
    {
        // 清除Cache
        app()['cache']->forget('spatie.permission.cache');

        // 新增軟體維運員職務，並賦予權限
        Role::create(['name' => 'SoftwareMaintainer']);

        // 新增系統管理員職務，並賦予權限
        Role::create(['name' => 'Administrator']);

        // 先新增權限
        Permission::create(['name' => 'manage_users', 'display_name' => '用戶']);
        Permission::create(['name' => 'manage_roles', 'display_name' => '職務']);
        Permission::create(['name' => 'manage_contents_topic_categories', 'display_name' => '分類']);
        Permission::create(['name' => 'manage_contents_topics', 'display_name' => '話題']);
        Permission::create(['name' => 'manage_site_settings', 'display_name' => '站點設定']);

        // 新增站長職務，並賦予權限
        $founder = Role::create(['name' => 'Founder']);
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('manage_roles');
        $founder->givePermissionTo('manage_contents_topic_categories');
        $founder->givePermissionTo('manage_contents_topics');
        $founder->givePermissionTo('manage_site_settings');

        // 新增維運職務，並賦予權限
        $maintainer = Role::create(['name' => 'Maintainer']);
        $maintainer->givePermissionTo('manage_contents_topic_categories');
        $maintainer->givePermissionTo('manage_contents_topics');
    }

    public function down()
    {
        // 清除Cache
        app()['cache']->forget('spatie.permission.cache');

        // 清空所有資料庫數據
        $tableNames = config('permission.table_names');

        Model::unguard();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        Model::reguard();
    }
}
