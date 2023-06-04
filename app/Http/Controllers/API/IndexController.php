<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MainItemResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function main()
    {
       $data = Item::query()
           ->where('parent_id', 0)
           ->orderByDesc('id')
           ->limit(1)
           ->get()
           ->values();

       if ($data) {
           return MainItemResource::collection($data)->resolve();
       }
       return response()->json('Not Found Main', 429);
    }
    public function item($slug)
    {
       $data = Item::query()
           ->where('slug', $slug)
           ->get()
           ->values();

       if ($data) {
           return MainItemResource::collection($data)->resolve();
       }
       return response()->json('Not Found Main', 429);
    }

    public function set(Request $request): array
    {
        $model = new Item();
        $model->main = $request->main;
        $model->content = $request->text;
        $model->spouse = $request->spouse;
        $model->parent_id = $request->parent_id;
        if ($request->image) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('items'), $imageName);
            $model->image = '/items/'.$imageName;
        }
        $model->save();
        $data = Item::query()
            ->where('id', $request->parent_id)
            ->get()
            ->values();
        return MainItemResource::collection($data)->resolve();
    }

    public function update(Request $request): array
    {
        $model = Item::find($request->id);
        $model->main = $request->main;
        $model->content = $request->text;
        $model->spouse = $request->spouse;
        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('items'), $imageName);
            $model->image = '/items/'.$imageName;
        } else {
            $model->image = $request->image;
        }
        $model->save();
        $data = Item::query()
            ->where('id', $request->parentId)
            ->get()
            ->values();
        return MainItemResource::collection($data)->resolve();
    }

    public function deleteImage($id)
    {
        $item = Item::find($id);
//        unlink(mb_substr($item->image, 1));
        Storage::delete($item->image);
        $item->image = NULL;
        $item->save();

        $data = Item::query()
            ->where('id', $item->parent_id)
            ->get()
            ->values();

        if ($data) {
            return MainItemResource::collection($data)->resolve();
        }
        return response()->json('Not Found Main', 429);
    }
}
