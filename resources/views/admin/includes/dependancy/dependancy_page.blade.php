<select name="page_id" id="page_id" class="col-md-12 form-control">
    <option value="">{{__('-- Select Page --')}}</option>
    @foreach ($pages as $item)
        @forelse ($item->pageTranslations as $key => $value)
            @if ($key<1)
                @if ($value->locale==$locale)
                    <option value="{{$item->id}}">{{$value->page_name}}</option>
                @elseif($value->locale=='en')
                    <option value="{{$item->id}}">{{$value->page_name}}</option>
                @endif
            @endif
        @empty
            <option value="">{{__('NULL')}}</option>
        @endforelse
    @endforeach
</select>
