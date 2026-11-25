<select class="form-control" data-live-search="true" data-size="10" id="talk_id" name="talk_id" required onchange="changeTalkData(this)">
    @foreach($talks as $talk)
        <option value="{{$talk['id']}}" data-is-anonym="{{ $talk['anonym_call'] }}" data-duration="{{ $talk['duration'] }}" data-call-type="{{ $talk['call_type'] }}">{{ $talk['headline'] }}</option>
    @endforeach
</select>
