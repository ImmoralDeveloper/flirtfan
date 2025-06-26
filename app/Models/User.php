<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'role',
        'bio',
        'image',
        'cover',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function performer()
    {
        return $this->hasOne(Performer::class);
    }
    public function isPerformer()
    {
        return $this->role === "performer";
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // Usuarios que este usuario sigue
    public function following()
    {
        return $this->belongsToMany(
            User::class,
            'following_users',
            'follower_id',     // este usuario
            'following_id'     // a quién sigue
        )->withTimestamps();
    }

    // Usuarios que siguen a este usuario
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'following_users',
            'following_id',    // este usuario
            'follower_id'      // quién lo sigue
        )->withTimestamps();
    }


    public function follow(User $user): bool
    {
        if ($this->id === $user->id || $this->isFollowing($user)) {
            return false;
        }

        $this->following()->attach($user->id);
        return true;
    }

    public function unfollow(User $user): bool
    {
        if (!$this->isFollowing($user)) {
            return false;
        }

        $this->following()->detach($user->id);
        return true;
    }

    public function isFollowing(User $user): bool
    {
        return $this->following()->where('following_id', $user->id)->exists();
    }

    public function isFollowedBy(User $user): bool
    {
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_likes')->withTimestamps();
    }

    public function hasLiked(Post $post): bool
    {
        return $this->likedPosts()->where('post_id', $post->id)->exists();
    }

    public function like(Post $post): bool
    {
        if ($this->hasLiked($post)) {
            return false;
        }

        $this->likedPosts()->attach($post->id);
        return true;
    }

    public function unlike(Post $post): bool
    {
        if (!$this->hasLiked($post)) {
            return false;
        }

        $this->likedPosts()->detach($post->id);
        return true;
    }

    public function totalLikesReceived(): int
    {
        return $this->posts()
            ->withCount('likedByUsers') // relación en Post
            ->get()
            ->sum('liked_by_users_count');
    }
    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }
    public function likedComments()
    {
        return $this->belongsToMany(PostComment::class, 'comment_likes')->withTimestamps();
    }

    public function conversations()
    {
        return Conversation::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }
    public function getLatestConversationsAttribute()
    {
        return $this->conversations()
            ->with([
                'messages' => function ($query) {
                    $query->latest();
                }
            ])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->first()->created_at ?? now();
            });
    }

    public function getLatestConversationAttribute()
    {
        return $this->latest_conversations->first();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function activeStories()
    {
        return $this->stories()
            ->where('created_at', '>=', now()->subHours(24));
    }

    public function getHasActiveStoryAttribute(): bool
    {
        return $this->activeStories()->exists();
    }

    public function viewedStories()
    {
        return $this->belongsToMany(Story::class, 'story_views')
            ->withPivot('viewed_at');
    }

    public function hasViewedStory(Story $story): bool
    {
        return $this->viewedStories()->where('story_id', $story->id)->exists();
    }

    public function getHasUnviewedStoryAttribute(): bool
    {
        $viewer = auth()->user();
        if (!$viewer)
            return false;

        // Obtener IDs de historias vistas por el usuario autenticado
        $viewedIds = $viewer->viewedStories->pluck('id')->toArray();

        // Verificar si hay alguna historia activa no vista
        return $this->stories
            ->where('created_at', '>=', now()->subHours(24))
            ->contains(function ($story) use ($viewedIds) {
                return !in_array($story->id, $viewedIds);
            });
    }

    public function getUnreadConversationsAttribute()
    {
        return $this->conversations()
            ->whereHas('messages', function ($query) {
                $query->where('is_read', false)
                    ->where('sender_id', '!=', $this->id);
            })
            ->get();
    }
    public function getShortNameAttribute(): string
    {
        $part = explode(' ', trim($this->name));

        if (count($part) === 0 || empty($part[0])) {
            return '';
        }

        return isset($part[1]) ? "$part[0] $part[1]" : $part[0];
    }

}
