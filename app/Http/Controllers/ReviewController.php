<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Save the review
     *
     * @param int $product_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function index(int $product_id, Request $request): RedirectResponse
    {
        $product = Product::query()->find($product_id);

        if(!$product){
            abort(500);
        }

        UserReview::createReview($request, $product_id);

        $grade = $this->processRating($product_id);

        $product->updateRating($grade);

        return redirect()->back();
    }

    /**
     * Process a stars of product
     *
     * @param int $product_id
     * @return float
     */
    private function processRating(int $product_id): float
    {
        $reviews = UserReview::getProductReviews($product_id);

        $rating = 0;

        $totalRating = 5.0;

        if($reviews){

            foreach ($reviews as $review) {
                $rating += $review->grade;
            }

            $totalRating = round($rating / count($reviews), 1);
        }

        return $totalRating;
    }
}
