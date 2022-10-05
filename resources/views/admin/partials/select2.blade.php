<div class="form-group">
    <label for="link_video">{{ isset($label) && $label ? $label : __('Link Video') }}</label>
    <select id="link_video" name="{{ isset($name) && $name ? $name : 'link_video' }}" class="admin-select2 custom-select">
        @if(isset($options))
            @foreach($options as $option)
                <option value="{{ $option }}"
                    {!! isset($selected) && $selected && $selected == $option ? 'selected' : '' !!}>
                    {{ $option }}
                </option>
            @endforeach
        @else
            <option value="">{{ __('No options !') }}</option>
        @endif
    </select>
</div>

@section('styles')
    @parent
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }
    </style>
@endsection
@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.admin-select2').select2();
        });
    </script>
@endsection
