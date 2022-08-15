<?php
namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait TranslationTrait{

    public function translations($translations)
    {
        //In our database some translation table's column name with local and updated column with locale that's why we have to check both name. We will update later.

        $locale = Session::get('currentLocal');
        $translation_value = null;

        if ($translations) {
            if (isset($translations[0])) {
                if (isset($translations[0]->local)) { //Have to remove this line later
                    if ($translations[0]->local == $locale) { //local
                        $translation_value = $translations[0];
                    }
                }else {
                    if ($translations[0]->locale == $locale) { //locale
                        $translation_value = $translations[0];
                    }
                }

            }

            if (!$translation_value) {
                if (isset($translations[1])) {
                    if (isset($translations[1]->local)) { //Have to remove this line later
                        if ($translations[1]->local == $locale) { //local
                            $translation_value = $translations[1];
                        }
                    }else {
                        if ($translations[1]->locale == $locale) { //locale
                            $translation_value = $translations[1];
                        }
                    }

                }
            }

            if (!$translation_value) {
                foreach ($translations as $value) {
                    if (isset($value->local)) { //Have to remove this line later
                        if ($value->local=='en') { //local
                            $translation_value =  $value;
                            break;
                        }
                    }else {
                        if ($value->locale=='en') { //locale
                            $translation_value =  $value;
                            break;
                        }
                    }

                }
            }
        }

        return $translation_value;
    }
}

?>
