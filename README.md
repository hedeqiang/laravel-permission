<h1 align="center"> laravel-permission </h1>

<p align="center"> 基于 spatie/laravel-permission 二次开发的按钮级权限管理 Laravel 扩展包。(角色、权限、菜单、按钮).</p>


> 本扩展包来自 [achais/laravel-permission](https://github.com/achais/laravel-permission) ,fork 此扩展目的在于 Laravel 7 的版本使用。如需在 Laravel 5.5 版本使用请使用 [achais/laravel-permission](https://github.com/achais/laravel-permission) 。所有代码均来自：[achais/laravel-permission](https://github.com/achais/laravel-permission) ，感谢 [作者 achais](https://github.com/achais)

## Requirement
- "php": ">=7.2"
- "laravel/framework": "^7.0"

## Installing

```shell
$ composer require hedeqiang/laravel-permission -vvv
```

## Laravel
生成配置文件
```shell
# 如果你安装过 spatie/laravel-permission 并创建了 permission.php 请忽略这步
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
```

在 permission.php 对应位置中加入菜单配置信息

```php
<?php

return [
    'models' => [
        // ...
        'role' => Hedeqiang\Permission\Models\Role::class,
        'menu' => Hedeqiang\Permission\Models\Menu::class,
    ],

    'table_names' => [
        // ...
        'menus' => 'menus',
        'role_has_menus' => 'role_has_menus',
        'menu_table' => 'menu_table',
    ],

    // guard 名称
    'role_guard_name' => 'admin',

];
```

生成迁移文件 
```shell
# 如果你安装过 spatie/laravel-permission 并创建了 migrations 请忽略这步
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"

# 这是本包提供的生成 menus 和 role_has_menus 数据库表的 migrations
php artisan vendor:publish --provider="Hedeqiang\Permission\PermissionServiceProvider" --tag="migrations"
```

接下来在使用 migrations 生成数据库表
```shell
php artisan migrate
```

## Usage

首先, 添加 Hedeqiang\Permission\Traits\HasRoles 特性到你的 User model(s):

```php
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hedeqiang\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // 注意这里是 \Hedeqiang\Permission\Traits\HasRoles
    use HasRoles;

    // ...
}
```

关于角色和权限的操作请查看这里. [spatie/laravel-permission](https://github.com/spatie/laravel-permission)

关于角色和菜单的操作继续往下看. 😁😁😁

创建一个角色和菜单
```php
use Hedeqiang\Permission\Models\Role;
use Hedeqiang\Permission\Models\Menu;

$role = Role::create(['name' => '管理员']);
$menu = Menu::create([
    'name' => '文章列表',
    'url' => '/posts',
    'type' => Menu::TYPE_MENU,
    'icon' => 'iconName',
]);
```

关联角色和菜单
```php
$role->giveMenuTo($menu);
$menu->assignRole($role);
```

同时关联多个角色和菜单
```php
$role->syncMenus($menus);
$menu->syncRoles($roles);
```

获取用户菜单树

> 菜单类型分为: 目录、菜单、按钮  
> 目录: 无可查看的页面, 仅分类使用  
> 菜单: 可查看的页面  
> 按钮: 无可查看的页面, 仅在菜单页面内显示

```php
$user = \Auth::user();

$parentId = null; // 父菜单ID (用在获取指定菜单下的子菜单树)
$showButton = false; // 是否显示按钮类型的菜单

$user->getMenuTree($parentId, $showButton);
```

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/hedeqiang/laravel-permission/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/hedeqiang/laravel-permission/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
