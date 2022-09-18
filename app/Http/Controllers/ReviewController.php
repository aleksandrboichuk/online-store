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
     * Айди продукта
     *
     * @var int $product_id
     */
    private int $product_id;

    /**
     * Сохранение оценки
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

        $this->product_id = $product->id;

        UserReview::createReview($request, $product->id);

        $grade = $this->processRating();

        $product->updateRating($grade);

        return redirect()->back();
    }

    /**
     * Вычисление оценки продукта
     *
     * @return float
     */
    private function processRating(): float
    {
        $reviews = UserReview::getProductReviews($this->product_id);

        $rating = 0;
        $totalRating = 5.0;
        if(isset($reviews) && !empty($reviews)){
            foreach ($reviews as $review) {
                $rating += $review->grade;
            }
            $totalRating = round($rating / count($reviews), 1);
        }

        return $totalRating;
    }
}
