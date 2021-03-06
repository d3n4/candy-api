<?php

namespace GetCandy\Api\Http\Controllers\Discounts;

use GetCandy\Api\Http\Controllers\BaseController;
use GetCandy\Api\Http\Requests\Discounts\UpdateRequest;
use GetCandy\Api\Http\Resources\Discounts\DiscountCollection;
use GetCandy\Api\Http\Resources\Discounts\DiscountResource;
use GetCandy\Api\Http\Transformers\Fractal\Discounts\DiscountTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DiscountController extends BaseController
{
    public function index(Request $request)
    {
        $paginator = app('api')->discounts()->getPaginatedData(
            $request->per_page,
            $request->current_page,
            $request->includes ? explode(',', $request->includes) : null
        );

        return new DiscountCollection($paginator);
    }

    public function store(Request $request)
    {
        // TODO: Add validation
        $discount = app('api')->discounts()->create($request->all());

        return new DiscountResource($discount);
    }

    public function update($id, UpdateRequest $request)
    {
        $discount = app('api')->discounts()->update($id, $request->all());

        return $this->respondWithItem($discount, new DiscountTransformer);
    }

    /**
     * Shows the discount resource.
     *
     * @param string $id
     *
     * @return void
     */
    public function show($id, Request $request)
    {
        try {
            $discount = app('api')->discounts()->getByHashedId(
                $id,
                $request->includes ? explode(',', $request->includes) : null
            );
        } catch (ModelNotFoundException $e) {
            return $this->errorNotFound();
        }

        return new DiscountResource($discount);

        return $this->respondWithItem($discount, new DiscountTransformer);
    }
}
