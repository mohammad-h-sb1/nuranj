<?php

namespace App\Models;

use App\Models\V2\ActiveCode;
use App\Models\V2\CategoryShop;
use App\Models\V2\Permission;
use App\Models\V2\Product;
use App\Models\V2\Role;
use App\Models\V2\Shop;
use App\Models\V2\ShopCategory;
use App\Models\V2\ShopMeta;
use App\Models\V2\ShopSting;
use App\Models\V2\TicketProduct;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const TYPE_ADMIN='admin';
    const TYPE_MANAGER='manager';
    const TYPE_CUSTOMER='customer';
    const TYPE_EMPLOYEE='employee';
    const TYPE_INTERN='intern';
    const TYPE_ADMIN_SHOP='admin_shop';
    const TYPES=[self::TYPE_ADMIN,self::TYPE_MANAGER,self::TYPE_EMPLOYEE,self::TYPE_INTERN,self::TYPE_CUSTOMER,self::TYPE_ADMIN_SHOP];

    const GENDER_MAN='mane';
    const GENDER_WOMAN='woman';
    const GENDER=[self::GENDER_WOMAN,self::GENDER_MAN];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'mobile',
        'api_token',
        'two_factory_type',
        'date_of_birth',
        'national_code',
        'national_code_img_url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function customerClubs()
    {
        return $this->hasMany(CustomerClub::class);
    }

    public function users()
    {
        return $this->hasMany(CustomerClubLog::class);
    }

    public function workTeams()
    {
        return $this->hasMany(WorkTeam::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function consultings()
    {
        return $this->hasMany(Consulting::class);
    }

    public function consultingsLogs()
    {
        return $this->hasMany(ConsultingLog::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function activeCode()
    {
        return $this->hasMany(ActiveCode::class);
    }

    public function hasTwoFactorAuthEnable()
    {
        return $this->two_factory_type !== 'of';
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasPermission($permission)
    {
        return $this->permissions->contains('name',$permission->name) || $this->hasRole($permission->roles);
    }

    private function hasRole($roles)
    {
       return !! $roles->intersect($this->roles)->all();
    }

    public function categoryShops()
    {
        return $this->hasMany(CategoryShop::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function ShopMeta()
    {
        return $this->hasMany(ShopMeta::class);
    }

    public function ShopCategories()
    {
        return $this->hasMany(ShopCategory::class);
    }

    public function ShopStings()
    {
        return $this->hasMany(ShopSting::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class,'user_id','user_id');
    }

    public function TicketProducts()
    {
        return $this->belongsTo(TicketProduct::class);
    }
}
