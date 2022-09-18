<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'city',
        'active',
        'superuser',
        'email',
        'password',
        'orders_amount',
        'orders_sum',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Связь юзер - корзина
     * @return HasOne
     */
    public function cart(): HasOne
    {
        return $this->hasOne('App\Models\Cart');
    }

    /**
     * Связь юзер - заказы
     * @return void
     */
    public function orders(): void
    {
        $this->hasMany('App\Models\OrdersList');
    }

    /**
     * Связь юзер - промокоды
     * @return BelongsToMany
     */
    public function promocodes(): BelongsToMany
    {
        return $this->belongsToMany('App\Models\UserPromocode');
    }

    /**
     * Связь юзер - роли
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(UserRole::class);
    }

    /**
     * Получение юзера по его почте
     * @param string $email
     * @return Builder|Model|null
     */
    public static function getUserByEmail(string $email): Model|Builder|null
    {
        return self::query()->where('email', $email)->first();
    }

    /**
     * Создание корзины для юзера
     * @return Builder|Model
     */
    public function createCart(): Model|Builder
    {
        return Cart::query()->create(['user_id' => $this->id]);
    }

    /**
     * Update statistic about amount user orders and total their cost
     *
     * @param int $order_total_cost
     * @return void
     */
    public function updateOrdersStatistic(int $order_total_cost): void
    {
        $this->update([
            'orders_amount' => $this->orders_amount + 1,
            'orders_sum' => $this->orders_sum + $order_total_cost
        ]);
    }

    /**
     * Giving promocode for many orders
     *
     * @return void
     */
    public function checkAndGiveManyOrdersPromocode(): void
    {
        if($this->orders_amount >= 10 && $this->orders_sum >= 7000){
            $promocode = UserPromocode::getPromocode('many-orders-code');

            if($promocode){
                $this->promocodes()->attach($promocode->id);
            }
        }
    }

}
