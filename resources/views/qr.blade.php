
<form action="{{route('qr')}}" method="post">
    @csrf
    <label for="data">data: </label>
    <input type="text" name="data" id=""><br>
    <label for="filename">filename: </label>
    <input type="text" name="filename" id=""><br>
    <input type="submit" value="submit">
</form>
