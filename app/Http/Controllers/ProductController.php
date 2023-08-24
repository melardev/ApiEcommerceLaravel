<?php

namespace App\Http\Controllers;


use App\Dtos\Response\Product\ProductDetailsDto;
use App\Dtos\Response\Product\ProductListDto;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class ProductController extends BaseController
{
    public function __construct()
    {
        // authenticate except for read based actions: index and show
        $this->middleware('jwt.verify')->only(['store', 'update', 'destroy']);

    }

    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });


        // By reading the Framework source code I see the page is set to $page from input Request,
        // page_size is set to paginate(page_size)
        // that means we do not have to setCurrentPageResolver because it works
        // if we sent ?page= in the url
        $products = Product::orderBy('created_at', 'desc')
            ->withCount('comments')
            ->paginate($page_size);

        return $this->sendSuccess(ProductListDto::build($products, $request->path()));

    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (is_null($product))
            return $this->sendError('Product was not found');

        $product->comments_count = $product->comments()->count();
        // return $this->sendSuccessResponse($product->toArray(), 'Product read succesfully');

        return $this->sendSuccessResponse(ProductDetailsDto::build($product));
    }

    // TODO: Not working
    public function getById($id)
    {
        $product = Product::find($id);
        if ($product != null)
            return $this->sendSuccessResponse(ProductDetailsDto::build($product));
        else
            return $this->sendError('Product not found');
    }


    public function getByCategory(Request $request, $category_name)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product
            ::whereHas('categories', function ($query) use ($category_name) {
                $query->where('slug', '=', $category_name);
            })
            ->orderBy('created_at', 'desc')
            ->with(array('user' => function ($query) {
                $query->select('id', 'name as username');
            }))
            ->withCount('Comment')
            ->paginate($page_size);
        return $this->sendSuccess(ProductListDto::build($products, $request->getRequestUri()));
    }

    public function getByTag(Request $request, $tag_name)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        //Product::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Product
            ::whereHas('tags', function ($query) use ($tag_name) {
                $query->where('slug', '=', $tag_name);
            })
            ->orderBy('created_at', 'desc')
            ->withCount('comments')
            ->paginate($page_size);

        return $this->sendSuccess(ProductListDto::build($products, $request->getRequestUri()));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            // 'slug' => 'required|alpha_dash|min:5|max:255|unique:products,slug',
            'description' => 'required',
            // 'category_id' => 'sometimes|integer',
            'price' => 'required',
            'stock' => 'required'
        ], [
            'name' => 'You must provide a name for the product',
            'description' => 'You must provide a description for your product'
        ]);

        if ($validator->fails())
            return $this->sendError('errors', $validator->errors());

        $product = new  Product($request->only('name', 'description', 'price', 'stock'));
        $product->save();


        $tagsInput = $request->input('tags');
        $categoriesInput = $request->input('categories');
        $tagNames = array_keys($request->input('tags'));
        $categoryNames = array_keys($request->input('categories'));

        if ($tagNames && !empty($tagNames)) {

            $tags = array_map(function ($name) use ($tagsInput) {
                $description = $tagsInput[$name];
                return Tag::firstOrCreate(['name' => $name], ['description' => $description])->id;
            }, $tagNames);

            $product->tags()->sync($tags);
            // $product->tags()->attach($tags);
        }

        if ($categoryNames && !empty($categoryNames)) {

            $categories = array_map(function ($name) use ($categoriesInput) {
                $description = $categoriesInput[$name];
                return Category::firstOrCreate(['name' => $name], ['description' => $description]);
            }, $categoryNames);

            $product->categories()->saveMany($categories);
            // $product->categories()->attach($categories);
        }

        // This is from another project, remove if gives errors
        // We already attached the tags
        // $product->tags()->sync($Request->tags, false);

        foreach ($request->images as $image) {
            $filepath = $image->store('/products');
            $productImage = ProductImage::create([
                'product_id' => $product->id,
                'file_name' => explode('/', $filepath)[1],
                'file_path' => './storage/' . $filepath,
                'original_name' => $image->getClientOriginalName()
            ]);
        }

        return $this->sendSuccessResponse(ProductDetailsDto::build($product), 'Created successfully');
    }

}
