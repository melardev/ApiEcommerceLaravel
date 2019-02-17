<?php

namespace App\Http\Controllers;


use App\Dtos\response\Address\AddressListDto;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends BaseController
{

    public function __construct()
    {
        $this->middleware('jwt.verify');
    }

    public function getMyAddresses(Request $request)
    {
        $page = (int)$request->get('page', 1);
        $page_size = (int)$request->get('page_size', 10);
        $user = JWTAuth::parseToken()->authenticate();

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        $products = Address::where('user_id', $user->id)->orderBy('created_at', 'desc')
            ->paginate($page_size);

        return $this->sendSuccess(AddressListDto::build($products, $request->path(), false));
    }
}