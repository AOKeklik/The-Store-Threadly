<label for="attribute_name">Name*</label>
<select class="form-control select2" id="attribute_id" name="attribute_id">
    <option value=""></option>
    @foreach($attributes as $attr)
        <option 
            @if(isset($attributeValue) && $attributeValue->attribute_id == $attr->id) selected @endif
            value="{{  $attr->id }}"
        >{{  $attr->name }}</option>
    @endforeach
</select>
<small data-app-alert="attribute_id" class="form-text text-danger"></small>