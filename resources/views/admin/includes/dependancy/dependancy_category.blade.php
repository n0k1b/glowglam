<select name="category_id" id="category_id" class="col-md-12 form-control">
    <option value="">{{__('-- Select Category --')}}</option>
    @foreach ($categories as $item)
        @forelse ($item->categoryTranslation as $key => $value)
            @if ($key<1)
                @if ($value->local==$locale)
                    <option value="{{$item->id}}">{{$value->category_name}}</option>
                @elseif($value->local=='en')
                    <option value="{{$item->id}}">{{$value->category_name}}</option>
                @endif
            @endif
        @empty
            <option value="">{{__('NULL')}}</option>
        @endforelse
    @endforeach
</select>
