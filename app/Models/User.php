<?php

namespace App\Models;

use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use App\Services\MediaLibrary\LMedia;
use Auth;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $bu_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property boolean $enabled
 * @property string|null $introduction
 * @property int $notification_count
 * @property string|null $last_active_at
 * @property Media|string|null $avatar
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read Collection|Permission[] $permissions
 * @property-read Collection|TopicReply[] $replies
 * @property-read Collection|Role[] $roles
 * @property-read Collection|Topic[] $topics
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereBuId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIntroduction($value)
 * @method static Builder|User whereLastActiveAt($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereNotificationCount($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Traits\LastActiveAtHelper;
    use Traits\ActiveUserHelper;
    use SoftDeletes;
    use HasRoles;
    use HasMediaTrait;
    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bu_id', 'name', 'email', 'password', 'introduction', 'contact_phone', 'enabled', 'email_notification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function notify($instance)
    {
        // 如果要通知的人是當前用戶，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    public function getDisplayStatusAttribute()
    {
        return ($this->enabled ? 2 : 0) + ($this->email_verified_at ? 1 : 0);
    }

    public function getAvatarAttribute()
    {
        return $this->getFirstMedia('avatar');
    }

    /**
     * 設定大頭貼
     *
     * @param $value
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public function setAvatarAttribute($value)
    {
        $mediaJson = json_decode($value);
        if ($mediaJson->type ?? 'empty' != 'database')
            $this->clearMediaCollection('avatar');
        if ($mediaJson->type ?? 'empty' != 'empty')
            LMedia::save($this, $mediaJson->type, 'avatar', $mediaJson->file_name, $mediaJson->url);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function topicReplies()
    {
        return $this->hasMany(TopicReply::class);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
