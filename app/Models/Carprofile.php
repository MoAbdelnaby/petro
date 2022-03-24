<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carprofile extends Model
{

    protected $guarded = [];

    protected $appends = ['char_ar', 'number_ar', 'char_en', 'number_en','path_screenshot'];

    /**
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function failMessage() {
        return $this->hasOne(FailedMessage::class);
    }
    public function invoiceStatus() {
        return $this->hasOne(MessageLog::class)->where('type','invoice');
    }

    function getPathScreenshotAttribute()
    {
        if ($this->disk == 'azure') {
            return config('app.azure_storage').config('app.azure_container')."/storage".$this->screenshot;

        } else {
            return 'http://104.211.179.36/'.'/storage'. $this->screenshot;
//            return url('/storage'. $this->screenshot);
        }
    }

    function getPathAreaScreenshotAttribute()
    {
        $path = "/places/". $this->branch_id."/".$this->created_at->format('Y')."/".$this->created_at->format('M') ."/". $this->created_at->format('d')."/";
        if ($this->disk == 'azure') {
            return config('app.azure_storage').config('app.azure_container')."/storage".$path.str_replace('/screenshot/','',$this->area_screenshot);

        } else {
            return 'http://104.211.179.36/'.'/storage'. $this->area_screenshot;
//            return url('/storage'. $this->screenshot);
        }
    }



    public function getCharArAttribute()
    {
        $plate_ar = convert2EnglishNum($this->plate_ar);
        $ar_char = trim(preg_replace("/[0-9,]/", "", $plate_ar));

        return $ar_char;
    }

    public function getCharEnAttribute()
    {
        $en_char = trim(preg_replace("/[0-9,]/", "", $this->plate_en));

        return $en_char;
    }

    public function getNumberArAttribute()
    {
        $en_number = trim(preg_replace("/[aA-zZ,]/", "", $this->plate_en));
        $ar_number = utf8_strrev(convert2ArabicNum($en_number));

        return $ar_number;
    }

    public function getNumberEnAttribute()
    {
        $en_number = trim(preg_replace("/[aA-zZ,]/", "", $this->plate_en));

        return $en_number;
    }
}
