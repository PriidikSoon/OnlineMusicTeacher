@include('head')
<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div>
        <label for="type">Type</label>
        <input class="form-control" type="text" name="type" id="type" tabindex="1" value="{{ $exercise->type }}">
    </div>
    <div>
        <label for="title">Title</label>
        <input class="form-control" type="text" name="title" id="title" tabindex="1" value="{{ $exercise->title }}">
    </div>
    <div>
        <label for="author">Author</label>
        <input class="form-control" type="text" name="author" id="author" tabindex="1" value="{{ $exercise->author }}">
    </div>
    <div>
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" tabindex="1">{{ $exercise->description }}</textarea>
    </div>
    <div>
        <label for="category">Category</label>
        <input class="form-control" type="text" name="category" id="category" tabindex="1" value="{{ $exercise->category }}">
    </div><div>
        <label for="tags">Tags</label>
        <input class="form-control" type="text" name="tags" id="tags" tabindex="1" value="{{ $exercise->tags }}">
    </div>
    <div id="musicSheet" style=""></div>
    <div class="form-group">
        <input type="submit" tabindex="1" class="form-control btn btn-register" value="Save">
    </div>
</form>
@include('footer');

<script>
    $(function(){
        VEXUTIL.importFromXML({{ $exercise->user_id }},'{{ $exercise->file_link }}');
    });
</script>