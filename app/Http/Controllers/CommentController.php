<?php


namespace App\Http\Controllers;


use App\Dtos\Response\Comment\CommentDetailsDto;
use App\Dtos\Response\Comment\CommentListDto;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class CommentController extends BaseController
{

    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => 'index']);
    }

    public function index(Request $request, $product_slug)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);
        //Article::resolveConnection()->getPaginator()->setCurrentPage($page - 1);
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $comments = Comment::join('products', 'products.id', '=', 'comments.product_id')
            ->where('products.slug', '=', $product_slug)->paginate($page_size);
        // $comments = $products->comments()->get();
        return $this->sendSuccess(CommentListDto::build($comments, $request->path(), false, true));

        //return view('comments.index', ['comments' => Comment::where('article_id', $product_id)]);
    }

    public function store(Request $request, Product $product)
    {
        // validation
        $this->validate($request, array(
            'content' => 'required|min:2|max:500'
        ));


        /**
         * Authorization without required Models
         */
        // If fails will throuw Illuminate\Auth\Access\AuthorizationException 403
        $this->authorize('create', Comment::class);

        $comment = Auth::user()->comments()->create([
            'product_id' => $product->id,
            'content' => $request->get('content')
        ]);

        return $this->sendSuccessResponse(CommentDetailsDto::build($comment), 'Comment created successfully');
    }


    public function update(// UpdateCommentRequest $request,
        Request $request, Comment $comment)
    {
        $this->validate($request, array(
            'content' => 'required|min:2|max:500'
        ));

        //$comment = Comment::find($id);
        $comment->content = $request->get('content');
        $comment->save();

        return $this->sendSuccessResponse(CommentDetailsDto::build($comment), 'Comment created successfully');
    }

    public function destroy(Product $product, Comment $comment)
    {

        // Use Gate
        /*  if (!Gate::allows('comments.delete', $comment))
              return redirect()->route();

          // there is allows() instead of denies
          if (Gate::forUser(Auth::user())->denies('comments.delete', $comment))
              return redirect()->route(); // not allowed

  */
        // Using Policies, user->cant() and can(), if the given
        // operation is not implemented, laravel will try to execute
        // the equivalente Gate
        if (Auth::user()->cant('delete', $comment))
            return $this->sendError('Access denied');

        // Authorization through Controller Helpers
        $this->authorize('delete', $comment);

        $comment->delete();

        // Session::flash('success', 'Deleted Comment');
        // return redirect()->route('posts.show', $post_id);

        return $this->sendSuccessResponse(null, 'Comment deleted successfully');
    }


    public function show(Product $product)
    {

    }
    /*
        public function update(UpdateArticleRequest $request, Article $product) {
            if ($request->has('article')) {
                $product->update($request->get('article'));
            }
        }

        public function destroy(DeleteCommentRequest $request, Article $product, Comment $comment) {
            $comment->delete();
            return $this->respondSuccess();
        }*/
}