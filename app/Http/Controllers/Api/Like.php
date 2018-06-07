<?php

namespace App\Http\Controllers\Api;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Psy\Exception\FatalErrorException;

class Like extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws FatalErrorException
     */
    public function __invoke(Request $request)
    {
        $type = $this->defineRelation($request->get('type'));
        $result = auth()->user()->toggleLike($request->get('id'), $type);

        return response()->json([
            'status' => empty($result['attached']) ? 'unlike' : 'like',
        ]);
    }

    /**
     * @param $type
     * @return string
     * @throws FatalErrorException
     */
    public function defineRelation($type)
    {
        switch ($type) {
            case 'post':
                return Post::class;
            case 'comment':
                return Comment::class;
            default:
                throw new FatalErrorException('The type does not defined.');
        }
    }
}
