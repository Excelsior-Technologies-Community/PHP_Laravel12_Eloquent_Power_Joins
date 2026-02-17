# PHP_Laravel12_Eloquent_Power_Joins
```php
- Laravel 12 based web application demonstrating advanced Eloquent querying using Eloquent Power Joins with real relational data, rendered in Blade
```

# Step 1: Install Fresh Laravel 12 Application
Open Terminal / CMD and run:
```php
composer create-project laravel/laravel:^12.0 PHP_Laravel12_Eloquent_Power_Joins
```
Move into project folder:
```php
cd PHP_Laravel12_Eloquent_Power_Joins
```
Generate application key:
```php
php artisan key:generate
```

# Step 2: Configure Database (.env)
Open .env file and update database credentials:
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=laravel12_power_joins
DB_USERNAME=root
DB_PASSWORD=
```
Create database manually:
```php
CREATE DATABASE laravel12_power_joins;
```
# Step 3: Run Default Migration
```php
php artisan migrate
```

# Step 4: Install Eloquent Power Joins Package
```php
composer require kirschbaum-development/eloquent-power-joins
```

# Step 5: Create Migrations
Create required migrations:
```php
php artisan make:migration create_orders_table
php artisan make:migration create_products_table
php artisan make:migration create_order_items_table
```
Run migrations:
```php
php artisan migrate
```

# Step 6: Setup Models with Power Joins
User Model
```php
Path: app/Models/User.php
```
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
```
Order Model
```php
Path: app/Models/Order.php
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id','order_no'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
```
Product Model
```php
Path: app/Models/Product.php
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // 🔹 Table name (IMPORTANT)
    // Remove this line ONLY if your table name is exactly `products`
    protected $table = 'products';

    // 🔹 Mass assignable fields
    protected $fillable = [
        'title',
        'price',
    ];

    // 🔹 Relationship: Product → Order Items
  public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

}
```
OrderItem Model
```php
Path: app/Models/OrderItem.php
```
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'qty'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
```

# Step 7: Create Controller Using Power Joins
Create controller:
```php
php artisan make:controller OrderController
```
Path: app/Http/Controllers/OrderController.php
```php
<?php

namespace App\Http\Controllers;

use App\Models\User;

class OrderController extends Controller
{
    public function index()
{
    $users = User::query()
        ->joinRelationship('orders.items.product')
        ->select(
            'users.name as user_name',
            'products.name as product_name',
            'order_items.quantity as quantity'
        )
        ->get();

    return view('orders.index', compact('users'));
}


}
```

# Step 8: Define Web Routes
Path: routes/web.php
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [OrderController::class, 'index']);
```

# Step 9: Create Blade View
Path: resources/views/orders/index.blade.php
```php
<!DOCTYPE html>
<html>
<head>
    <title>Orders (Power Joins)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f7fa;
            margin: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e2f0d9;
        }

        td {
            color: #555;
        }
    </style>
</head>
<body>

<h2>Orders with Products</h2>

<table>
    <thead>
        <tr>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $row)
            <tr>
                <td>{{ $row->user_name }}</td>
                <td>{{ $row->product_name }}</td>
                <td>{{ $row->quantity }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
```

# Step 10: Seed Sample Data
Create seeders:
```php
php artisan make:seeder UserSeeder
php artisan make:seeder ProductSeeder
php artisan make:seeder OrderSeeder
php artisan make:seeder OrderItemSeeder
```
Register seeders in:
```php
Path: database/seeders/DatabaseSeeder.php
```
```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    $this->call([
        UserSeeder::class,
        ProductSeeder::class,
        OrderSeeder::class,
        OrderItemSeeder::class,
    ]);
}
}
```
Run seeders:
```php
php artisan db:seed
```

# Step 11: Run Laravel Project
```php
php artisan serve
```
Open browser:
```php
http://127.0.0.1:8000/orders
```

<img width="1278" height="669" alt="image" src="https://github.com/user-attachments/assets/cf277156-66f2-4c18-8076-7ba84b638c41" />

# Project Folder Structure
```php
PHP_Laravel12_Eloquent_Power_Joins
├── app
│   ├── Models
│   └── Http
│       └── Controllers
│           └── OrderController.php
│
├── database
│   ├── migrations
│   └── seeders
│
├── resources
│   └── views
│       └── orders
│           └── index.blade.php
│
├── routes
│   └── web.php
│
├── .env
├── artisan
```
# Explanation
```php
- Uses Eloquent Power Joins for complex joins
- No raw SQL queries
- Relationship-driven architecture
- Blade-based browser output
- Clean MVC structure
```

