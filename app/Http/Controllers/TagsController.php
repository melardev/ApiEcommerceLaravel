<?php


namespace App\Http\Controllers;


use App\Dtos\response\Tag\Partial\BasicTagDto;
use App\Dtos\response\Tag\TagListDto;
use App\Models\Tag;
use App\Models\TagImage;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TagsController extends BaseController
{
    public function index(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $tags = Tag::orderBy('created_at', 'desc')
            ->paginate($page_size);

        return $this->sendSuccess(TagListDto::build($tags, $request->path(), true));

    }


    public function store(Request $request)
    {
        $imagesCount = count($request->only('images')['images']);
        $imagesCount = min(0, $imagesCount - 1);
        $rules = ['name' => 'required|min:2|max:500',
            'description' => 'required|min:2|max:500',];

        /*
        foreach (range(0, min(6, $imagesCount)) as $index) {
            $rules['images.' . $index] = 'image|mimes:png|jpg|jpeg|size:3000';
        }
        */

        // validation
        $this->validate($request, $rules);

        $tag = Tag::create($request->only('name', 'description'));
        if ($request->images) {
            foreach ($request->images as $image) {
                $filepath = $image->store('/tags');
                $tagImage = TagImage::create([
                    'tag_id' => $tag->id,
                    'file_name' => explode('/', $filepath)[1],
                    'file_path' => '/storage/' . $filepath,
                    'original_name' => $image->getClientOriginalName()
                ]);
            }
        }

        // $tag->push(); // for some reason it does not set tag_id on TagImage to newly created tag ...
        return $this->sendSuccess(BasicTagDto::build($tag, true));
    }

}