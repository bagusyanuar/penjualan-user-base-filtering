<?php


namespace App\Http\Controllers\Customer;


use App\Helper\CustomController;
use App\Models\Kategori;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;

class ProductController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            try {
                $q = $this->request->query->get('param');
                $c = $this->request->query->get('category');
                $query = Product::with([]);
                if ($c !== 'all' && $c !== '') {
                    $query->where('kategori_id', '=', $c);
                }
                $products = $query->where('nama', 'LIKE', '%' . $q . '%')
                    ->get();
                return $this->jsonSuccessResponse('success', $products);
            } catch (\Exception $e) {
                return $this->jsonErrorResponse('internal server error...');
            }
        }
        $categories = Kategori::all();
        return view('customer.product.index')->with([
            'categories' => $categories
        ]);
    }

    public function detail($id)
    {
        $product = Product::with([])
            ->where('id', '=', $id)
            ->firstOrFail();

        $customers = User::with(['customer'])
            ->where('role', '=', 'customer')
            ->get()->pluck('id');

        $products = Product::with(['rating'])
            ->get();

        $mapRate = [];
        foreach ($customers as $customer) {
            $productMap = [];

            foreach ($products as $p) {
                $productID = $p->id;
                $rateValue = 0;
                /** @var Collection $productRates */
                $productRates = $p->rating;
                $productRatesPerUser = $productRates->where('user_id', '=', $customer)->all();
                $totalRatesPerUser = $productRates->where('user_id', '=', $customer)->sum('rating');
                if (count($productRatesPerUser) > 0) {
                    $length = count($productRates);
                    $avg = round(($totalRatesPerUser / $length), 1, PHP_ROUND_HALF_UP);
                    $rateValue = $avg;
                }
                $productMap['product_'.$productID] = $rateValue;
            }
            $mapRate['user_'.$customer] = $productMap;
        }
        $sampleData = [
            'user_1' => [
                'product_1' => 3,
                'product_2' => 1,
                'product_3' => 2,
                'product_4' => 4,
            ],
            'user_2' => [
                'product_1' => 2,
                'product_2' => 5,
                'product_3' => 1,
                'product_4' => 4,
            ],
            'user_3' => [
                'product_1' => 3,
                'product_2' => 3,
                'product_3' => 3,
                'product_4' => 4,
            ],
            'user_4' => [
                'product_1' => 5,
                'product_2' => 5,
                'product_3' => 0,
                'product_4' => 5,
            ],
        ];
//        $sampleData = array(
//            'user_1' => array('item_1' => 1, 'item_2' => 0, 'item_3' => 0, 'item_4' => 0),
//            'user_2' => array('item_1' => 2, 'item_2' => 3, 'item_3' => 4, 'item_4' => 0),
//            'user_3' => array('item_1' => 5, 'item_2' => 2, 'item_3' => 1, 'item_4' => 0)
//        );
        $res = $this->get_recommendations($sampleData, 'user_4');
        return $this->jsonSuccessResponse('success', $res);
        $recommendProducts = Product::with([])
            ->where('id', '!=', $id)
            ->take(5)
            ->get();

        return view('customer.product.detail')->with([
            'product' => $product,
            'recommends' => $recommendProducts
        ]);
    }


    private function pearson_correlation($user1_ratings, $user2_ratings) {
        $sum1 = $sum2 = $sum1Sq = $sum2Sq = $pSum = 0;
        $n = count($user1_ratings);

        foreach ($user1_ratings as $key => $rating1) {
            $rating2 = $user2_ratings[$key];
            $sum1 += $rating1;
            $sum2 += $rating2;
            $sum1Sq += pow($rating1, 2);
            $sum2Sq += pow($rating2, 2);
            $pSum += $rating1 * $rating2;
        }

        // Hitung korelasi Pearson
        $num = $pSum - ($sum1 * $sum2 / $n);
        $den = sqrt(($sum1Sq - pow($sum1, 2) / $n) * ($sum2Sq - pow($sum2, 2) / $n));
        if ($den == 0) return 0; // Handle jika pembaginya adalah nol
        return $num / $den;
    }

    private function cosine_similarity($user1_ratings, $user2_ratings) {
        $dot_product = 0;
        $magnitude1 = 0;
        $magnitude2 = 0;

        foreach ($user1_ratings as $item => $rating1) {
            if (isset($user2_ratings[$item])) {
                $rating2 = $user2_ratings[$item];
                if ($rating1 != 0 || $rating2 != 0) {
                    $dot_product += $rating1 * $rating2;
                    $magnitude1 += pow($rating1, 2);
                    $magnitude2 += pow($rating2, 2);
                }
            }
        }

        // Hitung korelasi kosinus
        if ($magnitude1 == 0 || $magnitude2 == 0) return 0; // Handle jika pembaginya adalah nol
        return $dot_product / (sqrt($magnitude1) * sqrt($magnitude2));
    }

    private function get_recommendations($data, $user) {
        $totalScores = array();
        $simSums = array();

        $tmpCorrelation = [];
        foreach ($data as $otherUser => $ratings) {
            if ($otherUser != $user) {
                $similarity = $this->pearson_correlation($data[$user], $ratings);
                $t = [
                    'user' => $otherUser,
                    'similarity' => $similarity
                ];
                array_push($tmpCorrelation, $t);
                // Jika similarity positif
                if ($similarity > 0) {
                    foreach ($ratings as $item => $rating) {
                        // Hitung weighted sum of ratings
                        if (!isset($totalScores[$item])) {
                            $totalScores[$item] = 0;
                        }
                        $totalScores[$item] += $rating * $similarity;

                        // Jumlah similarity
                        if (!isset($simSums[$item])) {
                            $simSums[$item] = 0;
                        }
                        $simSums[$item] += $similarity;
                    }
                }
            }
        }

        // Normalisasi ratings
        $rankings = array();
        foreach ($totalScores as $item => $score) {
            $rankings[$item] = $score / $simSums[$item];
        }

        // Urutkan rekomendasi dari tertinggi ke terendah
        arsort($rankings);
        return [
            'rank' => $rankings,
            'correlation' => $tmpCorrelation
        ];
    }
}
