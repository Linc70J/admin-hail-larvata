<?php

namespace App\Models;

use App\Services\MediaLibrary\LMedia;
use Carbon\Carbon;
use DB;
use Eloquent;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * App\Models\Topic
 *
 * @property int $id
 * @property int $bu_id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $topic_category_id
 * @property int $reply_count
 * @property int $view_count
 * @property int $last_reply_user_id
 * @property boolean $draft
 * @property boolean $display
 * @property boolean $top
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property string $excerpt
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property Media|null $banner
 * @property Collection|Media[] $appendixes
 * @property-read TopicCategory $topicCategory
 * @property-read Collection|TopicReply[] $topicReplies
 * @property-read User $user
 * @method static Builder|Topic newModelQuery()
 * @method static Builder|Topic newQuery()
 * @method static Builder|Model ordered()
 * @method static Builder|Topic query()
 * @method static Builder|Topic recent()
 * @method static Builder|Topic recentHot()
 * @method static Builder|Topic recentReplied()
 * @method static Builder|Topic orderByCustom()
 * @method static Builder|Topic whereBody($value)
 * @method static Builder|Topic whereBuId($value)
 * @method static Builder|Topic whereTopicCategoryId($value)
 * @method static Builder|Topic whereCreatedAt($value)
 * @method static Builder|Topic whereExcerpt($value)
 * @method static Builder|Topic whereId($value)
 * @method static Builder|Topic whereLastReplyUserId($value)
 * @method static Builder|Topic whereOrder($value)
 * @method static Builder|Topic whereReplyCount($value)
 * @method static Builder|Topic whereSlug($value)
 * @method static Builder|Topic whereTitle($value)
 * @method static Builder|Topic whereUpdatedAt($value)
 * @method static Builder|Topic whereUserId($value)
 * @method static Builder|Topic whereViewCount($value)
 * @method static Builder|Topic withOrder($order)
 * @mixin Eloquent
 */
class Topic extends Model implements Sortable, HasMedia
{
    use SortableTrait, HasMediaTrait;

    protected $hot_days = 30;    // 多少天内的熱門話題

    protected $fillable = ['title', 'body', 'topic_category_id', 'draft', 'display', 'top', 'start_at', 'end_at', 'excerpt', 'slug'];

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    public function getDisplayStatusAttribute()
    {
        if ($this->draft)
            return 0;

        if (!$this->display)
            return 0;

        $start = Carbon::parse($this->start_at);
        $now = Carbon::now();
        $end = Carbon::parse($this->end_at);
        if ($now->between($start, $end))
            return 1;
        return 0;
    }

    public function getBannerAttribute()
    {
        return $this->getFirstMedia('banner');
    }

    public function setBannerAttribute($value)
    {
        $media = json_decode($value);
        if ($media->type ?? 'empty' != 'database')
            $this->clearMediaCollection('banner');
        if ($media->type ?? 'empty' != 'empty')
            LMedia::save($this, $media->type, 'banner', $media->file_name, $media->url);
    }

    public function getAppendixesAttribute()
    {
        return $this->getMedia('appendix');
    }

    public function setAppendixesAttribute($value)
    {
        $ids = [];

        foreach ($value as $item) {
            try {
                $media = json_decode($item);
                $newMedia = LMedia::save($this, $media->type, 'appendix', $media->file_name, $media->url);
                if ($media->type == 'database')
                    $ids[] = $media->id;
                elseif ($newMedia)
                    $ids[] = $newMedia->id;

            } catch (Exception $e) {
            }
        }
        $this->media()->where('collection_name', 'appendix')->whereNotIn('id', $ids)->delete();
    }

    public function setCreatedAt($value)
    {
        $this->{static::CREATED_AT} = $value;
        $this->attributes['start_at'] = $this->attributes['start_at'] ?? $value;
    }

    public function topicReplies()
    {
        return $this->hasMany(TopicReply::class);
    }

    public function topicCategory()
    {
        return $this->belongsTo(TopicCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeWithOrder($query, $order)
    {
        // 不同的排序，使用不同的讀取邏輯
        /** @var Topic $query */
        $query = $this->orderBy('top', 'desc');
        switch ($order) {
            case 'custom':
                $query = $query->orderByCustom();
                break;
            case 'replied':
                $query = $query->recentReplied();
                break;
            case 'hot':
                $query = $query->recentHot();
                break;
            default:
                $query = $query->recent();
                break;
        }
        // 預加载防止 N+1 問題
        return $query->with('user', 'topicCategory');
    }

    public function scopeOrderByCustom(Builder $query)
    {
        return $query->orderBy('order', 'desc')->orderBy('start_at', 'desc');
    }

    public function scopeRecentReplied(Builder $query)
    {
        // 當話題有新回覆時，我們將更新話題的 reply_count 屬性，
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecentHot(Builder $query)
    {
        $dataTime = Carbon::now()->subDays($this->hot_days)->toDateTimeString();
        return $query->orderBy(DB::raw("(select count(*) from `topic_replies` where `topics`.`id` = `topic_replies`.`topic_id` and `topic_replies`.`updated_at` > '${dataTime}')"), 'desc');
    }

    public function scopeRecent(Builder $query)
    {
        // 按照創建時間排序
        return $query->orderBy('start_at', 'desc');
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}
