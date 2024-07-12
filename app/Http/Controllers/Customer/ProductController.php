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
                    ->get()->append(['avg_rating', 'terjual']);
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
            ->firstOrFail()->append(['avg_rating', 'terjual']);

        if (auth()->check()) {
            $userID = auth()->id();
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
                    $productMap['product_' . $productID] = $rateValue;
                }
                $mapRate['user_' . $customer] = $productMap;
            }



            $res = $this->get_recommendations($mapRate, 'user_'.$userID );
            $productRank = count($res['rank']);

            if ($productRank > 0) {
                $resultRanks = $res['rank'];
                $keyRanks = [];
                if ($productRank > 5) {
                    $newResultRanks = array_slice($resultRanks, 0, 5, true);
                    foreach ($newResultRanks as $kRR => $resultRank) {
                        array_push($keyRanks, $kRR);
                    }
                } else {
                    foreach ($resultRanks as $kRR => $resultRank) {
                        array_push($keyRanks, $kRR);
                    }
                }

                $pIDS = [];
                foreach ($keyRanks as $keyRank) {
                    $pID = explode('_', $keyRank);
                    array_push($pIDS, $pID[1]);
                }
                $recommendProducts = Product::with([])
                    ->whereIn('id', $pIDS)
                    ->get()->append(['avg_rating', 'terjual']);
//            $recommendProducts = $pIDS;
            } else {
                $recommendProducts = Product::with([])
                    ->where('id', '!=', $id)
                    ->orderBy('created_at', 'DESC')
                    ->take(5)
                    ->get()->append(['avg_rating', 'terjual']);
            }
        } else {
            $recommendProducts = Product::with([])
                ->where('id', '!=', $id)
                ->orderBy('created_at', 'DESC')
                ->take(5)
                ->get()->append(['avg_rating', 'terjual']);
        }

//        return $this->jsonSuccessResponse('success', $recommendProducts);


        return view('customer.product.detail')->with([
            'product' => $product,
            'recommends' => $recommendProducts
        ]);
    }


    private function pearson_correlation($user1_ratings, $user2_ratings)
    {
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

    private function cosine_similarity($user1_ratings, $user2_ratings)
    {
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

    private function get_recommendations($data, $user)
    {
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
