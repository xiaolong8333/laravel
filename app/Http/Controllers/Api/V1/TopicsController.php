<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Controllers\Api\Controller;
use App\Http\Queries\TopicQuery;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TopicsController extends Controller
{
    public function index(Request $request, TopicQuery $query)
    {
        $topics = $query->paginate();

        return TopicResource::collection($topics);

    }
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->all());

        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy',$topic);

        $topic->delete();

        return response(null, 204);
    }

    public function show($topicId, TopicQuery $query)
    {
        $topic = $query->findOrFail($topicId);
        return new TopicResource($topic);
    }
/*    public function show($topicId)
    {
        $topic = QueryBuilder::for(Topic::class)
            ->allowedIncludes('user','category')
            ->findOrFail($topicId);
        return new TopicResource($topic);
    }*/
}
