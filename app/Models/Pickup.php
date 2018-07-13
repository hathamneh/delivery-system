<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * @property Carbon available_time_start
 * @property Carbon available_time_end
 * @property string available_time
 * @property integer expected_packages_number
 * @property double pickup_fees
 * @property string pickup_from
 * @property string pickup_address_text
 * @property string pickup_address_maps
 * @property string notes_internal
 * @property string notes_external
 * @property string status
 * @property string phone_number
 */
class Pickup extends Model
{
    use SoftDeletes, RevisionableTrait;

    protected $revisionEnabled = true;
    protected $revisionCleanup = true;
    protected $historyLimit = 75; // Stop tracking revisions after 75 changes have been made.


    protected $dates = ['deleted_at', 'available_time_start', 'available_time_end'];

    protected $fillable = [
        'status',
    ];

    public function shipments()
    {
        return $this->belongsToMany(Shipment::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_account_number', 'account_number');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function setAvailableTimeAttribute($value)
    {
        $dates = explode(' - ', $value);
        $this->available_time_start = Carbon::createFromTimeString($dates[0]);
        $this->available_time_end = Carbon::createFromTimeString($dates[1]);
    }

    public function getAvailableTimeAttribute()
    {
        return $this->available_time_start->toDateString() . " - " . $this->available_time_end->toDateString();
    }

    public function statusContext($context = null)
    {

        switch ($this->status) {
            case "completed":
                switch($context) {
                    case 'card': return "border-success";
                    case 'text': return '<small class="text-success"><i class="fa-check-circle2"></i> <span>'.trans('pickup.completed').'</span></small>';
                    default: return "success";
                }
            case "declined":
                switch($context) {
                    case 'card': return "border-danger";
                    case 'text': return '<small class="text-danger"><i class="fa-minus-circle"></i> <span>'.trans('pickup.declined').'</span></small>';
                    default: return "danger";
                }
            default:
                switch($context) {
                    case 'card': return "";
                    case 'text': return '<small><i class="fa-clock"></i> <span>'.trans('pickup.pending').'</span></small>';
                    default: return "";
                }
        }
    }
}
