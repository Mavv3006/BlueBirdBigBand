@if(isset($seoMetaDto->title))
    <title>{{ $seoMetaDto->title }} | Blue Bird Big Band</title>
@else
    <title>Blue Bird Big Band</title>
@endif

@if(isset($seoMetaDto->description))
    <meta property="description" content="{{ $seoMetaDto->description }}"/>
@endif
