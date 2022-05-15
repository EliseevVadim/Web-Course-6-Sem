<?php

namespace App\Jobs;

use App\Classes\FileOriginalityChecker;
use App\Models\UploadedDocument;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use VK\Client\VKApiClient;

class ProcessFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $checkedAttachment;
    private $chatId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($checkedAttachment, $chatId)
    {
        $this->checkedAttachment = $checkedAttachment;
        $this->chatId = $chatId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $fullName = uniqid() . '_' . str_replace(' ', '_', $this->checkedAttachment->title);
            Log::critical($fullName);
            $fileName = $fullName;
            Storage::disk('uploads')->put($fullName, file_get_contents($this->checkedAttachment->url), 'public');
            $checker = new FileOriginalityChecker(3);
            $response = $checker->checkOriginality($fullName);
            $similarity = $response['percents'];
            $closestFileName = $response['name'];
            UploadedDocument::create([
                'document_title' => $this->checkedAttachment->title,
                'document_size' => $this->checkedAttachment->size,
                'document_path' => $fileName,
                'highest_similarity' => $similarity,
                'uploader_id' => User::select('id')
                    ->where('vk_id', $this->chatId)
                    ->get()
                    ->first()
                    ->id,
                'most_similar_document_id' => is_null($response['name']) ? null : UploadedDocument::select('id')
                    ->where('document_path', $closestFileName)
                    ->get()
                    ->first()
                    ->id
            ]);
            $originality = 100 - $similarity;
            if ($similarity > 0) {
                $this->sendMessage($this->chatId, "Результат проверки:
                    Ваш документ оригинален на $originality%.
                    Наибольшее совпадение с документами, имеющимися в системе: $similarity%.
                    Наибольшее совпадение замечено с документом: $closestFileName");
                return;
            }
            $this->sendMessage($this->chatId, "Результат проверки:
                Ваш документ оригинален на $originality%.
                Наибольшее совпадение с документами, имеющимися в системе: $similarity%.");
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
        }
    }

    private function sendMessage($chatId, $message)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),
        ]);
    }
}
