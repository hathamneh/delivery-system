<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function destroy(Attachment $attachment)
    {
        $data = [];
        try {
            $attachment->delete();
            $data['alert'] = (object)[
                'type' => 'success',
                'msg'  => trans('common.file_deleted')
            ];
        } catch (\Exception $ex) {
            $data['alert'] = (object)[
                'type' => 'danger',
                'msg'  => trans('common.file_not_deleted')
            ];
        }
        return back()->with($data);
    }
}
