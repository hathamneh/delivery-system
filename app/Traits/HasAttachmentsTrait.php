<?php

namespace App\Traits;

use App\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAttachmentsTrait {

    public function uploadAttachments($files)
    {
        if(is_null($files)) return;

        foreach ($files as $file) {
            /** @var UploadedFile $file */
            $path = $file->store($this->folderToUpload ?? "", 'public');
            $this->attachments()->create([
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientOriginalExtension(),
                'path' => $path,
                'url'  => Storage::url($path, 'public'),
            ]);
        }
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'author_id');
    }
}