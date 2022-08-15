<?php
namespace App\Traits;

use App\Models\SettingGeneral;
use Illuminate\Support\Facades\Session;

trait FormatNumberTrait{

    public function formatNumber($number) {

        $settingGeneral = SettingGeneral::select('number_format_type')->latest()->first();
        if ($settingGeneral) {
            return number_format((float)$number, $settingGeneral->number_format_type, '.', '');
        }else {
            return;
        }

    }

    public function totalFormatNumber() {

        $settingGeneral = SettingGeneral::select('number_format_type')->latest()->first();
        if ($settingGeneral) {
            return $settingGeneral->number_format_type;
        }else {
            return;
        }

    }
}

?>
