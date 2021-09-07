@extends('layouts.master')
<script src="https://cdn.ckeditor.com/ckeditor5/29.2.0/classic/ckeditor.js"></script>
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('title')
    Post | UTPA News
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 p-2">Post</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Post</li>
                        </ol>
                    </div><!-- /.col -->
                    <div class="col-12">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                {{session('success')}}
                            </div>
                        @endif
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Tên bài viết</th>
                                        <th style="width: 100px" class="text-center">Danh mục</th>
                                        <th class="text-center">Mô tả</th>
                                        <th class="text-center">Duyệt lúc</th>
                                        <th style="width: 65px"></th>
                                        <th style="width: 79px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{$post->post_title}}</td>
                                            <td>{{$post->category->name}}</td>
                                            <td>{{$post->post_description}}</td>
                                            <td>{{$post->published_at}}</td>
                                            <td><label class="switch">
                                                    <input data-id="{{$post->id}}" name="post_status" class="post_status" type="checkbox" @if($post->post_status == 1) checked @endif>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <form action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm bg-gradient-danger">Xóa</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="card-footer clearfix">
                                    <button  data-toggle="modal" data-target="#modal-add" class="btn btn-sm bg-gradient-success">Thêm bài viết</button>
                                    <div class="modal fade" id="modal-add" style="padding-right: 17px;" aria-modal="true" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Thêm bài viết</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('post.store')}}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for=""> Tên bài viết</label>
                                                                <input type="text" class="form-control" name="name" onkeyup="ChangeToSlug()" id="name" placeholder="Nhập tên danh mục" autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""> Danh mục</label>
                                                                <select name="category" id="">
                                                                    <option value="">Chọn danh mục</option>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""> Mô tả</label>
                                                                <input type="text" class="form-control" name="desc" id="" placeholder="Nhập mô tả" autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""> Hình ảnh</label>
                                                                <input type="file" name="image[]" multiple>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for=""> Nội dung</label>
                                                                <textarea name="content" id="content" cols="58" rows="5"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputPassword1"> Slug</label>
                                                                <input type="text" class="form-control" name="slug" id="slug" placeholder="Nhập slug">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Trở về</button>
                                                            <button type="submit" class="btn btn-outline-success">Thêm bài viết</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </div>

                                    <ul class="pagination pagination-sm m-0 float-right">

                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
           $('.post_status').change(function(e){
               var status =$(this).prop('checked') == true ? 1 : 0;
               var id = $(this).data('id');
               var _token = $('meta[name="csrf-token"]').attr('content');
               $.ajax({
                   url:'{{url('admin/checkStatusPost')}}',
                   method:'POST',
                   data:{status:status,id:id,_token:_token},
                   success:function() {

                   }
               });
           })
        });
        function ChangeToSlug()
        {
            var slug;
            //Lấy text từ thẻ input title
            slug = document.getElementById("name").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('slug').value = slug;
        }
        function ChangeToSlugUpdate()
        {
            var slug;
            //Lấy text từ thẻ input title
            slug = document.getElementById("name_update").value;
            slug = slug.toLowerCase();
            //Đổi ký tự có dấu thành không dấu
            slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
            slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
            slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
            slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
            slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
            slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
            slug = slug.replace(/đ/gi, 'd');
            //Xóa các ký tự đặt biệt
            slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
            //Đổi khoảng trắng thành ký tự gạch ngang
            slug = slug.replace(/ /gi, "-");
            //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
            //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
            slug = slug.replace(/\-\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-\-/gi, '-');
            slug = slug.replace(/\-\-\-/gi, '-');
            slug = slug.replace(/\-\-/gi, '-');
            //Xóa các ký tự gạch ngang ở đầu và cuối
            slug = '@' + slug + '@';
            slug = slug.replace(/\@\-|\-\@|\@/gi, '');
            //In slug ra textbox có id “slug”
            document.getElementById('slug_update').value = slug;
        }
    </script>
@endsection
