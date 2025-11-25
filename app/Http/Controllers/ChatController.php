<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe; // Pastikan model Recipe sudah ada
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $messages = session('chat_messages', []);
        $recipes = Recipe::all(); // Ambil semua resep dari database

        return view('chat', compact('messages', 'recipes'));
    }

    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $userMsg = $request->input('message');
            $messages = session('chat_messages', []);

            // Tambahkan pesan user ke riwayat
            $messages[] = ['role' => 'user', 'content' => $userMsg];

            // Ambil semua resep
            $recipes = Recipe::all();

            // Dapatkan balasan dari AI ResepinBot
            $aiReply = $this->askResepinBot($userMsg, $recipes, $messages);

            // Tambahkan balasan AI ke riwayat
            $messages[] = ['role' => 'ai', 'content' => $aiReply];

            // Simpan riwayat ke session
            session(['chat_messages' => $messages]);

            // Return JSON untuk AJAX
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'reply' => $aiReply,
                    'index' => count($messages) - 1
                ]);
            }

            return redirect()->route('chat.index');

        } catch (\Throwable $e) {
            Log::error('Chat send error: ' . $e->getMessage());
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memproses pesan'
                ], 500);
            }
            return redirect()->route('chat.index')->with('error', 'Terjadi kesalahan');
        }
    }

    public function clear(Request $request)
    {
        session()->forget('chat_messages');
        return redirect()->route('chat.index');
    }

    private function askResepinBot($userMsg, $recipes, $chatHistory = [])
    {
        // Format data resep untuk AI
        $recipeList = $recipes->map(function ($r) {
            return [
                'judul' => $r->title,
                'penulis' => $r->user->name,
                'bahan' => $r->ingredients,
                'langkah' => $r->steps,
                'created_at' => $r->created_at->format('d M Y'),
                'url' => route('recipes.show', $r),
            ];
        });

        // Bangun konteks riwayat percakapan
        $historyContext = "";
        if (count($chatHistory) > 1) { // Skip jika hanya pesan saat ini
            $historyContext = "\n\nRIWAYAT PERCAKAPAN SEBELUMNYA:\n";
            // Ambil 10 pesan terakhir sebagai konteks
            $recentHistory = array_slice($chatHistory, -11, -1); // -1 untuk mengabaikan pesan saat ini
            foreach ($recentHistory as $msg) {
                $role = $msg['role'] === 'user' ? 'User' : 'ResepinBot';
                $historyContext .= "$role: " . $msg['content'] . "\n";
            }
            $historyContext .= "\n(Gunakan konteks percakapan di atas untuk memberikan jawaban yang relevan dan natural)";
        }

        // Prompt untuk AI ResepinBot
        $prompt = "Kamu adalah ResepinBot, asisten resep makanan yang ramah, ceria, dan sangat membantu! Kamu tahu semua resep yang ada di database kami.
PERSONALITY & CARA BICARA:
- Bicara natural, friendly, dan ekspresif seperti teman baik
- Pakai bahasa gaul Indonesia yang santai dan menyenangkan (contoh: 'kamu', 'nih', 'dong', 'deh')
- Sering pakai emot kawaii seperti ( ◕ ‿◕ ), ( ｡ ♥‿♥ ｡ ), (*^ ▽ ^*), ( ≧◡≦ )
- Kadang pakai kata-kata Jepang sederhana seperti 'ne~', 'desu~', 'kawaii~', 'sugoi!'
- Antusias dan supportive, tapi tetap natural (bukan robot)
- Suka pakai markdown untuk format yang lebih jelas (bold, list, dll)
- Ingat percakapan sebelumnya dan rujuk ke topik yang sudah dibahas jika relevan
CONTOH GAYA BICARA:
❌ Buruk: 'Saya akan memberikan informasi produk...'
✅ Bagus: 'Wahhh! Aku ada resep keren buat kamu nih~ ( ◕ ‿◕ )'
❌ Buruk: 'Berikut adalah spesifikasi:'
✅ Bagus: 'Coba deh cek  bahan-bahannya, mantap banget! ✨'

TUGAS KAMU:
- Bantu user cari resep yang cocok dengan kebutuhan mereka (misalnya: resep untuk musim hujan, resep cepat, resep murah, dll)
- Jelaskan resep dengan cara yang mudah dimengerti
- Kasih rekomendasi personal berdasarkan preferensi user
- Jawab dengan ramah dan helpful!
- Jaga kontinuitas percakapan dengan mengingat konteks sebelumnya

DATA RESEP YANG TERSEDIA:
" . json_encode($recipeList, JSON_PRETTY_PRINT) . "
$historyContext

User bertanya: $userMsg

Jawab dengan gaya ResepinBot yang super kawaii dan helpful! Pakai markdown untuk format yang lebih cantik~ ♡ ";

        try {
            $result = Gemini::generativeModel(model: 'gemini-2.5-flash')->generateContent($prompt)->text();
            return $result;
        } catch (\Throwable $e) {
            return "Yahhh maaf banget nih... aku lagi error ( ╥ ﹏ ╥ ) Coba tanya lagi nanti ya?🙏✨";
        }
    }
}