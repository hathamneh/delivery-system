<?php

namespace App\Traits;

use App\Attachment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Trait HasAttachmentsTrait
 * @package App\Traits
 * @property Collection attachments
 * @property Attachment attachment
 */
trait HasAttachmentsTrait
{

    public function uploadAttachments($files)
    {
        if (is_null($files)) return;

        foreach ($files as $file) {
            /** @var UploadedFile $file */
            $this->uploadAttachment($file);
        }
    }

    public function uploadAttachment(UploadedFile $file)
    {
        $path = $file->store($this->folderToUpload ?? "", 'public');
        $this->attachments()->create([
            'name'        => $file->getClientOriginalName(),
            'type'        => $file->getClientOriginalExtension(),
            'path'        => Storage::disk('public')->path($path),
            'url'         => Storage::url($path, 'public'),
            'author_type' => self::class
        ]);
    }

    public function deleteAllAttachments()
    {
        foreach ($this->attachments as $attachment) {
            /** @var Attachment $attachment */
            $attachment->delete();
        }
    }

    public function replaceAllAttachmentWith(UploadedFile $file)
    {
        $this->deleteAllAttachments();
        $this->uploadAttachment($file);
    }

    /**
     * @return HasMany
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'author_id')->where('author_type', self::class);
    }

    public function getAttachmentAttribute()
    {
        return $this->attachments()->first();
    }
}