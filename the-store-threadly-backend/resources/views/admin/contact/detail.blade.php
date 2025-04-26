<div class="form-group row bdb1 pt_10 mb_0">
    <div class="col-md-4"><label class="form-label">Name</label></div>
    <div class="col-md-8">{{ $contact->name }}</div>
</div>
<div class="form-group row bdb1 pt_10 mb_0">
    <div class="col-md-4"><label class="form-label">Email</label></div>
    <div class="col-md-8">{{ $contact->email }}</div>
</div>
<div class="form-group row bdb1 pt_10 mb_0">
    <div class="col-md-4"><label class="form-label">Subject</label></div>
    <div class="col-md-8">{{ $contact->subject }}</div>
</div>
<div class="form-group row pt_10 mb_0">
    <div class="col-md-4"><label class="form-label">Message</label></div>
    <div class="col-md-8">{{ $contact->message }}</div>
</div>