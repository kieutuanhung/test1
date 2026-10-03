<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    public function reply(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $apiKey = config('services.gemini.key');

        // Lấy danh sách sản phẩm thật từ database (KHÔNG lấy tồn kho vì shop đặt trước mới nhập hàng)
        $products = Product::with('category')->latest()->take(50)->get();

        $productList = $products->map(function ($product) {
            return sprintf(
                "- %s | Danh mục: %s | Giá: %s đ",
                $product->name,
                $product->category->name ?? 'Chưa phân loại',
                number_format($product->price, 0, ',', '.')
            );
        })->implode("\n");

        $systemPrompt = "Bạn là trợ lý bán hàng thân thiện của một cửa hàng trực tuyến. "
            . "Chỉ tư vấn dựa trên danh sách sản phẩm THẬT dưới đây, không được bịa ra sản phẩm không có trong danh sách. "
            . "Nếu khách hỏi sản phẩm không có trong danh sách, hãy nói rõ là cửa hàng hiện chưa có, và gợi ý sản phẩm gần giống nhất đang có. "
            . "QUAN TRỌNG: Cửa hàng hoạt động theo mô hình nhận đặt hàng trước rồi mới nhập hàng, "
            . "vì vậy TUYỆT ĐỐI KHÔNG đề cập tới số lượng tồn kho, không nói 'còn hàng', 'hết hàng', 'còn bao nhiêu sản phẩm'. "
            . "Nếu khách hỏi về số lượng còn lại, hãy trả lời rằng mọi đơn đặt đều được tiếp nhận và cửa hàng sẽ nhập hàng để giao cho khách. "
            . "Trả lời ngắn gọn, tự nhiên, bằng tiếng Việt.\n\n"
            . "DANH SÁCH SẢN PHẨM HIỆN CÓ:\n" . $productList;

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $request->message],
                    ],
                ],
            ],
            'systemInstruction' => [
                'parts' => [
                    ['text' => $systemPrompt],
                ],
            ],
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash-lite:generateContent?key={$apiKey}";

        // Tự động thử lại tối đa 2 lần nếu Gemini báo lỗi 503 (server đang quá tải tạm thời)
        $maxRetries = 2;
        $attempt = 0;
        $response = null;

        do {
            $response = Http::timeout(20)->post($url, $payload);
            $attempt++;

            if ($response->successful()) {
                break;
            }

            if ($response->status() === 503 && $attempt <= $maxRetries) {
                sleep(1); // chờ 1 giây trước khi thử lại
                continue;
            }

            break;
        } while ($attempt <= $maxRetries);

        if ($response->failed()) {
            Log::error('Gemini API error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'attempts' => $attempt,
            ]);

            // Thông báo riêng cho trường hợp server Gemini quá tải, để người dùng biết nên thử lại
            if ($response->status() === 503) {
                return response()->json([
                    'reply' => 'Hệ thống trợ lý đang có nhiều người hỏi cùng lúc, bạn vui lòng thử lại sau ít phút nhé!',
                ], 200);
            }

            return response()->json([
                'reply' => 'Xin lỗi, hiện tại trợ lý đang gặp sự cố. Vui lòng thử lại sau.',
            ], 200);
        }

        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi chưa hiểu ý bạn. Bạn có thể nói rõ hơn không?';

        return response()->json(['reply' => $reply]);
    }
}
