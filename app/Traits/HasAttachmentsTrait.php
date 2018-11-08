<?php

namespace App\Traits;

use App\Attachment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAttachmentsTrait {

    public function uploadAttachments($files)
    {
        if(is_null($files)) return;

        foreach ($files as $file) {
            /** @var UploadedFile $file */
            $this->uploadAttachment($file);
        }
    }

    public function uploadAttachment(UploadedFile $file)
    {
        $path = $file->store($this->folderToUpload ?? "", 'public');
        $this->attachments()->create([
            'name' => $file->getClientOriginalName(),
            'type' => $file->getClientOriginalExtension(),
            'path' => $path,
            'url'  => Storage::url($path, 'public'),
        ]);
    }

    /**
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'author_id');
    }

    public function getAttachmentAttribute() {
        return $this->attachments()->first();
    }
}