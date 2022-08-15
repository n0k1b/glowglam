@php

    $categories =  App\Models\Category::with(['catTranslation','parentCategory','categoryTranslationDefaultEnglish','child'])
                    // ->where('parent_id',NULL)
                    ->where('is_active',1)
                    ->orderBy('is_active','DESC')
                    ->orderBy('id','DESC')
                    ->get();
@endphp
