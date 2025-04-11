<label for="name">Parent</label>
<select class="form-control select2" id="parent_id" name="parent_id">
    <option value=""></option>
    @foreach($categories as $cat)
        <option @if(isset($category) && $category->parent_id == $cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->name }}</option>
    @endforeach
</select>
<small data-app-alert="parent_id" class="form-text text-danger"></small>