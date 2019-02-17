<?php

use App\Models\Address;

use App\Models\Category;
use App\Models\CategoryImage;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Role;
use App\Models\Tag;
use App\Models\TagImage;
use App\Models\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function seed_admin_feature()
    {
        $role_admin = Role::firstOrCreate(
            ['name' => Role::ROLE_ADMIN],
            ['description' => 'For Admin authors']);
        // Users
        $melardev = \App\Models\User::firstOrCreate(
            ['email' => 'melardev@gmail.com'],
            [
                'username' => 'admin',
                'first_name' => 'adminFN',
                'last_name' => 'adminLN',
                'password' => bcrypt('password'),
            ]
        );
        if ($melardev->wasRecentlyCreated) { // check ->exists
            $melardev->roles()->detach(); // trim the ROLE_USER added
            $melardev->roles()->sync($role_admin);
        }
    }


    public function seed_users_feature()
    {
        // $role_authenticated = Role::firstOrCreate(['name' => Role::ROLE_USER]);
        // User::with('roles')->where('roles.name', Role::ROLE_USER);

        $role_authenticated_user = Role::firstOrCreate(
            ['name' => Role::ROLE_USER],
            ['description' => 'For authenticated users']);
        $normal_users_to_seed = 43;

        $users_count = User::whereHas('roles', function ($query) {
            return $query->where('roles.name', Role::ROLE_USER);
        })->count();

        $normal_users_to_seed_still = $normal_users_to_seed - $users_count;

        echo "[+] Seeding ${normal_users_to_seed_still} users\n";

        factory(\App\Models\User::class, $normal_users_to_seed_still)
            ->create()
            ->each(function ($author) use ($role_authenticated_user) {
                // Roles should be added bu UserObserver or User.php::boot()
                // $author->roles()->sync($role_authenticated_user);

            });
    }

    public function seed_categories()
    {
        //\App\Models\Category::firstOrCreate(['name' => 'C++', 'description' => 'c++ tutorials'])
        $categories_to_seed = 8;
        $categories_count = Category::count();
        $categories_to_seed_still = $categories_to_seed - $categories_count;
        echo "[+] Seeding categories ${categories_to_seed_still}\n";
        if ($categories_to_seed_still > 0)
            factory(Category::class, $categories_to_seed_still)->create()->each(function ($category) {
                $fileName = $this->faker->lexify('???????.png');
                CategoryImage::create([
                    'category_id' => $category->id,
                    'file_size' => $this->faker->numberBetween(1000, 20000),
                    'file_name' => $fileName,
                    'file_path' => $this->faker->lexify('/storage/images/categories/') . $fileName,
                    'original_name' => $this->faker->lexify('???????.png')
                ]);
            });
    }

    public function seed_tags()
    {
        //\App\Models\Category::firstOrCreate(['name' => 'C++', 'description' => 'c++ tutorials'])

        $tags_to_seed = 8;
        $tags_count = Tag::count();
        $tags_to_seed_still = $tags_to_seed - $tags_count;
        echo "[+] Seeding tags ${tags_to_seed_still}\n";
        if ($tags_to_seed_still > 0)
            factory(Tag::class, $tags_to_seed_still)->create()->each(function ($tag) {
                $fileName = $this->faker->lexify('???????.png');
                TagImage::create([
                    'tag_id' => $tag->id,
                    'file_size' => $this->faker->numberBetween(1000, 20000),
                    'file_name' => $fileName,
                    'file_path' => $this->faker->lexify('/storage/images/tags/') . $fileName,
                    'original_name' => $this->faker->lexify('???????.png')
                ]);
            });


    }


    function seed_products()
    {
        $products_to_seed = 52;
        $products_count = Product::count();
        $products_to_seed -= $products_count;
        echo "[+] Seeding Products ${products_to_seed}\n";

        if ($products_to_seed > 0) {

            factory(Product::class, $products_to_seed)
                ->create()
                ->each(function ($product) {
                    $tags = Tag::inRandomOrder()->get()->take(1 /*rand(0, Tag::count())*/);
                    $categories = Category::inRandomOrder()->get()->take(rand(0, Category::count() - 2));
                    $product->tags()->sync($tags);
                    $product->categories()->sync($categories);

                    $fileName = $this->faker->lexify('???????.png');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'file_size' => $this->faker->numberBetween(1000, 20000),
                        'file_name' => $fileName,
                        'file_path' => $this->faker->lexify('/storage/images/products/') . $fileName,
                        'original_name' => $this->faker->lexify('???????.png')
                    ]);
                });
        }
    }

    public function seed_comments()
    {
        $comments_to_seed = 70;
        $comments_count = Comment::count();
        $comments_to_seed -= $comments_count;

        echo "[+] Seeding ${comments_to_seed} Comment\n";
        if ($comments_to_seed > 0)
            factory(Comment::class, $comments_to_seed)->create();

    }


    public function seed_addresses()
    {
        $address_count = Address::count();
        $addresses_to_seed = 40;
        $addresses_to_seed -= $address_count;
        if ($addresses_to_seed > 0) {
            echo "[+] Seeding ${addresses_to_seed} Addresses\n";
            factory(\App\Models\Address::class, $addresses_to_seed)
                ->create()
                ->each(function ($address) {
                    // $order->user()->save(new \App\Models\Address([]));
                });
        }
    }

    public function seed_orders()
    {
        $orders_count = Order::count();
        $orders_to_seed = 30;
        $orders_to_seed -= $orders_count;
        if ($orders_to_seed > 0) {
            echo "[+] Seeding ${orders_to_seed} Orders\n";
            factory(Order::class, $orders_to_seed)
                ->create();
        }

        $order_items_count = OrderItem::count();
        $order_items_to_seed = 50;
        $order_items_to_seed -= $order_items_count;

        if ($order_items_to_seed) {
            echo "[+] Seeding ${order_items_to_seed} OrderItems";
            factory(OrderItem::class, $order_items_to_seed)
                ->create();
        }
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->seed_admin_feature();
        $this->seed_users_feature();

        $this->seed_tags();
        $this->seed_categories();

        $this->seed_products();
        $this->seed_comments();

        $this->seed_addresses();
        $this->seed_orders();
    }
}
